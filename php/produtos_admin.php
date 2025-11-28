<?php
// ==========================================
// LÓGICA PHP (BACKEND)
// ==========================================

require_once 'conexao.php';

// 1. Descobrir o nome correto da tabela
function find_products_table($conn) {
    $candidates = ['products', 'produtos', 'produts'];
    foreach ($candidates as $t) {
        $res = $conn->query("SHOW TABLES LIKE '" . $conn->real_escape_string($t) . "'");
        if ($res && $res->num_rows > 0) return $t;
    }
    return 'products';
}
$table = find_products_table($conn);

// 2. Processar Formulários
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    // --- SALVAR (INSERIR OU EDITAR) ---
    if ($action === 'save') {
        $id = !empty($_POST['product_id']) ? intval($_POST['product_id']) : null;
        $name = $_POST['product-name'] ?? '';
        $category = $_POST['product-category'] ?? '';
        $status = $_POST['product-status'] ?? 'ativo';
        $price = isset($_POST['product-price']) ? floatval($_POST['product-price']) : 0;
        $stock = isset($_POST['product-stock']) ? intval($_POST['product-stock']) : 0;
        $descricao = $_POST['product-description'] ?? '';

        // -- Upload de Imagem --
        $imagePathInDB = null;

        if (isset($_FILES['product-image']) && $_FILES['product-image']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = __DIR__ . '/../assets/img/products/';
            
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $ext = strtolower(pathinfo($_FILES['product-image']['name'], PATHINFO_EXTENSION));
            $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

            if (in_array($ext, $allowed)) {
                $newFileName = uniqid('prod_') . '.' . $ext;
                $destination = $uploadDir . $newFileName;

                if (move_uploaded_file($_FILES['product-image']['tmp_name'], $destination)) {
                    $imagePathInDB = 'assets/img/products/' . $newFileName;
                }
            }
        }

        // -- SQL E BIND_PARAM CORRIGIDOS --
        // Legenda dos tipos: s=string (texto), d=double (preço), i=integer (número inteiro)

        if ($id) {
            // >>> UPDATE (Edição)
            if ($imagePathInDB) {
                // Com imagem nova (8 variáveis)
                $sql = "UPDATE `$table` SET name=?, category=?, status=?, price=?, stock=?, descricao=?, image=?, updated_at=NOW() WHERE id=?";
                $stmt = $conn->prepare($sql);
                // Tipos: string, string, string, double, integer, string, string, integer
                $stmt->bind_param("sssdissi", $name, $category, $status, $price, $stock, $descricao, $imagePathInDB, $id);
            } else {
                // Sem imagem nova (7 variáveis)
                $sql = "UPDATE `$table` SET name=?, category=?, status=?, price=?, stock=?, descricao=?, updated_at=NOW() WHERE id=?";
                $stmt = $conn->prepare($sql);
                // Tipos: string, string, string, double, integer, string, integer
                $stmt->bind_param("sssdisi", $name, $category, $status, $price, $stock, $descricao, $id);
            }
            $stmt->execute();
            $stmt->close();
        } else {
            // >>> INSERT (Novo Produto)
            // 7 variáveis
            $sql = "INSERT INTO `$table` (name, category, status, price, stock, descricao, image, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, NOW())";
            $stmt = $conn->prepare($sql);
            // Tipos: string, string, string, double, integer, string, string
            $stmt->bind_param("sssdiss", $name, $category, $status, $price, $stock, $descricao, $imagePathInDB);
            $stmt->execute();
            $stmt->close();
        }

        header('Location: produtos_admin.php');
        exit;
    }

    // --- EXCLUIR ---
    if ($action === 'delete') {
        $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
        if ($id) {
            $stmt = $conn->prepare("DELETE FROM `$table` WHERE id = ?");
            $stmt->bind_param('i', $id);
            $stmt->execute();
            $stmt->close();
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false]);
        }
        exit;
    }
}

