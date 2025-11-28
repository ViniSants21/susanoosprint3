<?php
// Processamento de produtos: conectar, inserir, atualizar, excluir
require_once 'conexao.php';

function find_products_table($conn) {
    $candidates = ['products', 'produtos', 'produts'];
    foreach ($candidates as $t) {
        $res = $conn->query("SHOW TABLES LIKE '" . $conn->real_escape_string($t) . "'");
        if ($res && $res->num_rows > 0) return $t;
    }
    // fallback
    return 'products';
}

$table = find_products_table($conn);

// Handle POST actions (save = insert/update, delete)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'save') {
        $id = !empty($_POST['product_id']) ? intval($_POST['product_id']) : null;
        $name = $_POST['product-name'] ?? '';
        $sku = $_POST['product-sku'] ?? '';
        $category = $_POST['product-category'] ?? '';
        $status = $_POST['product-status'] ?? 'ativo';
        $price = isset($_POST['product-price']) ? floatval($_POST['product-price']) : 0;
        $stock = isset($_POST['product-stock']) ? intval($_POST['product-stock']) : 0;
        $description = $_POST['product-description'] ?? '';

        // Tratamento de upload de imagem (mais robusto e com log)
        $imagePath = null;
        if (isset($_FILES['product-image'])) {
            $file = $_FILES['product-image'];
            if ($file['error'] === UPLOAD_ERR_OK && !empty($file['tmp_name'])) {
                $uploadDir = __DIR__ . '/../assets/img/products/';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }
                $tmp = $file['tmp_name'];
                $orig = basename($file['name']);
                $ext = pathinfo($orig, PATHINFO_EXTENSION);
                $filename = time() . '_' . bin2hex(random_bytes(6)) . ($ext ? ".{$ext}" : '');
                $dest = $uploadDir . $filename;

                // tentativa principal
                $moved = @move_uploaded_file($tmp, $dest);
                if (!$moved) {
                    // fallback para copy se move_uploaded_file falhar
                    $copied = @copy($tmp, $dest);
                    if ($copied) {
                        $moved = true;
                        // tentar remover arquivo temporário
                        @unlink($tmp);
                    }
                }

                if ($moved && file_exists($dest)) {
                    // salvar caminho relativo usado nas views
                    $imagePath = 'assets/img/products/' . $filename;
                } else {
                    // registrar erro para diagnóstico
                    $err = isset($file['error']) ? $file['error'] : 'unknown';
                    $log = sprintf("[%s] Upload failed. error=%s tmp=%s dest=%s\n", date('Y-m-d H:i:s'), $err, $tmp, $dest);
                    @file_put_contents(__DIR__ . '/../assets/img/upload_errors.log', $log, FILE_APPEND);
                }
            } elseif (isset($file['error']) && $file['error'] !== UPLOAD_ERR_NO_FILE) {
                // registrar outros erros (ex: UPLOAD_ERR_INI_SIZE)
                $log = sprintf("[%s] Upload error code: %s name=%s tmp=%s\n", date('Y-m-d H:i:s'), $file['error'], $file['name'] ?? '', $file['tmp_name'] ?? '');
                @file_put_contents(__DIR__ . '/../assets/img/upload_errors.log', $log, FILE_APPEND);
            }
        }

        // Descobrir colunas existentes na tabela para evitar erros quando colunas faltam
        $tableCols = [];
        $resCols = $conn->query("SHOW COLUMNS FROM `$table`");
        if ($resCols) {
            while ($c = $resCols->fetch_assoc()) {
                $tableCols[] = $c['Field'];
            }
            $resCols->free();
        }

        // Mapeamento de campos possíveis e tipos para bind_param
        // Suporta tanto 'description' quanto 'descricao' como coluna de descrição
        $allowed = [
            'name' => 's', 'sku' => 's', 'category' => 's', 'status' => 's',
            'price' => 'd', 'stock' => 'i', 'description' => 's', 'descricao' => 's', 'image' => 's'
        ];

        $fields = [];
        $values = [];
        $types = '';
        foreach ($allowed as $col => $typeChar) {
            if (in_array($col, $tableCols)) {
                // Não sobrescrever a imagem existente em UPDATE quando nenhum arquivo novo foi enviado
                if ($col === 'image' && $id && $imagePath === null) {
                    continue;
                }
                $fields[] = $col;
                $types .= $typeChar;
                switch ($col) {
                    case 'name': $values[] = $name; break;
                    case 'sku': $values[] = $sku; break;
                    case 'category': $values[] = $category; break;
                    case 'status': $values[] = $status; break;
                    case 'price': $values[] = $price; break;
                    case 'stock': $values[] = $stock; break;
                    case 'description': $values[] = $description; break;
                    case 'descricao': $values[] = $description; break;
                    case 'image': $values[] = $imagePath; break;
                    default: $values[] = null; break;
                }
            }
        }

        if (empty($fields)) {
            // Nenhuma coluna mapeada disponível — abortar com mensagem simples
            header('Location: produtos_admin.php');
            exit;
        }

        if ($id) {
            // UPDATE dinâmico
            $setParts = [];
            foreach ($fields as $f) { $setParts[] = "`$f` = ?"; }
            $sql = "UPDATE `$table` SET " . implode(', ', $setParts) . ", updated_at = NOW() WHERE id = ?";
            $stmt = $conn->prepare($sql);
            if ($stmt) {
                // preparar parâmetros por referência
                $bindTypes = $types . 'i';
                $refs = [];
                $refs[] = &$bindTypes;
                for ($i = 0; $i < count($values); $i++) { $refs[] = &$values[$i]; }
                $refs[] = &$id;
                call_user_func_array(array($stmt, 'bind_param'), $refs);
                $stmt->execute();
                // log resultado para diagnóstico de imagem
                $logLine = sprintf("[%s] UPDATE id=%s imagePath=%s affected=%s err=%s\n", date('Y-m-d H:i:s'), $id, $imagePath ?? 'NULL', $stmt->affected_rows, $stmt->error);
                @file_put_contents(__DIR__ . '/../assets/img/upload_debug.log', $logLine, FILE_APPEND);
                $stmt->close();
            }
        } else {
            // INSERT dinâmico
            $placeholders = implode(', ', array_fill(0, count($fields), '?'));
            $colsSql = implode(', ', array_map(function($c){ return "`$c`"; }, $fields));
            $sql = "INSERT INTO `$table` ($colsSql) VALUES ($placeholders)";
            $stmt = $conn->prepare($sql);
            if ($stmt) {
                $bindTypes = $types;
                $refs = [];
                $refs[] = &$bindTypes;
                for ($i = 0; $i < count($values); $i++) { $refs[] = &$values[$i]; }
                call_user_func_array(array($stmt, 'bind_param'), $refs);
                $stmt->execute();
                // log resultado para diagnóstico
                $insertId = $conn->insert_id;
                $logLine = sprintf("[%s] INSERT id=%s imagePath=%s affected=%s err=%s\n", date('Y-m-d H:i:s'), $insertId, $imagePath ?? 'NULL', $stmt->affected_rows, $stmt->error);
                @file_put_contents(__DIR__ . '/../assets/img/upload_debug.log', $logLine, FILE_APPEND);
                $stmt->close();
            }
        }

        header('Location: produtos_admin.php');
        exit;
    }

    if ($action === 'delete') {
        $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
        if ($id) {
            $stmt = $conn->prepare("DELETE FROM `$table` WHERE id = ?");
            $stmt->bind_param('i', $id);
            $stmt->execute();
            $stmt->close();
            // respond for fetch
            echo json_encode(['success' => true]);
            exit;
        }
        echo json_encode(['success' => false, 'error' => 'ID inválido']);
        exit;
    }
}

