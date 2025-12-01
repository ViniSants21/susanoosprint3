<?php
session_start();
require_once 'conexao.php'; // Conexão com o banco

// Verifica se o usuário está logado
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$msg_sucesso = "";
$msg_erro = "";

// ==========================================
// BUSCAR DADOS ATUAIS
// ==========================================
$sql_u = "SELECT * FROM users WHERE id = $user_id";
$res_u = $conn->query($sql_u);

if ($res_u && $res_u->num_rows > 0) {
    $user_data = $res_u->fetch_assoc();
    
    // Pega os dados direto do banco
    $nome_exibir = $user_data['nome']; 
    $email_exibir = $user_data['email'];
    
    // Verifica a coluna 'foto'
    $foto_db = isset($user_data['foto']) ? $user_data['foto'] : '';
    
    // Se tiver foto no banco, usa ela. Se não, usa o placeholder.
    $foto_exibir = !empty($foto_db) ? $foto_db : '../assets/img/placeholder-user.png';

    // Atualiza a sessão
    $_SESSION['nome'] = $nome_exibir;
    $_SESSION['email'] = $email_exibir;
    $_SESSION['foto'] = $foto_exibir;
} else {
    session_destroy();
    header("Location: login.php");
    exit;
}

// ==========================================
// PROCESSAMENTO DE FORMULÁRIOS
// ==========================================

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // --- 1. ATUALIZAR DADOS PESSOAIS ---
    if (isset($_POST['action']) && $_POST['action'] === 'update_info') {
        $novo_nome = $conn->real_escape_string($_POST['nome']);
        $novo_email = $conn->real_escape_string($_POST['email']);
        
        $sql = "UPDATE users SET nome = '$novo_nome', email = '$novo_email' WHERE id = $user_id";
        
        if ($conn->query($sql)) {
            $nome_exibir = $novo_nome;
            $email_exibir = $novo_email;
            $_SESSION['nome'] = $novo_nome;
            $_SESSION['email'] = $novo_email;
            $msg_sucesso = "Dados atualizados com sucesso!";
        } else {
            $msg_erro = "Erro ao atualizar dados: " . $conn->error;
        }
    }

    // --- 2. ALTERAR SENHA ---
    if (isset($_POST['action']) && $_POST['action'] === 'update_password') {
        $senha_atual = $_POST['current_password'];
        $nova_senha = $_POST['new_password'];
        $confirma_senha = $_POST['confirm_password'];

        $sql_pass = "SELECT senha FROM users WHERE id = $user_id";
        $res_pass = $conn->query($sql_pass);
        $row_pass = $res_pass->fetch_assoc();

        if (password_verify($senha_atual, $row_pass['senha'])) {
            if ($nova_senha === $confirma_senha) {
                if (strlen($nova_senha) >= 8) {
                    $hash_nova = password_hash($nova_senha, PASSWORD_DEFAULT);
                    $conn->query("UPDATE users SET senha = '$hash_nova' WHERE id = $user_id");
                    $msg_sucesso = "Senha alterada com sucesso!";
                } else {
                    $msg_erro = "A nova senha deve ter no mínimo 8 caracteres.";
                }
            } else {
                $msg_erro = "A nova senha e a confirmação não coincidem.";
            }
        } else {
            $msg_erro = "Senha atual incorreta.";
        }
    }

    // --- 3. UPLOAD DE FOTO ---
    if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === 0) {
        $extensao = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);
        $extensoes_permitidas = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        
        if (in_array(strtolower($extensao), $extensoes_permitidas)) {
            $novo_nome_arquivo = "user_" . $user_id . "_" . time() . "." . $extensao;
            $diretorio_destino = "../assets/uploads/";
            
            if (!is_dir($diretorio_destino)) {
                mkdir($diretorio_destino, 0777, true);
            }

            if (move_uploaded_file($_FILES['avatar']['tmp_name'], $diretorio_destino . $novo_nome_arquivo)) {
                $caminho_db = "../assets/uploads/" . $novo_nome_arquivo;
                $conn->query("UPDATE users SET foto = '$caminho_db' WHERE id = $user_id");
                
                $foto_exibir = $caminho_db;
                $_SESSION['foto'] = $caminho_db;
                $msg_sucesso = "Foto de perfil atualizada!";
            } else {
                $msg_erro = "Erro ao salvar o arquivo.";
            }
        } else {
            $msg_erro = "Formato inválido. Use JPG, PNG ou GIF.";
        }
    }
}