// 3. Buscar dados
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
        /* Estilos do Admin */
        .admin-dashboard { background-color: var(--bg-primary); min-height: 100vh; padding-top: 80px; }
        .admin-container { display: flex; max-width: 1400px; margin: 0 auto; padding: 0 20px; }
        .admin-sidebar { width: 280px; background: var(--bg-card); border-radius: 20px; padding: 2rem 1.5rem; margin-right: 2rem; height: fit-content; position: sticky; top: 100px; box-shadow: var(--shadow-soft); border: 1px solid rgba(139, 92, 246, 0.1); }
        .admin-logo { text-align: center; margin-bottom: 2rem; padding-bottom: 1.5rem; border-bottom: 1px solid var(--border-color); }
        .admin-logo h2 { font-family: var(--font-display); color: var(--primary-purple); margin: 0; font-size: 1.8rem; }
        .admin-nav { list-style: none; padding: 0; margin: 0; }
        .admin-nav li { margin-bottom: 0.5rem; }
        .admin-nav a { display: flex; align-items: center; gap: 1rem; padding: 1rem 1.2rem; text-decoration: none; color: var(--text-secondary); border-radius: 12px; transition: all 0.3s ease; font-weight: 500; }
        .admin-nav a:hover, .admin-nav a.active { background: rgba(139, 92, 246, 0.1); color: var(--primary-purple); transform: translateX(5px); }
        
        .admin-main { flex: 1; padding-bottom: 3rem; }
        .admin-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; padding-bottom: 1.5rem; border-bottom: 1px solid var(--border-color); }
        .admin-title { font-family: var(--font-display); font-size: 2.5rem; color: var(--text-primary); margin: 0; }
        .admin-actions { display: flex; gap: 1rem; }
        
        .products-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; }
        .search-box { position: relative; width: 300px; }
        .search-box input { width: 100%; padding: 0.8rem 1rem 0.8rem 2.5rem; border: 1px solid var(--border-color); border-radius: 10px; background: var(--bg-card); color: var(--text-primary); }
        .search-box i { position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: var(--text-muted); }
        
        .data-table { width: 100%; background: var(--bg-card); border-radius: 15px; overflow: hidden; box-shadow: var(--shadow-soft); border: 1px solid rgba(139, 92, 246, 0.1); }
        .data-table table { width: 100%; border-collapse: collapse; }
        .data-table th { background: rgba(139, 92, 246, 0.05); padding: 1.2rem 1rem; text-align: left; font-weight: 600; color: var(--text-primary); border-bottom: 1px solid var(--border-color); }
        .data-table td { padding: 1.2rem 1rem; border-bottom: 1px solid var(--border-color); color: var(--text-secondary); }
        .data-table tr:hover { background: rgba(139, 92, 246, 0.02); }
        
        .status-badge { padding: 0.4rem 0.8rem; border-radius: 20px; font-size: 0.8rem; font-weight: 600; }
        .status-active { background: rgba(16, 185, 129, 0.2); color: var(--success); }
        .status-inactive { background: rgba(239, 68, 68, 0.2); color: var(--error); }
        
        .action-buttons { display: flex; gap: 0.5rem; }
        .btn-icon { width: 35px; height: 35px; border: none; border-radius: 8px; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.2s ease; }
        .btn-edit { background: rgba(59, 130, 246, 0.1); color: #3b82f6; }
        .btn-delete { background: rgba(239, 68, 68, 0.1); color: var(--error); }
        .btn-edit:hover { background: #3b82f6; color: white; }
        .btn-delete:hover { background: var(--error); color: white; }
        
        .user-info { display: flex; align-items: center; }
        .user-avatar { width: 50px; height: 50px; border-radius: 10px; object-fit: cover; margin-right: 1rem; }
        .user-details h4 { margin: 0 0 0.2rem 0; color: var(--text-primary); }
        .user-details span { font-size: 0.85rem; color: var(--text-muted); }

        /* Modal */
        .modal { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.5); z-index: 1000; align-items: center; justify-content: center; }
        .modal.active { display: flex; }
        .modal-content { background: var(--bg-card); border-radius: 20px; padding: 2rem; width: 90%; max-width: 600px; max-height: 90vh; overflow-y: auto; box-shadow: var(--shadow-strong); }
        .modal-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; padding-bottom: 1rem; border-bottom: 1px solid var(--border-color); }
        .close-modal { background: none; border: none; font-size: 1.5rem; color: var(--text-muted); cursor: pointer; }
        
        .form-group { margin-bottom: 1.5rem; }
        .form-group label { display: block; margin-bottom: 0.5rem; color: var(--text-primary); font-weight: 500; }
        .form-group input, .form-group select, .form-group textarea { width: 100%; padding: 0.8rem 1rem; border: 1px solid var(--border-color); border-radius: 8px; background: var(--bg-primary); color: var(--text-primary); }
        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
        
        .image-upload { border: 2px dashed var(--border-color); border-radius: 10px; padding: 2rem; text-align: center; cursor: pointer; transition: all 0.3s ease; }
        .image-upload:hover { border-color: var(--primary-purple); }
        .image-upload i { font-size: 2rem; color: var(--text-muted); margin-bottom: 1rem; }

        @media (max-width: 1024px) { .admin-container { flex-direction: column; } .admin-sidebar { width: 100%; position: static; margin-bottom: 2rem; } }
        @media (max-width: 768px) { .admin-header, .products-header { flex-direction: column; align-items: flex-start; gap: 1rem; } .search-box { width: 100%; } .data-table { overflow-x: auto; } .form-row { grid-template-columns: 1fr; } }
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
        </div>
    </div>
