<?php
require_once __DIR__ . '/conexao.php';

// --- LÓGICA DE EXCLUSÃO ---
if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);
    if ($delete_id > 0) {
        $stmtDel = $conn->prepare("DELETE FROM users WHERE id = ?");
        if ($stmtDel) {
            $stmtDel->bind_param('i', $delete_id);
            if ($stmtDel->execute()) {
                $stmtDel->close();
                header('Location: usuarios_admin.php?msg=deleted');
                exit;
            } else {
                $stmtDel->close();
                $error_msg = 'Erro ao excluir usuário.';
            }
        } else {
            $error_msg = 'Erro na preparação da query de exclusão.';
        }
    } else {
        $error_msg = 'ID inválido.';
    }
}

// --- BUSCAR USUÁRIOS ---
$users = [];
$sql = "SELECT id, nome, email, foto, created_at FROM users ORDER BY created_at DESC";
$res = $conn->query($sql);
if ($res) {
    while ($row = $res->fetch_assoc()) {
        $users[] = $row;
    }
    $res->free();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Usuários - Susanoo Admin</title>
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
            vertical-align: middle;
        }
        
        .data-table tr:last-child td {
            border-bottom: none;
        }
        
        .data-table tr:hover {
            background: rgba(139, 92, 246, 0.02);
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
        
        .btn-delete {
            background: rgba(239, 68, 68, 0.1);
            color: var(--error);
        }
        
        .btn-view {
            background: rgba(139, 92, 246, 0.1);
            color: var(--primary-purple);
        }
        
        .btn-delete:hover { background: var(--error); color: white; }
        .btn-view:hover { background: var(--primary-purple); color: white; }

        .user-info { display:flex; align-items:center }
        .user-avatar { width:50px; height:50px; border-radius:10px; object-fit:cover; margin-right:1rem; background-color: #f0f0f0; }
        .user-details h4 { margin:0 0 0.2rem 0; color:var(--text-primary) }
        .user-details span { font-size:0.85rem; color:var(--text-muted) }

        @media (max-width: 1024px) {
            .admin-container { flex-direction: column }
            .admin-sidebar { width:100%; margin-right:0; margin-bottom:2rem; position:static }
        }
    </style>
</head>
<body class="admin-dashboard">

<div class="admin-container">
    <!-- Sidebar -->
    <aside class="admin-sidebar">
        <div class="admin-logo">
            <h2>Susanoo Admin</h2>
            <span>Painel de Controle</span>
        </div>
        <ul class="admin-nav">
            <li><a href="admin.php"><i class="fas fa-chart-pie"></i> Dashboard</a></li>
            <li><a href="produtos_admin.php"><i class="fas fa-box"></i> Produtos</a></li>
            <li><a href="usuarios_admin.php" class="active"><i class="fas fa-users"></i> Usuários</a></li>
            <li><a href="pedidos_admin.php"><i class="fas fa-shopping-cart"></i> Pedidos</a></li>
            <li><a href="relatorios_admin.php"><i class="fas fa-comment"></i> Mensagens</a></li>
            <li><a href="../index.php"><i class="fas fa-sign-out-alt"></i> Voltar ao Site</a></li>
        </ul>
    </aside>

    <!-- Conteúdo Principal -->
    <main class="admin-main">
        <div class="admin-header">
            <h1 class="admin-title">Gerenciar Usuários</h1>
        </div>

        <div class="products-header">
            <div class="search-box">
                <i class="fas fa-search"></i>
                <input type="text" placeholder="Pesquisar usuários..." id="search-users">
            </div>
        </div>

        <div class="data-table">
            <?php if (!empty($_GET['msg']) && $_GET['msg'] === 'deleted'): ?>
                <div style="padding:15px; color: #10b981; background: rgba(16, 185, 129, 0.1); border-radius: 8px; margin-bottom: 1rem;">
                    <i class="fas fa-check-circle"></i> Usuário excluído com sucesso.
                </div>
            <?php endif; ?>
            
            <?php if (!empty($error_msg)): ?>
                <div style="padding:15px; color: #ef4444; background: rgba(239, 68, 68, 0.1); border-radius: 8px; margin-bottom: 1rem;">
                    <i class="fas fa-exclamation-circle"></i> <?php echo htmlspecialchars($error_msg); ?>
                </div>
            <?php endif; ?>

            <table>
                <thead>
                    <tr>
                        <th>Usuário</th>
                        <th>Email</th>
                        <th>Criado em</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($users) === 0): ?>
                        <tr><td colspan="4" style="text-align:center; padding: 2rem;">Nenhum usuário encontrado.</td></tr>
                    <?php else: ?>
                        <?php foreach ($users as $u): ?>
                            <?php
                                // --- LÓGICA INTELIGENTE DE IMAGEM ---
                                $fotoDB = $u['foto'];
                                $nomeUrl = urlencode($u['nome']);
                                
                                // Avatar padrão (iniciais coloridas) caso a imagem falhe ou não exista
                                $avatarPadrao = "https://ui-avatars.com/api/?name={$nomeUrl}&background=random&color=fff&size=128&bold=true";
                                
                                $imgSrc = $avatarPadrao;

                                if (!empty($fotoDB)) {
                                    // 1. Se já começa com '../', confia no caminho do banco (uploads novos)
                                    if (strpos($fotoDB, '../') === 0) {
                                        $imgSrc = $fotoDB;
                                    }
                                    // 2. Se começa com 'assets/', volta um nível para sair da pasta php
                                    elseif (strpos($fotoDB, 'assets/') === 0) {
                                        $imgSrc = '../' . $fotoDB;
                                    }
                                    // 3. Se começa com 'uploads/', tenta apontar para assets/uploads
                                    elseif (strpos($fotoDB, 'uploads/') === 0) {
                                        $imgSrc = '../assets/' . $fotoDB;
                                    }
                                    // 4. Caso genérico
                                    else {
                                        $imgSrc = '../assets/uploads/' . $fotoDB;
                                    }
                                }

                                // Formatação da data para BR
                                $dataCriacao = date('d/m/Y', strtotime($u['created_at']));
                            ?>
                            <tr>
                                <td>
                                    <div class="user-info">
                                        <!-- 
                                            O onerror é essencial: se o link gerado estiver errado 
                                            ou o arquivo não tiver extensão (caso dos usuários antigos),
                                            ele carrega automaticamente o avatar de letras.
                                        -->
                                        <img src="<?php echo htmlspecialchars($imgSrc); ?>" 
                                             alt="avatar" 
                                             class="user-avatar" 
                                             onerror="this.onerror=null; this.src='<?php echo $avatarPadrao; ?>';">
                                        
                                        <div class="user-details">
                                            <h4><?php echo htmlspecialchars($u['nome']); ?></h4>
                                            <span>ID: <?php echo intval($u['id']); ?></span>
                                        </div>
                                    </div>
                                </td>
                                <td><?php echo htmlspecialchars($u['email']); ?></td>
                                <td><?php echo $dataCriacao; ?></td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="mailto:<?php echo htmlspecialchars($u['email']); ?>" class="btn-icon btn-view" title="Enviar Email">
                                            <i class="fas fa-envelope"></i>
                                        </a>
                                        <a href="?delete_id=<?php echo intval($u['id']); ?>" 
                                           onclick="return confirm('Tem certeza que deseja excluir o usuário <?php echo htmlspecialchars($u['nome']); ?>?');" 
                                           class="btn-icon btn-delete" 
                                           title="Excluir Usuário">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </main>
</div>

<script src="../js/script.js"></script>
<script>
    // Filtro de pesquisa em tempo real
    document.getElementById('search-users').addEventListener('input', function(){
        const query = this.value.toLowerCase();
        const rows = document.querySelectorAll('.data-table tbody tr');
        
        rows.forEach(row => {
            const nameEl = row.querySelector('.user-details h4');
            const emailEl = row.cells[1];
            
            if (nameEl && emailEl) {
                const nameText = nameEl.textContent.toLowerCase();
                const emailText = emailEl.textContent.toLowerCase();
                
                if (nameText.includes(query) || emailText.includes(query)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            }
        });
    });
</script>
</body>
</html>