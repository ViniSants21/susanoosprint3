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
                        <a href="#" class="nav-icon-link" aria-label="Login" style="pointer-events: none;"><i class="fas fa-user"></i></a>
                        <div class="profile-dropdown-menu">
                            <div class="dropdown-header">
                                <img src="../assets/img/avatar.png" alt="Avatar" class="dropdown-avatar">
                                <div><div class="dropdown-user-name">Seu Nome</div><div class="dropdown-user-email">seu@email.com</div></div>
                            </div>
                            <ul class="dropdown-links">
                                <li class="dropdown-link-item"><a href="perfil.php"><i class="fas fa-id-card"></i> Visualizar Perfil</a></li>
                                <li class="dropdown-link-item"><a href="login.php"><i class="fas fa-sign-in-alt"></i> Logar</a></li>
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
            <div class="settings-header"><h1>Meu Perfil</h1></div>
            <div class="settings-layout">
                <aside class="settings-nav">
                    <ul>
                        <li><a href="perfil.php" class="active"><i class="fas fa-user-circle"></i> Meu Perfil</a></li>
                        <li><a href="configuracoes.php"><i class="fas fa-cog"></i> Configurações</a></li>
                    </ul>
                </aside>
                
                <div class="settings-content">

                    <!-- SEÇÃO: DADOS DA CONTA E ALTERAÇÃO DE SENHA -->
                    <section class="settings-panel active">
                        <h2>Informações Pessoais</h2>
                        <form id="user-data-form">
                            <div class="form-group-settings">
                                <label for="name">Nome Completo</label>
                                <input type="text" id="name" value="Seu Nome">
                            </div>
                            <div class="form-group-settings">
                                <label for="email">E-mail</label>
                                <input type="email" id="email" value="seu@email.com">
                            </div>

                            <h2 style="margin-top: 40px;">Alterar Senha</h2>
                            <div class="form-group-settings">
                                <label for="current_password">Senha Atual</label>
                                <input type="password" id="current_password" name="current_password" placeholder="Digite sua senha atual">
                            </div>
                            <div class="form-group-settings">
                                <label for="new_password">Nova Senha</label>
                                <input type="password" id="new_password" name="new_password" placeholder="Mínimo 8 caracteres">
                            </div>
                            <div class="form-group-settings">
                                <label for="confirm_password">Confirmar Nova Senha</label>
                                <input type="password" id="confirm_password" name="confirm_password" placeholder="Repita a nova senha">
                            </div>

                            <div class="panel-footer">
                                <button type="submit" class="btn btn-primary">Salvar Alterações</button>
                            </div>
                        </form>
                    </section>
                    
                    <!-- SEÇÃO DE FOTO DE PERFIL -->
                    <section class="settings-panel active" style="margin-top: 30px;">
                        <h2>Minha Foto de Perfil</h2>
                        <form id="avatar-form">
                            <div class="form-group-settings avatar-settings-group">
                                <img src="../assets/img/avatar.png" alt="Avatar" class="avatar-preview-img" id="avatarPreview">
                                <label for="avatarUpload" class="avatar-upload-label">Trocar Foto</label>
                                <input type="file" id="avatarUpload" name="avatar" accept="image/*">
                            </div>
                            <div class="panel-footer">
                                <button type="submit" class="btn btn-primary">Salvar Foto</button>
                            </div>
                        </form>
                    </section>

                    <!-- SEÇÃO DE HISTÓRICO DE PEDIDOS -->
                    <section class="settings-panel active" style="margin-top: 30px;">
                         <h2>Histórico de Pedidos</h2>
                         <div class="order-history-list">
                            <div class="order-item-card">
                                <div class="order-item-header">
                                    <h4>Pedido <span>#SUSANOO-12345</span></h4>
                                    <span class="order-status delivered">Entregue</span>
                                </div>
                                <div class="order-item-body">
                                    <p><strong>Data:</strong> 05/10/2025</p>
                                    <p><strong>Total:</strong> R$ 177,98</p>
                                    <a href="#" class="order-details-link">Ver Detalhes</a>
                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- SEÇÃO DE NEWSLETTER -->
                    <section class="settings-panel active" style="margin-top: 30px;">
                        <h2>Notificações e Newsletter</h2>
                        <form id="newsletter-form">
                            <div class="form-group-settings">
                                <label class="checkbox-label">
                                    <input type="checkbox" checked>
                                    <span>Desejo receber e-mails com novidades e promoções.</span>
                                </label>
                            </div>
                            <div class="panel-footer">
                                <button type="submit" class="btn btn-primary">Salvar Preferências</button>
                            </div>
                        </form>
                    </section>
                </div>
            </div>
        </div>
    </main>

    <!-- ========== Footer ========== -->
    <footer class="footer">
        <!-- Seu código do footer aqui -->
    </footer>
    
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