</nav>

<div class="admin-container">
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

    <main class="admin-main">
        <div class="admin-header">
            <h1 class="admin-title">Gerenciar Produtos</h1>
            <div class="admin-actions">
                <button class="btn btn-primary" id="add-product">
                    <i class="fas fa-plus"></i> Adicionar Produto
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
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                <?php if ($products_result && $products_result->num_rows > 0): ?>
                    <?php while ($row = $products_result->fetch_assoc()): ?>
                        <?php 
                            $statusClass = (strtolower($row['status']) === 'ativo') ? 'status-active' : 'status-inactive';
                            $price = number_format($row['price'], 2, ',', '.');
                            $imgSrc = !empty($row['image']) ? '../' . $row['image'] : 'https://via.placeholder.com/50';
                            $dataDescription = isset($row['descricao']) ? htmlspecialchars($row['descricao']) : '';
                            $dataImage = isset($row['image']) ? htmlspecialchars($row['image']) : '';
                        ?>
                        <tr data-id="<?php echo $row['id']; ?>" 
                            data-image="<?php echo $dataImage; ?>" 
                            data-description="<?php echo $dataDescription; ?>">
                            <td>
                                <div class="user-info">
                                    <img src="<?php echo $imgSrc; ?>" alt="Foto" class="user-avatar">
                                    <div class="user-details">
                                        <h4><?php echo htmlspecialchars($row['name']); ?></h4>
                                    </div>
                                </div>
                            </td>
                            <td><?php echo htmlspecialchars($row['category']); ?></td>
                            <td><span class="status-badge <?php echo $statusClass; ?>"><?php echo htmlspecialchars($row['status']); ?></span></td>
                            <td>R$ <?php echo $price; ?></td>
                            <td><?php echo intval($row['stock']); ?></td>
                            <td>
                                <div class="action-buttons">
                                    <button class="btn-icon btn-edit" title="Editar"><i class="fas fa-edit"></i></button>
                                    <button class="btn-icon btn-delete" title="Excluir"><i class="fas fa-trash"></i></button>
                                </div>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="6" style="text-align:center;">Nenhum produto cadastrado.</td></tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </main>
</div>

