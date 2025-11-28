<?php
session_start();
require 'conexao.php'; // Certifique-se que o conexao.php está no mesmo diretório ou ajuste o caminho (ex: ../conexao.php)

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        if (password_verify($senha, $user['senha'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['nome'] = $user['nome'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['foto'] = $user['foto'];

            header("Location: ../index.php");
            exit;
        } else {
            $erro = "Senha incorreta";
        }
    } else {
        $erro = "Email não encontrado";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Susanoo</title>
    
    <!-- CSS corrigido para voltar um diretório (../) -->
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/login-style.css"> <!-- Assumindo que você tem esse CSS específico -->
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    
    <!-- Script de Tema -->
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
            <!-- Logo ajustada -->
            <div class="nav-logo"><a href="../index.php"><img src="../assets/img/LOGOSUSANOO.png" alt="LOGOSUSANOO"></a></div>
            <div class="nav-right-group">
                <ul class="nav-menu" id="nav-menu">
                    <li><a href="../index.php" class="nav-link <?php echo is_active('../index.php', $current); ?>">Home</a></li>
                    <li><a href="produtos.php" class="nav-link <?php echo is_active('produtos.php', $current); ?>">Produtos</a></li>
                    <li><a href="colecoes.php" class="nav-link <?php echo is_active('colecoes.php', $current); ?>">Coleções</a></li>
                    <li><a href="sobre.php" class="nav-link <?php echo is_active('sobre.php', $current); ?>">Sobre</a></li>
                    <li><a href="contato.php" class="nav-link <?php echo is_active('contato.php', $current); ?>">Contato</a></li>
                </ul>
                <div class="nav-icons">
                    <div class="profile-dropdown-wrapper">
                        <a href="#" class="nav-icon-link" aria-label="Login" style="pointer-events: none;"><i class="fas fa-user"></i></a>
                        <div class="profile-dropdown-menu">
                            <!-- Se não estiver logado, mostra opções de login/registro -->
                            <ul class="dropdown-links">
                                <li class="dropdown-link-item"><a href="registro.php"><i class="fas fa-user-plus"></i> Registrar</a></li>
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

    <!-- Conteúdo Principal -->
    <main class="login-wrap">
        <section class="login-card">
            <div class="card-left">
                <div class="avatar-wrap">
                    <img id="avatarPreview" src="../assets/img/avatar.png" alt="Avatar" class="avatar-default">
                </div>
                
                <!-- Exibição de Erro PHP -->
                <?php if(isset($erro)): ?>
                    <p style='color:red; text-align:center; margin-bottom:10px;'><?php echo $erro; ?></p>
                <?php endif; ?>

                <form class="login-form" method="post" action="login.php" enctype="multipart/form-data" novalidate>
                    <label class="field">
                        <span class="label-title">Email</span>
                        <div class="input-wrap">
                            <i class="fas fa-envelope icon"></i>
                            <input type="email" name="email" placeholder="seu@email.com" required>
                        </div>
                    </label>
                    <label class="field">
                        <span class="label-title">Senha</span>
                        <div class="input-wrap">
                            <i class="fas fa-lock icon"></i>
                            <input type="password" name="senha" placeholder="Senha" required> <!-- Corrigido name="password" para name="senha" conforme seu PHP -->
                        </div>
                    </label>
                    <button type="submit" class="btn-login">Entrar</button>
                    <div class="form-footer">
                        <a class="link" href="#">Esqueci minha senha</a>
                        <span class="sep">•</span>
                        <a class="link" href="registro.php">Criar conta</a>
                    </div>
                </form>
            </div>
            <div class="card-right">
                <img class="card-right-bg-image" src="../assets/img/vermelhoroupa.png" alt="Modelo Susanoo">
                <div class="card-right-content">
                    <h2>Bem-vindo(a) de volta</h2>
                    <p>Continue sua jornada de autodescoberta e estilo.</p>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <div class="footer-logo"><h3>須佐能乎</h3><span>SUSANOO</span></div>
                    <p>Desperte seu poder interior com estilo único e elegância oriental.</p>
                    <div class="social-links">
                        <a href="#" class="social-link">Instagram</a>
                        <a href="#" class="social-link">Facebook</a>
                        <a href="#" class="social-link">X</a>
                    </div>
                </div>
                <div class="footer-section">
                    <h4>Navegação</h4>
                    <ul>
                        <li><a href="../index.php">Home</a></li>
                        <li><a href="produtos.php">Produtos</a></li>
                        <li><a href="colecoes.php">Coleções</a></li>
                        <li><a href="sobre.php">Sobre Nós</a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h4>Atendimento</h4>
                    <ul>
                        <li><a href="contato.php">Contato</a></li>
                        <li><a href="#">FAQ</a></li>
                        <li><a href="#">Trocas e Devoluções</a></li>
                        <li><a href="#">Política de Privacidade</a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h4>Newsletter</h4>
                    <p>Receba novidades e ofertas exclusivas</p>
                    <form class="newsletter-form">
                        <input type="email" placeholder="Seu email" required>
                        <button type="submit" class="btn btn-primary">Inscrever</button>
                    </form>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; <?php echo date('Y'); ?> Susanoo. Todos os direitos reservados.</p>
            </div>
        </div>
    </footer>

    <!-- Scripts - CORRIGIDOS -->
    <!-- O erro principal estava aqui. Adicionado "../" para acessar a pasta js na raiz -->
    <script src="../js/cart.js"></script>
    <script src="../js/script.js"></script>
    <script src="../js/theme.js"></script> 

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Lógica simples para Preview do Avatar (se necessário)
        const avatarInput = document.getElementById('avatarInput'); // Nota: Seu form não tem esse input, mas mantive o JS
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
    });
    </script>

</body>
</html>