// Fetch products for table rendering
$products_result = $conn->query("SELECT * FROM `$table` ORDER BY id DESC");

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Produtos - Susanoo Admin</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script>
        (function(){
            const theme = localStorage.getItem('theme');
            if(theme === 'light') {
                document.documentElement.classList.add('light-mode');
            }
        })();
    </script>
    <style>
        /* ===== ESTILOS DO PAINEL ADMIN ===== */
        .admin-dashboard {
            background-color: var(--bg-primary);
            min-height: 100vh;
            padding-top: 80px;
        }
        
        .admin-container {
            display: flex;
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 20px;
        }
        
        /* Sidebar */
        .admin-sidebar {
            width: 280px;
            background: var(--bg-card);
            border-radius: 20px;
            padding: 2rem 1.5rem;
            margin-right: 2rem;
            height: fit-content;
            position: sticky;
            top: 100px;
            box-shadow: var(--shadow-soft);
            border: 1px solid rgba(139, 92, 246, 0.1);
        }
        
        .admin-logo {
            text-align: center;
            margin-bottom: 2rem;
            padding-bottom: 1.5rem;
            border-bottom: 1px solid var(--border-color);
        }
        
        .admin-logo h2 {
            font-family: var(--font-display);
            color: var(--primary-purple);
            margin: 0;
            font-size: 1.8rem;
        }
        
        .admin-logo span {
            color: var(--text-secondary);
            font-size: 0.9rem;
        }
        
        .admin-nav {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        
        .admin-nav li {
            margin-bottom: 0.5rem;
        }
        
        .admin-nav a {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1rem 1.2rem;
            text-decoration: none;
            color: var(--text-secondary);
            border-radius: 12px;
            transition: all 0.3s ease;
            font-weight: 500;
        }
        
        .admin-nav a:hover,
        .admin-nav a.active {
            background: rgba(139, 92, 246, 0.1);
            color: var(--primary-purple);
            transform: translateX(5px);
        }
        
        .admin-nav a i {
            width: 20px;
            text-align: center;
            font-size: 1.1rem;
        }
        
        /* Conteúdo Principal */
        .admin-main {
            flex: 1;
            padding-bottom: 3rem;
        }
        
        .admin-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            padding-bottom: 1.5rem;
            border-bottom: 1px solid var(--border-color);
        }
        
        .admin-title {
            font-family: var(--font-display);
            font-size: 2.5rem;
            color: var(--text-primary);
            margin: 0;
        }
        
        .admin-actions {
            display: flex;
            gap: 1rem;
        }
        
        /* Produtos */
        .products-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }
        
        .search-box {
            position: relative;
            width: 300px;
        }
        
        .search-box input {
            width: 100%;
            padding: 0.8rem 1rem 0.8rem 2.5rem;
            border: 1px solid var(--border-color);
            border-radius: 10px;
            background: var(--bg-card);
            color: var(--text-primary);
            font-size: 0.9rem;
        }
        
        .search-box i {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
        }
        
        .data-table {
            width: 100%;
            background: var(--bg-card);
            border-radius: 15px;
            overflow: hidden;
            box-shadow: var(--shadow-soft);
            border: 1px solid rgba(139, 92, 246, 0.1);
        }
        
        .data-table table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .data-table th {
            background: rgba(139, 92, 246, 0.05);
            padding: 1.2rem 1rem;
            text-align: left;
            font-weight: 600;
            color: var(--text-primary);
            border-bottom: 1px solid var(--border-color);
        }
        
        .data-table td {
            padding: 1.2rem 1rem;
            border-bottom: 1px solid var(--border-color);
            color: var(--text-secondary);
        }
        
        .data-table tr:last-child td {
            border-bottom: none;
        }
        
        .data-table tr:hover {
            background: rgba(139, 92, 246, 0.02);
        }
        
        .status-badge {
            padding: 0.4rem 0.8rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
        }
        
        .status-active {
            background: rgba(16, 185, 129, 0.2);
            color: var(--success);
        }
        
        .status-inactive {
            background: rgba(239, 68, 68, 0.2);
            color: var(--error);
        }
        
        .action-buttons {
            display: flex;
            gap: 0.5rem;
        }
        
        .btn-icon {
            width: 35px;
            height: 35px;
            border: none;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s ease;
            font-size: 0.9rem;
        }
        
        .btn-edit {
            background: rgba(59, 130, 246, 0.1);
            color: #3b82f6;
        }
        
        .btn-delete {
            background: rgba(239, 68, 68, 0.1);
            color: var(--error);
        }
        
        .btn-view {
            background: rgba(139, 92, 246, 0.1);
            color: var(--primary-purple);
        }
        
        .btn-edit:hover {
            background: #3b82f6;
            color: white;
        }
        
        .btn-delete:hover {
            background: var(--error);
            color: white;
        }
        
        .btn-view:hover {
            background: var(--primary-purple);
            color: white;
        }
        
        .user-info {
            display: flex;
            align-items: center;
        }
        
        .user-avatar {
            width: 50px;
            height: 50px;
            border-radius: 10px;
            object-fit: cover;
            margin-right: 1rem;
        }
        
        .user-details h4 {
            margin: 0 0 0.2rem 0;
            color: var(--text-primary);
        }
        
        .user-details span {
            font-size: 0.85rem;
            color: var(--text-muted);
        }
        
        /* Modal */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            align-items: center;
            justify-content: center;
        }
        
        .modal.active {
            display: flex;
        }
        
        .modal-content {
            background: var(--bg-card);
            border-radius: 20px;
            padding: 2rem;
            width: 90%;
            max-width: 600px;
            max-height: 90vh;
            overflow-y: auto;
            box-shadow: var(--shadow-strong);
        }
        
        .modal-header {
            display: flex;
            justify-content: between;
            align-items: center;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid var(--border-color);
        }
        
        .modal-title {
            font-size: 1.5rem;
            color: var(--text-primary);
            margin: 0;
        }
        
        .close-modal {
            background: none;
            border: none;
            font-size: 1.5rem;
            color: var(--text-muted);
            cursor: pointer;
        }
        
        .form-group {
            margin-bottom: 1.5rem;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            color: var(--text-primary);
            font-weight: 500;
        }
        
        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 0.8rem 1rem;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            background: var(--bg-primary);
            color: var(--text-primary);
            font-size: 0.9rem;
            transition: all 0.3s ease;
        }
        
        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: var(--primary-purple);
            box-shadow: 0 0 0 3px rgba(139, 92, 246, 0.1);
        }
        
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }
        
        .image-upload {
            border: 2px dashed var(--border-color);
            border-radius: 10px;
            padding: 2rem;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .image-upload:hover {
            border-color: var(--primary-purple);
        }
        
        .image-upload i {
            font-size: 2rem;
            color: var(--text-muted);
            margin-bottom: 1rem;
        }
        
        /* Responsividade */
        @media (max-width: 1024px) {
            .admin-container {
                flex-direction: column;
            }
            
            .admin-sidebar {
                width: 100%;
                margin-right: 0;
                margin-bottom: 2rem;
                position: static;
            }
        }
        
        @media (max-width: 768px) {
            .admin-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
            }
            
            .admin-actions {
                width: 100%;
                justify-content: space-between;
            }
            
            .products-header {
                flex-direction: column;
                gap: 1rem;
                align-items: flex-start;
            }
            
            .search-box {
                width: 100%;
            }
            
            .data-table {
                overflow-x: auto;
            }
            
            .form-row {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body class="admin-dashboard">

<!-- Navbar -->
<nav class="navbar scrolled" id="navbar">
    <div class="nav-container">
        <div class="nav-search">
            <input type="text" placeholder="Pesquisar...">
        </div>
        <div class="nav-logo">
            <img src="../assets/logo.png" alt="Susanoo">
        </div>
        <div class="nav-right-group">
            <ul class="nav-menu">
                <li><a href="../index.php" class="nav-link">Início</a></li>
                <li><a href="../produtos.php" class="nav-link">Produtos</a></li>
                <li><a href="../sobre.php" class="nav-link">Sobre</a></li>
                <li><a href="../contato.php" class="nav-link">Contato</a></li>
            </ul>
            <div class="nav-icons">
                <a href="#" class="nav-icon-link"><i class="fas fa-shopping-cart"></i></a>
                <a href="#" class="nav-icon-link"><i class="fas fa-user"></i></a>
            </div>
        </div>
    </div>
</nav>

<div class="admin-container">
    <!-- Sidebar -->
    <aside class="admin-sidebar">
        <div class="admin-logo">
            <h2>Susanoo Admin</h2>
            <span>Painel de Controle</span>
        </div>
        <ul class="admin-nav">
            <li><a href="admin.php"><i class="fas fa-chart-pie"></i> Dashboard</a></li>
            <li><a href="produtos_admin.php" class="active"><i class="fas fa-box"></i> Produtos</a></li>
            <li><a href="usuarios_admin.php"><i class="fas fa-users"></i> Usuários</a></li>
            <li><a href="#"><i class="fas fa-shopping-cart"></i> Pedidos</a></li>
            <li><a href="#"><i class="fas fa-chart-line"></i> Relatórios</a></li>
            <li><a href="#"><i class="fas fa-cog"></i> Configurações</a></li>
            <li><a href="../index.php"><i class="fas fa-sign-out-alt"></i> Voltar ao Site</a></li>
        </ul>
    </aside>

    <!-- Conteúdo Principal -->
    <main class="admin-main">
        <div class="admin-header">
            <h1 class="admin-title">Gerenciar Produtos</h1>
            <div class="admin-actions">
                <button class="btn btn-primary" id="add-product">
                    <i class="fas fa-plus"></i> Adicionar Produto
                </button>
                <button class="btn btn-secondary" id="export-products">
                    <i class="fas fa-download"></i> Exportar
                </button>
            </div>
        </div>

        <div class="products-header">
            <div class="search-box">
                <i class="fas fa-search"></i>
                <input type="text" placeholder="Buscar produtos..." id="search-products">
            </div>
            <div class="filter-options">
                <select id="category-filter">
                    <option value="">Todas as categorias</option>
                    <option value="camisetas">Camisetas</option>
                    <option value="moletons">Moletons</option>
                    <option value="acessorios">Acessórios</option>
                    <option value="colecoes">Coleções</option>
                </select>
                <select id="status-filter">
                    <option value="">Todos os status</option>
                    <option value="ativo">Ativo</option>
                    <option value="inativo">Inativo</option>
                </select>
            </div>
        </div>

        <div class="data-table">
            <table>
                <thead>
                    <tr>
                        <th>Produto</th>
                        <th>Categoria</th>
                        <th>Status</th>
                        <th>Preço</th>
                        <th>Estoque</th>
                        <th>Vendas</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                <?php if ($products_result && $products_result->num_rows > 0): ?>
                    <?php while ($row = $products_result->fetch_assoc()): ?>
                        <?php $statusClass = (strtolower($row['status']) === 'ativo') ? 'status-active' : 'status-inactive'; ?>
                        <?php $price = number_format($row['price'], 2, ',', '.'); ?>
                        <tr data-id="<?php echo $row['id']; ?>" data-image="<?php echo isset($row['image']) ? htmlspecialchars($row['image']) : ''; ?>" data-description="<?php echo isset($row['description']) ? htmlspecialchars($row['description']) : (isset($row['descricao']) ? htmlspecialchars($row['descricao']) : ''); ?>">
                                <td>
                                    <div class="user-info">
                                        <?php $imgSrc = !empty($row['image']) ? '../' . $row['image'] : '../assets/img/placeholder.png'; ?>
                                        <img src="<?php echo $imgSrc; ?>" alt="<?php echo htmlspecialchars($row['name']); ?>" class="user-avatar">
                                        <div class="user-details">
                                            <h4><?php echo htmlspecialchars($row['name']); ?></h4>
                                            <span>SKU: <?php echo isset($row['sku']) ? htmlspecialchars($row['sku']) : '-'; ?></span>
                                            <?php $descToShow = isset($row['description']) && $row['description'] !== '' ? $row['description'] : (isset($row['descricao']) ? $row['descricao'] : ''); ?>
                                            <p class="small-desc" style="margin:4px 0 0 0; color:var(--text-muted); font-size:0.85rem;"><?php echo $descToShow !== '' ? htmlspecialchars(mb_strimwidth($descToShow, 0, 120, '...')) : ''; ?></p>
                                        </div>
                                    </div>
                                </td>
                            <td><?php echo htmlspecialchars($row['category']); ?></td>
                            <td><span class="status-badge <?php echo $statusClass; ?>"><?php echo htmlspecialchars($row['status']); ?></span></td>
                            <td>R$ <?php echo $price; ?></td>
                            <td><?php echo intval($row['stock']); ?></td>
                            <td>—</td>
                            <td>
                                <div class="action-buttons">
                                    <button data-id="<?php echo $row['id']; ?>" class="btn-icon btn-view" title="Visualizar"><i class="fas fa-eye"></i></button>
                                    <button data-id="<?php echo $row['id']; ?>" class="btn-icon btn-edit" title="Editar"><i class="fas fa-edit"></i></button>
                                    <button data-id="<?php echo $row['id']; ?>" class="btn-icon btn-delete" title="Excluir"><i class="fas fa-trash"></i></button>
                                </div>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="7">Nenhum produto encontrado.</td></tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </main>
</div>

<!-- Modal Adicionar/Editar Produto -->
<div class="modal" id="product-modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title" id="modal-title">Adicionar Produto</h3>
            <button class="close-modal">&times;</button>
        </div>
        <form id="product-form" method="post" enctype="multipart/form-data">
            <input type="hidden" name="action" value="save">
            <input type="hidden" name="product_id" id="product-id" value="">
            <div class="form-group">
                <label for="product-image">Imagem do Produto</label>
                <div class="image-upload" id="image-upload">
                    <i class="fas fa-cloud-upload-alt"></i>
                    <p>Clique para fazer upload da imagem</p>
                    <input type="file" id="product-image" name="product-image" accept="image/*" style="display: none;">
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="product-name">Nome do Produto</label>
                    <input type="text" id="product-name" name="product-name" required>
                </div>
                <div class="form-group">
                    <label for="product-sku">SKU</label>
                    <input type="text" id="product-sku" name="product-sku">
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="product-category">Categoria</label>
                    <select id="product-category" name="product-category" required>
                        <option value="">Selecione uma categoria</option>
                        <option value="camisetas">Camisetas</option>
                        <option value="moletons">Moletons</option>
                        <option value="acessorios">Acessórios</option>
                        <option value="colecoes">Coleções</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="product-status">Status</label>
                    <select id="product-status" name="product-status" required>
                        <option value="ativo">Ativo</option>
                        <option value="inativo">Inativo</option>
                    </select>
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="product-price">Preço (R$)</label>
                    <input type="number" id="product-price" name="product-price" step="0.01" required>
                </div>
                <div class="form-group">
                    <label for="product-stock">Estoque</label>
                    <input type="number" id="product-stock" name="product-stock" required>
                </div>
            </div>
            
            <div class="form-group">
                <label for="product-description">Descrição</label>
                <textarea id="product-description" name="product-description" rows="4"></textarea>
            </div>
            
            <div class="admin-actions" style="margin-top: 2rem;">
                <button type="button" class="btn btn-secondary close-modal">Cancelar</button>
                <button type="submit" class="btn btn-primary">Salvar Produto</button>
            </div>
        </form>
    </div>
</div>

<script src="../js/script.js"></script>
<script>
    // Controle do Modal
    const modal = document.getElementById('product-modal');
    const addProductBtn = document.getElementById('add-product');
    const closeModalBtns = document.querySelectorAll('.close-modal');
    const imageUpload = document.getElementById('image-upload');
    const productImage = document.getElementById('product-image');

    // Abrir modal
    addProductBtn.addEventListener('click', () => {
        modal.classList.add('active');
        document.getElementById('modal-title').textContent = 'Adicionar Produto';
        document.getElementById('product-form').reset();
    });

    // Fechar modal (listener configurado abaixo)

    // Fechar modal
    closeModalBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            modal.classList.remove('active');
        });
    });

    // Fechar modal clicando fora
    modal.addEventListener('click', (e) => {
        if (e.target === modal) {
            modal.classList.remove('active');
        }
    });

    // Upload de imagem
    imageUpload.addEventListener('click', () => {
        productImage.click();
    });

    productImage.addEventListener('change', (e) => {
        if (e.target.files.length > 0) {
            const fileName = e.target.files[0].name;
            imageUpload.innerHTML = `
                <i class="fas fa-check" style="color: var(--success);"></i>
                <p>${fileName}</p>
                <small>Clique para alterar</small>
            `;
        }
    });

    // Busca de produtos
    const searchInput = document.getElementById('search-products');
    if (searchInput) searchInput.addEventListener('input', filterProducts);

    // Filtros
    const categoryFilter = document.getElementById('category-filter');
    const statusFilter = document.getElementById('status-filter');
    if (categoryFilter) categoryFilter.addEventListener('change', filterProducts);
    if (statusFilter) statusFilter.addEventListener('change', filterProducts);

    function filterProducts() {
        const searchTerm = (searchInput?.value || '').toLowerCase();
        const categoryValue = categoryFilter?.value || '';
        const statusValue = statusFilter?.value || '';

        const rows = document.querySelectorAll('.data-table tbody tr');

        rows.forEach(row => {
            const productNameEl = row.querySelector('.user-details h4');
            const productName = productNameEl ? productNameEl.textContent.toLowerCase() : '';
            const category = (row.cells[1]?.textContent || '').toLowerCase();
            const status = (row.cells[2]?.textContent || '').toLowerCase();

            const matchesSearch = productName.includes(searchTerm);
            const matchesCategory = !categoryValue || category.includes(categoryValue);
            const matchesStatus = !statusValue || status.includes(statusValue);

            if (matchesSearch && matchesCategory && matchesStatus) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    // Ações dos botões: editar e excluir
    document.querySelectorAll('.btn-edit').forEach(btn => {
        btn.addEventListener('click', function() {
            const row = this.closest('tr');
            const id = row.getAttribute('data-id');
            const productName = row.querySelector('.user-details h4').textContent;
            const category = row.cells[1].textContent.trim();
            const status = row.cells[2].textContent.trim();
            const priceText = row.cells[3].textContent.replace('R$', '').replace('.', '').replace(',', '.').trim();
            const stock = row.cells[4].textContent.trim();
            const desc = row.getAttribute('data-description') || '';
            const dataImage = row.getAttribute('data-image') || '';

            document.getElementById('modal-title').textContent = `Editar ${productName}`;
            document.getElementById('product-id').value = id;
            document.getElementById('product-name').value = productName;
            document.getElementById('product-sku').value = row.querySelector('.user-details span') ? row.querySelector('.user-details span').textContent.replace('SKU:','').trim() : '';
            document.getElementById('product-category').value = category;
            document.getElementById('product-status').value = status.toLowerCase();
            document.getElementById('product-price').value = parseFloat(priceText) || 0;
            document.getElementById('product-stock').value = parseInt(stock) || 0;
            document.getElementById('product-description').value = desc;

            // Mostrar preview do nome do arquivo da imagem (se existir)
            if (dataImage) {
                const filename = dataImage.split('/').pop();
                imageUpload.innerHTML = `\n                    <i class="fas fa-check" style="color: var(--success);"></i>\n                    <p>${filename}</p>\n                    <small>Clique para alterar</small>\n                `;
            } else {
                imageUpload.innerHTML = `\n                    <i class="fas fa-cloud-upload-alt"></i>\n                    <p>Clique para fazer upload da imagem</p>\n                    <input type="file" id="product-image" name="product-image" accept="image/*" style="display: none;">\n                `;
                // rebind productImage after replacing innerHTML
                const newProductImage = document.getElementById('product-image');
                if (newProductImage) {
                    newProductImage.addEventListener('change', (e) => {
                        if (e.target.files.length > 0) {
                            const fileName = e.target.files[0].name;
                            imageUpload.innerHTML = `\n                                <i class="fas fa-check" style="color: var(--success);"></i>\n                                <p>${fileName}</p>\n                                <small>Clique para alterar</small>\n                            `;
                        }
                    });
                }
            }

            modal.classList.add('active');
        });
    });

    document.querySelectorAll('.btn-delete').forEach(btn => {
        btn.addEventListener('click', function() {
            const row = this.closest('tr');
            const id = row.getAttribute('data-id');
            const productName = row.querySelector('.user-details h4').textContent;

            if (!id) return;
            if (!confirm(`Tem certeza que deseja excluir o produto "${productName}"?`)) return;

            const formData = new FormData();
            formData.append('action', 'delete');
            formData.append('id', id);

            fetch('produtos_admin.php', { method: 'POST', body: formData })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        row.remove();
                        showNotification('Produto excluído com sucesso!', 'success');
                    } else {
                        showNotification('Erro ao excluir produto.', 'error');
                    }
                })
                .catch(() => showNotification('Erro na requisição.', 'error'));
        });
    });

    // Função de notificação
    function showNotification(message, type) {
        const notification = document.createElement('div');
        notification.style.cssText = `
            position: fixed;
            top: 100px;
            right: 20px;
            background: ${type === 'success' ? 'var(--success)' : 'var(--error)'};
            color: white;
            padding: 1rem 1.5rem;
            border-radius: 10px;
            z-index: 10000;
            box-shadow: var(--shadow-medium);
            animation: slideIn 0.3s ease;
        `;
        notification.textContent = message;
        document.body.appendChild(notification);
        
        setTimeout(() => {
            notification.remove();
        }, 3000);
    }

    // Exportar produtos
    document.getElementById('export-products').addEventListener('click', function() {
        this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Exportando...';
        setTimeout(() => {
            this.innerHTML = '<i class="fas fa-download"></i> Exportar';
            showNotification('Produtos exportados com sucesso!', 'success');
        }, 1500);
    });
</script>
</body>
</html>