<!-- Modal -->
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
                <div class="image-upload" id="image-upload-area">
                    <i class="fas fa-cloud-upload-alt" id="upload-icon"></i>
                    <p id="upload-text">Clique para escolher uma imagem</p>
                    <input type="file" id="product-image" name="product-image" accept="image/*" style="display: none;">
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="product-name">Nome do Produto</label>
                    <input type="text" id="product-name" name="product-name" required>
                </div>
                <div class="form-group">
                    <label for="product-sku">SKU (Visual)</label>
                    <input type="text" id="product-sku" name="product-sku">
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="product-category">Categoria</label>
                    <select id="product-category" name="product-category" required>
                        <option value="">Selecione...</option>
                        <option value="camisetas">Camisetas</option>
                        <option value="moletons">Moletons</option>
                        <option value="acessorios">Acessórios</option>
                        <option value="calcas">Calças</option>
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
    const modal = document.getElementById('product-modal');
    const addProductBtn = document.getElementById('add-product');
    const closeModalBtns = document.querySelectorAll('.close-modal');
    const uploadArea = document.getElementById('image-upload-area');
    const fileInput = document.getElementById('product-image');
    const uploadText = document.getElementById('upload-text');
    const uploadIcon = document.getElementById('upload-icon');

    // Abrir Modal
    addProductBtn.addEventListener('click', () => {
        modal.classList.add('active');
        document.getElementById('modal-title').textContent = 'Adicionar Produto';
        document.getElementById('product-form').reset();
        document.getElementById('product-id').value = '';
        resetUploadPreview();
    });

    // Fechar Modal
    closeModalBtns.forEach(btn => btn.addEventListener('click', () => modal.classList.remove('active')));
    modal.addEventListener('click', (e) => { if (e.target === modal) modal.classList.remove('active'); });

    // Upload
    uploadArea.addEventListener('click', () => fileInput.click());
    fileInput.addEventListener('change', (e) => {
        if (e.target.files.length > 0) {
            uploadText.textContent = e.target.files[0].name;
            uploadIcon.className = "fas fa-check-circle";
            uploadIcon.style.color = "var(--success)";
        }
    });

    function resetUploadPreview() {
        uploadText.textContent = "Clique para escolher uma imagem";
        uploadIcon.className = "fas fa-cloud-upload-alt";
        uploadIcon.style.color = "";
    }

    // Botão Editar
    document.querySelectorAll('.btn-edit').forEach(btn => {
        btn.addEventListener('click', function() {
            const row = this.closest('tr');
            const id = row.getAttribute('data-id');
            const name = row.querySelector('.user-details h4').textContent;
            const category = row.cells[1].textContent.trim();
            const status = row.cells[2].textContent.trim().toLowerCase();
            const price = row.cells[3].textContent.replace('R$', '').replace('.', '').replace(',', '.').trim();
            const stock = row.cells[4].textContent.trim();
            const description = row.getAttribute('data-description');
            const imageName = row.getAttribute('data-image');

            document.getElementById('modal-title').textContent = `Editar ${name}`;
            document.getElementById('product-id').value = id;
            document.getElementById('product-name').value = name;
            document.getElementById('product-sku').value = "";
            document.getElementById('product-category').value = category.toLowerCase();
            document.getElementById('product-status').value = status;
            document.getElementById('product-price').value = price;
            document.getElementById('product-stock').value = stock;
            document.getElementById('product-description').value = description;

            if(imageName) {
                uploadText.textContent = "Imagem atual: " + imageName.split('/').pop();
                uploadIcon.className = "fas fa-image";
            } else {
                resetUploadPreview();
            }
            modal.classList.add('active');
        });
    });

    // Botão Excluir
    document.querySelectorAll('.btn-delete').forEach(btn => {
        btn.addEventListener('click', function() {
            if(!confirm('Tem certeza que deseja excluir?')) return;
            const row = this.closest('tr');
            const id = row.getAttribute('data-id');
            
            const formData = new FormData();
            formData.append('action', 'delete');
            formData.append('id', id);

            fetch('produtos_admin.php', { method: 'POST', body: formData })
                .then(res => res.json())
                .then(data => {
                    if (data.success) row.remove();
                    else alert('Erro ao excluir.');
                });
        });
    });
</script>
</body>
</html>