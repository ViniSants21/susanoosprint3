<?php
session_start();
require_once 'conexao.php'; // Garanta que este caminho está correto

// Verifica se o usuário está logado
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// --- LÓGICA DE EXCLUSÃO DE CONTA ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete_account') {
    $user_id = $_SESSION['user_id'];

    // Prepara a exclusão
    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);

    if ($stmt->execute()) {
        // Se deletou com sucesso:
        $stmt->close();
        
        // Destrói a sessão e limpa os dados
        session_unset();
        session_destroy();

        // Redireciona para a home com mensagem (opcional)
        header("Location: ../index.php?msg=conta_excluida");
        exit;
    } else {
        $erro_msg = "Erro ao excluir a conta: " . $conn->error;
    }
}

// Funções auxiliares de visualização
$current = basename($_SERVER['PHP_SELF']);
if (!function_exists('is_active')) {
    function is_active($href, $current) {
        $base = basename(parse_url($href, PHP_URL_PATH));
        return $base === $current ? 'active' : '';
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configurações - Susanoo</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/configuracoes-style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script>
        (function(){
            const theme = localStorage.getItem('theme');
            if(theme === 'light'){
                document.documentElement.classList.add('light-mode');
            }
        })();
    </script>
    <style>
		.nav-search{display:flex;align-items:center;gap:.5rem;}
		.nav-search input[type="text"]{padding:.45rem .75rem;border-radius:24px;border:1px solid rgba(0,0,0,.08);background:transparent;color:inherit;min-width:160px}
		.nav-search .nav-search-btn{border:none;background:transparent;padding:.35rem;border-radius:50%;cursor:pointer;color:inherit;display:inline-flex;align-items:center;justify-content:center}
		.nav-search .nav-search-btn .fa-search{font-size:0.95rem}
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
                    <li><a href="../index.php" class="nav-link <?php echo is_active('index.php', $current); ?>">Home</a></li>
                    <li><a href="produtos.php" class="nav-link <?php echo is_active('produtos.php', $current); ?>">Produtos</a></li>
                    <li><a href="colecoes.php" class="nav-link <?php echo is_active('colecoes.php', $current); ?>">Coleções</a></li>
                    <li><a href="sobre.php" class="nav-link <?php echo is_active('sobre.php', $current); ?>">Sobre</a></li>
                    <li><a href="contato.php" class="nav-link <?php echo is_active('contato.php', $current); ?>">Contato</a></li>
                </ul>
                <div class="nav-icons">
                    <div class="profile-dropdown-wrapper">
                        
                    <!-- USUÁRIO LOGADO (Já verificado no PHP acima) -->
                    <a href="#" class="nav-icon-link" aria-label="Perfil">
                        <?php 
                            // Fallback para foto caso a sessão esteja sem
                            $fotoPerfil = isset($_SESSION['foto']) && !empty($_SESSION['foto']) ? $_SESSION['foto'] : '../assets/img/placeholder-user.png';
                        ?>
                        <img src="<?php echo htmlspecialchars($fotoPerfil); ?>" class="dropdown-avatar" style="width:28px; height:28px; border-radius:50%; object-fit:cover;">
                    </a>

                    <div class="profile-dropdown-menu">
                        <div class="dropdown-header">
                            <img src="<?php echo htmlspecialchars($fotoPerfil); ?>" alt="Avatar" class="dropdown-avatar">
                            <div>
                                <div class="dropdown-user-name"><?php echo htmlspecialchars($_SESSION['nome']); ?></div>
                                <div class="dropdown-user-email"><?php echo htmlspecialchars($_SESSION['email']); ?></div>
                            </div>
                        </div>

                        <ul class="dropdown-links">
                            <li class="dropdown-link-item"><a href="perfil.php"><i class="fas fa-id-card"></i> Visualizar Perfil</a></li>
                            <li class="dropdown-link-item"><a href="configuracoes.php"><i class="fas fa-cog"></i> Configurações</a></li>
                            <li class="dropdown-link-item"><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Sair</a></li>
                        </ul>
                    </div>

                    </div>
                    <a href="carrinho.php" class="nav-icon-link" aria-label="Carrinho"><i class="fas fa-shopping-bag"></i></a>
                </div>
            </div>
            <div class="hamburger" id="hamburger"><span></span><span></span><span></span></div>
        </div>
    </nav>
    <!-- ========== Fim da Navbar ========== -->

    <main class="settings-main-content">
        <div class="container">
            <div class="settings-header"><h1>Configurações da Conta</h1></div>
            <div class="settings-layout">
                <aside class="settings-nav">
                    <ul>
                        <li><a href="perfil.php"><i class="fas fa-user-circle"></i> Meu Perfil</a></li>
                        <li><a href="configuracoes.php" class="active"><i class="fas fa-cog"></i> Configurações</a></li>
                    </ul>
                </aside>
                
                <div class="settings-content">
                    
                    <?php if(isset($erro_msg)): ?>
                        <div style="background: rgba(239,68,68,0.2); color: #ef4444; padding: 15px; border-radius: 8px; margin-bottom: 20px; border: 1px solid rgba(239,68,68,0.3);">
                            <?php echo $erro_msg; ?>
                        </div>
                    <?php endif; ?>

                    <!-- Seção de Aparência -->
                    <section class="settings-panel active">
                        <h2>Aparência</h2>
                        <div class="form-group-settings">
                            <label>Tema do Site</label>
                            <div class="theme-switch-wrapper">
                                <span>Claro / Escuro</span>
                                <label class="theme-switch">
                                    <input type="checkbox">
                                    <span class="slider"></span>
                                </label>
                            </div>
                        </div>
                    </section>

                    <!-- Seção de Notificações -->
                    <section class="settings-panel active">
                        <h2>Notificações</h2>
                        <div class="form-group-settings">
                            <label class="checkbox-label">
                                <input type="checkbox" checked>
                                <span>Receber notificações por e-mail</span>
                            </label>
                        </div>
                        <div class="form-group-settings">
                            <label class="checkbox-label">
                                <input type="checkbox" checked>
                                <span>Receber promoções e ofertas especiais</span>
                            </label>
                        </div>
                    </section>

                    <!-- Zona de Perigo -->
                    <section class="settings-panel active danger-zone">
                        <h2>Zona de Perigo</h2>
                        <div class="form-group-settings">
                            <p>Esta ação é permanente e removerá todos os seus dados, incluindo histórico de pedidos. Não pode ser desfeita.</p>
                        </div>
                        <div class="panel-footer">
                            <!-- FORMULÁRIO OCULTO PARA EXCLUSÃO -->
                            <form id="delete-form" method="POST" action="configuracoes.php" style="display: none;">
                                <input type="hidden" name="action" value="delete_account">
                            </form>
                            
                            <button type="button" class="btn btn-danger" id="delete-account-btn">Excluir Minha Conta</button>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </main>
    
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // --- Lógica para o botão de TEMA ---
        const themeSwitch = document.querySelector('.theme-switch input[type="checkbox"]');
        function handleThemeChange() {
            document.documentElement.classList.toggle('light-mode', !themeSwitch.checked);
            localStorage.setItem('theme', themeSwitch.checked ? 'dark' : 'light');
        }
        
        // Verifica null check para evitar erros se o elemento não existir
        if (themeSwitch) {
            themeSwitch.checked = localStorage.getItem('theme') !== 'light';
            themeSwitch.addEventListener('change', handleThemeChange);
        }

        // --- Lógica para o botão de EXCLUIR CONTA ---
        const deleteBtn = document.getElementById('delete-account-btn');
        if (deleteBtn) {
            deleteBtn.addEventListener('click', function() {
                const confirmation = prompt("ATENÇÃO: Essa ação não pode ser desfeita!\n\nPara confirmar a exclusão da sua conta, digite a palavra 'EXCLUIR' abaixo e clique em OK.");
                
                if (confirmation === 'EXCLUIR') {
                    // Se o usuário digitou corretamente, submete o formulário oculto
                    document.getElementById('delete-form').submit();
                } else if (confirmation !== null) {
                    alert('A palavra de confirmação estava incorreta. A conta NÃO foi excluída.');
                }
            });
        }

        // --- Lógica para salvar preferências de notificação ---
        const notificationCheckboxes = document.querySelectorAll('.settings-panel input[type="checkbox"]');
        notificationCheckboxes.forEach(checkbox => {
            // Ignora o switch de tema
            if (checkbox.parentElement.classList.contains('theme-switch')) return;

            // Carregar preferências salvas
            const key = 'pref_' + checkbox.parentElement.textContent.trim();
            const savedValue = localStorage.getItem(key);
            if (savedValue !== null) {
                checkbox.checked = savedValue === 'true';
            }

            // Salvar quando alterado
            checkbox.addEventListener('change', function() {
                localStorage.setItem(key, this.checked);
            });
        });
    });
    </script>
    
    <script src="../js/cart.js"></script>
    <script src="../js/script.js"></script>
    
</body>
</html>