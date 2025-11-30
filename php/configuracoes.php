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
                        <?php if (!isset($_SESSION)) { session_start(); } ?>
                        <?php if (!isset($_SESSION['user_id'])): ?>
                    <!-- USUÁRIO DESLOGADO -->
                        <a href="php/login.php" class="nav-icon-link" aria-label="Login">
                        <i class="fas fa-user"></i>
                        </a>


                        <div class="profile-dropdown-menu">
                            <ul class="dropdown-links">
                                <li class="dropdown-link-item">
                                <a href="../php/registro.php"><i class="fas fa-user-plus"></i> Registrar</a>
                                </li>
                                <li class="dropdown-link-item">
                                    <a href="../php/login.php"><i class="fas fa-sign-in-alt"></i> Login</a>
                                </li>
                            </ul>
                        </div>


                    <?php else: ?>
                    <!-- USUÁRIO LOGADO -->
                    <a href="#" class="nav-icon-link" aria-label="Perfil">
                    <img src="<?php echo $_SESSION['foto']; ?>"
                    class="dropdown-avatar"
                    style="width:28px; height:28px; border-radius:50%; object-fit:cover;">
                    </a>


<div class="profile-dropdown-menu">
<div class="dropdown-header">
<img src="<?php echo $_SESSION['foto']; ?>" alt="Avatar" class="dropdown-avatar">
<div>
<div class="dropdown-user-name"><?php echo $_SESSION['nome']; ?></div>
<div class="dropdown-user-email"><?php echo $_SESSION['email']; ?></div>
</div>
</div>


<ul class="dropdown-links">
<li class="dropdown-link-item"><a href="php/perfil.php"><i class="fas fa-id-card"></i> Visualizar Perfil</a></li>
<li class="dropdown-link-item"><a href="php/configuracoes.php"><i class="fas fa-cog"></i> Configurações</a></li>
<li class="dropdown-link-item"><a href="../php/logout.php"><i class="fas fa-sign-out-alt"></i> Sair</a></li>
</ul>
</div>
<?php endif; ?>
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
        themeSwitch.checked = localStorage.getItem('theme') !== 'light';
        themeSwitch.addEventListener('change', handleThemeChange);

        // --- Lógica para o botão de EXCLUIR CONTA ---
        const deleteBtn = document.getElementById('delete-account-btn');
        if (deleteBtn) {
            deleteBtn.addEventListener('click', function() {
                const confirmation = prompt("Esta ação é irreversível. Para confirmar, digite 'EXCLUIR' e clique em OK.");
                if (confirmation === 'EXCLUIR') {
                    alert('Sua conta foi excluída com sucesso.');
                    // Aqui você redirecionaria o usuário para a página inicial
                    // window.location.href = '../index.php';
                } else {
                    alert('Ação cancelada.');
                }
            });
        }

        // --- Lógica para salvar preferências de notificação ---
        const notificationCheckboxes = document.querySelectorAll('.settings-panel input[type="checkbox"]');
        notificationCheckboxes.forEach(checkbox => {
            // Carregar preferências salvas
            const savedValue = localStorage.getItem(checkbox.parentElement.textContent.trim());
            if (savedValue !== null) {
                checkbox.checked = savedValue === 'true';
            }

            // Salvar quando alterado
            checkbox.addEventListener('change', function() {
                localStorage.setItem(this.parentElement.textContent.trim(), this.checked);
            });
        });
    });
    </script>
    
    <script src="../js/cart.js"></script>
    <script src="../js/script.js"></script>
    
</body>
</html>