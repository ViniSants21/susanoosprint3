<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configurações - Susanoo</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/configuracoes-style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script>(function(){const theme=localStorage.getItem('theme');if(theme==='light'){document.documentElement.classList.add('light-mode');}})();</script>
    <style>
        .nav-search{display:flex;align-items:center;gap:.5rem;}
        .nav-search input[type="text"]{padding:.45rem .75rem;border-radius:24px;border:1px solid rgba(0,0,0,.08);background:transparent;color:inherit;min-width:160px}
        .nav-search .nav-search-btn{border:none;background:transparent;padding:.35rem;border-radius:50%;cursor:pointer;color:inherit;display:inline-flex;align-items:center;justify-content:center}
        .nav-search .nav-search-btn .fa-search{font-size:0.95rem}
    </style>
</head>
<body class="settings-page-body">

<?php
$current = basename($_SERVER['PHP_SELF']);
if (!function_exists('is_active')) {
    function is_active($href, $current) {
        $base = basename(parse_url($href, PHP_URL_PATH));
        return $base === $current ? 'active' : '';
    }
}
?>

<nav class="navbar scrolled" id="navbar">
    <div class="nav-container">
        <div class="nav-search"><input type="text" placeholder="Pesquisar..."></div>
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
                    <a href="login.php" class="nav-icon-link" aria-label="Login"><i class="fas fa-user"></i></a>
                    <div class="profile-dropdown-menu">
                        <div class="dropdown-header">
                            <img src="../assets/img/avatar.png" alt="Avatar" class="dropdown-avatar">
                            <div><div class="dropdown-user-name">Seu Nome</div><div class="dropdown-user-email">seu@email.com</div></div>
                        </div>
                        <ul class="dropdown-links">
                            <li class="dropdown-link-item"><a href="perfil.php"><i class="fas fa-id-card"></i> Visualizar Perfil</a></li>
                            <li class="dropdown-link-item"><a href="configuracoes.php"><i class="fas fa-cog"></i> Configurações</a></li>
                        </ul>
                    </div>
                </div>
                <a href="carrinho.php" class="nav-icon-link" aria-label="Carrinho"><i class="fas fa-shopping-bag"></i></a>
            </div>
        </div>
        <div class="hamburger" id="hamburger"><span></span><span></span><span></span></div>
    </div>
