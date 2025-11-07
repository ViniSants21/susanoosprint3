<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Susanoo</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/login-style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <script>(function(){const theme=localStorage.getItem('theme');if(theme==='light'){document.documentElement.classList.add('light-mode');}})();</script>
    <style>
        .nav-search{display:flex;align-items:center;gap:.5rem;}
        .nav-search input[type="text"]{padding:.45rem .75rem;border-radius:24px;border:1px solid rgba(0,0,0,.08);background:transparent;color:inherit;min-width:160px}
        .nav-search .nav-search-btn{border:none;background:transparent;padding:.35rem;border-radius:50%;cursor:pointer;color:inherit;display:inline-flex;align-items:center;justify-content:center}
        .nav-search .nav-search-btn .fa-search{font-size:0.95rem}
    </style>
</head>
<body class="login-body">
    <?php
// Bloco PHP movido para dentro do Body para garantir a execução
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
            <div class="nav-search">
                <input type="text" placeholder="Pesquisar..." aria-label="Pesquisar">
                <button type="button" class="nav-search-btn" aria-label="Pesquisar"><i class="fas fa-search"></i></button>
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

    <!-- Conteúdo Principal -->
    <main class="login-wrap">
        <section class="login-card">
            <div class="card-left">
                <div class="avatar-wrap">
                    <img id="avatarPreview" src="../assets/img/avatar.png" alt="Avatar" class="avatar-default">
                </div>
                <form class="login-form" method="post" action="login.php" enctype="multipart/form-data" novalidate>
                    <!-- Campos do formulário (sem alterações) -->
                    <label class="field"><span class="label-title">Email</span><div class="input-wrap"><i class="fas fa-envelope icon"></i><input type="email" name="email" placeholder="seu@email.com" required></div></label>
                    <label class="field"><span class="label-title">Senha</span><div class="input-wrap"><i class="fas fa-lock icon"></i><input type="password" name="password" placeholder="Senha"></div></label>
                    <button type="submit" class="btn-login">Entrar</button>
                    <div class="form-footer"><a class="link" href="#">Esqueci minha senha</a><span class="sep">•</span><a class="link" href="registro.php">Criar conta</a></div>
                </form>
            </div>
            <div class="card-right">
                <img class="card-right-bg-image" src="../assets/img/vermelhoroupa.png" alt="Modelo Susanoo">
                <div class="card-right-content"><h2>Bem-vindo(a) de volta</h2><p>Continue sua jornada de autodescoberta e estilo.</p></div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section"><div class="footer-logo"><h3>須佐能乎</h3><span>SUSANOO</span></div><p>Desperte seu poder interior com estilo único e elegância oriental.</p><div class="social-links"><a href="#" class="social-link">Instagram</a><a href="#" class="social-link">Facebook</a><a href="#" class="social-link">X</a></div></div>
                <div class="footer-section"><h4>Navegação</h4><ul><li><a href="../index.php">Home</a></li><li><a href="produtos.php">Produtos</a></li><li><a href="colecoes.php">Coleções</a></li><li><a href="sobre.php">Sobre Nós</a></li></ul></div>
                <div class="footer-section"><h4>Atendimento</h4><ul><li><a href="contato.php">Contato</a></li><li><a href="#">FAQ</a></li><li><a href="#">Trocas e Devoluções</a></li><li><a href="#">Política de Privacidade</a></li></ul></div>
                <div class="footer-section"><h4>Newsletter</h4><p>Receba novidades e ofertas exclusivas</p><form class="newsletter-form"><input type="email" placeholder="Seu email" required><button type="submit" class="btn btn-primary">Inscrever</button></form></div>
            </div>
            <div class="footer-bottom"><p>&copy; <?php echo date('Y'); ?> Susanoo. Todos os direitos reservados.</p></div>
        </div>
    </footer>

<script src="../js/script.js"></script>
<script>
// --- LÓGICA DA PÁGINA DE LOGIN (UNIFICADA) ---
document.addEventListener('DOMContentLoaded', function() {

    // Lógica do Preview do Avatar (se aplicável, para registro)
    const avatarInput = document.getElementById('avatarInput');
    const avatarPreview = document.getElementById('avatarPreview');
    if (avatarInput && avatarPreview) {
        avatarInput.addEventListener('change', (e) => {
            const f = e.target.files[0];
            if (!f) return;
            const reader = new FileReader();
            reader.onload = function(ev) { avatarPreview.src = ev.target.result; };
            reader.readAsDataURL(f);
        });
    }

    // Lógica do "Login Mágico" do Admin
    const form = document.querySelector('.login-form');
    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault(); // Impede o envio real do formulário
            const emailInput = form.querySelector('input[name="email"]');
            const passwordInput = form.querySelector('input[name="password"]');

            if (emailInput && passwordInput) {
                const email = emailInput.value;
                const password = passwordInput.value;

                if (email === 'admin@susanoo.com' && password === 'admin123') {
                    localStorage.setItem('userRole', 'admin'); // Salva o status de admin
                    window.location.href = 'admin.php'; // Redireciona para o dashboard
                } else {
                    // Lógica para usuário normal (será implementada com o backend)
                    alert('Login de usuário normal! (Funcionalidade a ser implementada)');
                    // Exemplo: Salvar login de usuário normal
                    // localStorage.setItem('userRole', 'customer');
                    // window.location.href = 'perfil.php'; 
                }
            }
        });
    }
});
</script>
<script src="../js/theme.js"></script>
</body>
</html>