// Buscar Histórico de Pedidos
$sql_orders = "SELECT * FROM pedidos WHERE cliente_email = '$email_exibir' ORDER BY data_pedido DESC";
$res_orders = $conn->query($sql_orders);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meu Perfil - Susanoo</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/configuracoes-style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script>(function(){const theme=localStorage.getItem('theme');if(theme==='light'){document.documentElement.classList.add('light-mode');}})();</script>
    <style>
		.nav-search{display:flex;align-items:center;gap:.5rem;}
		.nav-search input[type="text"]{padding:.45rem .75rem;border-radius:24px;border:1px solid rgba(0,0,0,.08);background:transparent;color:inherit;min-width:160px}
		.nav-search .nav-search-btn{border:none;background:transparent;padding:.35rem;border-radius:50%;cursor:pointer;color:inherit;display:inline-flex;align-items:center;justify-content:center}
		.nav-search .nav-search-btn .fa-search{font-size:0.95rem}
        
        .alert { padding: 15px; margin-bottom: 20px; border-radius: 8px; font-weight: 500; }
        .alert-success { background: rgba(16, 185, 129, 0.2); color: #10b981; border: 1px solid rgba(16, 185, 129, 0.3); }
        .alert-error { background: rgba(239, 68, 68, 0.2); color: #ef4444; border: 1px solid rgba(239, 68, 68, 0.3); }

        /* === ESTILOS DA FOTO DE PERFIL === */
        .avatar-settings-group {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            gap: 15px;
        }

        .avatar-preview-img {
            width: 180px;         /* Tamanho fixo */
            height: 180px;        /* Altura igual à largura para formar o círculo */
            border-radius: 50%;   /* Transforma o quadrado em círculo */
            object-fit: cover;    /* Garante que a imagem preencha sem distorcer */
            border: 4px solid #2d2d44; /* Borda opcional para destaque */
            box-shadow: 0 4px 15px rgba(0,0,0,0.3); /* Sombra suave */
        }

        .avatar-upload-label {
            display: inline-block;
            padding: 10px 20px;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.3s ease;
            color: #fff;
        }

        .avatar-upload-label:hover {
            background: rgba(255, 255, 255, 0.2);
            border-color: #a78bfa;
        }
        
        /* Esconde o input file original que é feio */
        input[type="file"] {
            display: none;
        }
	</style>
</head>
<body class="settings-page-body">

    <!-- ========== Navbar ========== -->
    <nav class="navbar scrolled" id="navbar">
        <div class="nav-container">
            <div class="nav-search">
                <input type="text" placeholder="Pesquisar..." aria-label="Pesquisar">
                <button class="nav-search-btn" aria-label="Pesquisar"><i class="fas fa-search"></i></button>
            </div>
            <div class="nav-logo"><a href="../index.php"><img src="../assets/img/LOGOSUSANOO.png" alt="LOGOSUSANOO"></a></div>
            <div class="nav-right-group">
                <ul class="nav-menu" id="nav-menu">
                    <li><a href="../index.php" class="nav-link">Home</a></li>
                    <li><a href="produtos.php" class="nav-link">Produtos</a></li>
                    <li><a href="colecoes.php" class="nav-link">Coleções</a></li>
                    <li><a href="sobre.php" class="nav-link">Sobre</a></li>
                    <li><a href="contato.php" class="nav-link">Contato</a></li>
                </ul>
               <div class="nav-icons">
                    <div class="profile-dropdown-wrapper">
                        <a href="#" class="nav-icon-link" aria-label="Perfil">
                            <img src="<?php echo $foto_exibir; ?>" class="dropdown-avatar" style="width:28px; height:28px; border-radius:50%; object-fit:cover;">
                        </a>
                        <div class="profile-dropdown-menu">
                            <div class="dropdown-header">
                                <img src="<?php echo $foto_exibir; ?>" alt="Avatar" class="dropdown-avatar">
                                <div>
                                    <div class="dropdown-user-name"><?php echo $nome_exibir; ?></div>
                                    <div class="dropdown-user-email"><?php echo $email_exibir; ?></div>
                                </div>
                            </div>
                            <ul class="dropdown-links">
                                <li class="dropdown-link-item"><a href="perfil.php"><i class="fas fa-id-card"></i> Visualizar Perfil</a></li>
                                <li class="dropdown-link-item"><a href="configuracoes.php"><i class="fas fa-cog"></i> Configurações</a></li>
                                <li class="dropdown-link-item"><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Sair</a></li>
                            </ul>
                        </div>
                    </div>
                    <a href="../php/carrinho.php" class="nav-icon-link" aria-label="Carrinho"><i class="fas fa-shopping-bag"></i></a>
                </div>
            </div>
            <div class="hamburger" id="hamburger"><span></span><span></span><span></span></div>
        </div>
    </nav>
    <!-- ========== Fim da Navbar ========== -->

    <main class="settings-main-content">
        <div class="container">
            <div class="settings-header"><h1>Meu Perfil</h1></div>
            <div class="settings-layout">
                <aside class="settings-nav">
                    <ul>
                        <li><a href="perfil.php" class="active"><i class="fas fa-user-circle"></i> Meu Perfil</a></li>
                        <li><a href="configuracoes.php"><i class="fas fa-cog"></i> Configurações</a></li>
                    </ul>
                </aside>
                
                <div class="settings-content">

                    <?php if(!empty($msg_sucesso)): ?>
                        <div class="alert alert-success"><?php echo $msg_sucesso; ?></div>
                    <?php endif; ?>
                    <?php if(!empty($msg_erro)): ?>
                        <div class="alert alert-error"><?php echo $msg_erro; ?></div>
                    <?php endif; ?>

                    <!-- DADOS PESSOAIS -->
                    <section class="settings-panel active">
                        <h2>Informações Pessoais</h2>
                        <form method="POST" action="perfil.php">
                            <input type="hidden" name="action" value="update_info">
                            <div class="form-group-settings">
                                <label for="name">Nome Completo</label>
                                <input type="text" id="name" name="nome" value="<?php echo htmlspecialchars($nome_exibir); ?>" required>
                            </div>
                            <div class="form-group-settings">
                                <label for="email">E-mail</label>
                                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email_exibir); ?>" required>
                            </div>
                            <div class="panel-footer" style="margin-bottom: 2rem;">
                                <button type="submit" class="btn btn-primary">Salvar Dados</button>
                            </div>
                        </form>

                        <hr style="border: 0; border-top: 1px solid rgba(255,255,255,0.1); margin: 2rem 0;">

                        <h2>Alterar Senha</h2>
                        <form method="POST" action="perfil.php">
                            <input type="hidden" name="action" value="update_password">
                            <div class="form-group-settings">
                                <label for="current_password">Senha Atual</label>
                                <input type="password" id="current_password" name="current_password" placeholder="Digite sua senha atual" required>
                            </div>
                            <div class="form-group-settings">
                                <label for="new_password">Nova Senha</label>
                                <input type="password" id="new_password" name="new_password" placeholder="Mínimo 8 caracteres" required>
                            </div>
                            <div class="form-group-settings">
                                <label for="confirm_password">Confirmar Nova Senha</label>
                                <input type="password" id="confirm_password" name="confirm_password" placeholder="Repita a nova senha" required>
                            </div>

                            <div class="panel-footer">
                                <button type="submit" class="btn btn-primary">Alterar Senha</button>
                            </div>
                        </form>
                    </section>
                    
                    <!-- FOTO DE PERFIL -->
                    <section class="settings-panel active" style="margin-top: 30px;">
                        <h2>Minha Foto de Perfil</h2>
                        <form id="avatar-form" method="POST" action="perfil.php" enctype="multipart/form-data">
                            <div class="form-group-settings avatar-settings-group">
                                <!-- IMAGEM REDONDA -->
                                <img src="<?php echo $foto_exibir; ?>" alt="Avatar" class="avatar-preview-img" id="avatarPreview">
                                
                                <label for="avatarUpload" class="avatar-upload-label">
                                    <i class="fas fa-camera"></i> Trocar Foto
                                </label>
                                <input type="file" id="avatarUpload" name="avatar" accept="image/*" required>
                            </div>
                            <div class="panel-footer">
                                <button type="submit" class="btn btn-primary">Salvar Foto</button>
                            </div>
                        </form>
                    </section>

                    <!-- HISTÓRICO DE PEDIDOS -->
                    <section class="settings-panel active" style="margin-top: 30px;">
                         <h2>Histórico de Pedidos</h2>
                         <div class="order-history-list">
                            <?php if($res_orders && $res_orders->num_rows > 0): ?>
                                <?php while($order = $res_orders->fetch_assoc()): 
                                    $statusClass = 'delivered';
                                    $s = strtolower($order['status']);
                                    $styleStatus = 'color:#a78bfa; background:rgba(139,92,246,0.2);'; 

                                    if(strpos($s, 'pendente')!==false) $styleStatus = 'color:#fbbf24; background:rgba(245,158,11,0.2);';
                                    elseif(strpos($s, 'entregue')!==false) $styleStatus = 'color:#34d399; background:rgba(16,185,129,0.2);';
                                    elseif(strpos($s, 'cancel')!==false) $styleStatus = 'color:#ef4444; background:rgba(239,68,68,0.2);';
                                ?>
                                <div class="order-item-card">
                                    <div class="order-item-header">
                                        <h4>Pedido <span>#<?php echo $order['id']; ?></span></h4>
                                        <span class="order-status" style="<?php echo $styleStatus; ?> padding:2px 8px; border-radius:4px;">
                                            <?php echo ucfirst($order['status']); ?>
                                        </span>
                                    </div>
                                    <div class="order-item-body">
                                        <p><strong>Data:</strong> <?php echo date('d/m/Y', strtotime($order['data_pedido'])); ?></p>
                                        <p><strong>Total:</strong> R$ <?php echo number_format($order['total'], 2, ',', '.'); ?></p>
                                    </div>
                                </div>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <p style="color: #888; padding: 1rem;">Você ainda não realizou nenhum pedido.</p>
                            <?php endif; ?>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </main>

    <script src="../js/cart.js"></script>
    <script src="../js/script.js"></script>
    <script src="../js/theme.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const avatarUpload = document.getElementById('avatarUpload');
        const avatarPreview = document.getElementById('avatarPreview');

        if(avatarUpload && avatarPreview) {
            avatarUpload.addEventListener('change', function() {
                if (this.files && this.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        avatarPreview.src = e.target.result;
                    }
                    reader.readAsDataURL(this.files[0]);
                }
            });
        }
    });
    </script>
</body>
</html>