</nav>

    <main class="settings-main-content">
        <div class="container">
            <div class="settings-header"><h1>Configurações da Conta</h1></div>
            <div class="settings-layout">
                <aside class="settings-nav">
                    <ul>
                        <li><a href="#perfil" class="settings-tab active"><i class="fas fa-user-edit"></i> Perfil</a></li>
                        <li><a href="#seguranca" class="settings-tab"><i class="fas fa-shield-alt"></i> Segurança</a></li>
                        <li><a href="#aparencia" class="settings-tab"><i class="fas fa-palette"></i> Aparência</a></li>
                    </ul>
                </aside>
                <div class="settings-content">
                    <!-- Painel de Perfil -->
                    <section id="perfil" class="settings-panel active">
                        <h2>Informações do Perfil</h2>
                        <form action="" method="post">
                            <div class="form-group-settings avatar-settings-group">
                                <img src="../assets/img/avatar.png" alt="Avatar" class="avatar-preview-img" id="avatarPreview">
                                <label for="avatarUpload" class="avatar-upload-label">Trocar Foto</label>
                                <input type="file" id="avatarUpload" name="avatar" accept="image/*">
                            </div>
                            <div class="form-group-settings">
                                <label for="name">Nome Completo</label>
                                <input type="text" id="name" name="name" value="Seu Nome">
                            </div>
                            <div class="form-group-settings">
                                <label for="email">Endereço de E-mail</label>
                                <input type="email" id="email" name="email" value="seu@email.com">
                            </div>
                        </form>
                    </section>
                    <!-- Painel de Segurança -->
                    <section id="seguranca" class="settings-panel">
                        <h2>Alterar Senha</h2>
                        <form action="" method="post">
                            <div class="form-group-settings">
                                <label for="current_password">Senha Atual</label>
                                <input type="password" id="current_password" name="current_password">
                            </div>
                            <div class="form-group-settings">
                                <label for="new_password">Nova Senha</label>
                                <input type="password" id="new_password" name="new_password">
                            </div>
                            <div class="form-group-settings">
                                <label for="confirm_password">Confirmar Nova Senha</label>
                                <input type="password" id="confirm_password" name="confirm_password">
                            </div>
                        </form>
                    </section>
                    <!-- Painel de Aparência -->
                    <section id="aparencia" class="settings-panel">
                        <h2>Aparência</h2>
                        <div class="form-group-settings">
                            <label>Tema do Site</label>
                            <div class="theme-switch-wrapper">
                                <span>Claro / Escuro</span>
                                <label class="theme-switch">
                                    <input type="checkbox" checked>
                                    <span class="slider"></span>
                                </label>
                            </div>
                        </div>
                    </section>
                    <div class="settings-footer">
                        <button class="btn btn-primary">Salvar Alterações</button>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <footer class="footer">
        <div class="container"><div class="footer-content"><div class="footer-section"><div class="footer-logo"><h3>須佐能乎</h3><span>SUSANOO</span></div><p>Desperte seu poder interior com estilo único e elegância oriental.</p><div class="social-links"><a href="#" class="social-link">Instagram</a><a href="#" class="social-link">Facebook</a><a href="#" class="social-link">X</a></div></div><div class="footer-section"><h4>Navegação</h4><ul><li><a href="../index.php">Home</a></li><li><a href="produtos.php">Produtos</a></li><li><a href="colecoes.php">Coleções</a></li><li><a href="sobre.php">Sobre Nós</a></li></ul></div><div class="footer-section"><h4>Atendimento</h4><ul><li><a href="contato.php">Contato</a></li><li><a href="#">FAQ</a></li><li><a href="#">Trocas e Devoluções</a></li><li><a href="#">Política de Privacidade</a></li></ul></div><div class="footer-section"><h4>Newsletter</h4><p>Receba novidades e ofertas exclusivas</p><form class="newsletter-form"><input type="email" placeholder="Seu email" required><button type="submit" class="btn btn-primary">Inscrever</button></form></div></div><div class="footer-bottom"><p>&copy; <?php echo date('Y'); ?> Susanoo. Todos os direitos reservados.</p></div></div>
    </footer>

    <script>
        // Script para a navegação por abas da página de configurações
        document.addEventListener('DOMContentLoaded', function() {
            const tabs = document.querySelectorAll('.settings-tab');
            const panels = document.querySelectorAll('.settings-panel');

            tabs.forEach(tab => {
                tab.addEventListener('click', function(e) {
                    e.preventDefault();
                    
                    // Remove a classe 'active' de todas as abas e painéis
                    tabs.forEach(t => t.classList.remove('active'));
                    panels.forEach(p => p.classList.remove('active'));

                    // Adiciona a classe 'active' na aba e painel clicados
                    this.classList.add('active');
                    const targetPanel = document.querySelector(this.getAttribute('href'));
                    if (targetPanel) {
                        targetPanel.classList.add('active');
                    }
                });
            });

            // Script para preview do avatar
            const avatarUpload = document.getElementById('avatarUpload');
            const avatarPreview = document.getElementById('avatarPreview');
            if(avatarUpload && avatarPreview) {
                avatarUpload.addEventListener('change', function() {
                    const file = this.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            avatarPreview.src = e.target.result;
                        }
                        reader.readAsDataURL(file);
                    }
                });
            }
        });
    </script>
    <script src="../js/cart.js"></script>
    <script src="../js/script.js"></script>
    <script src="../js/theme.js"></script>
</body>
</html>