<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contato - Susanoo</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/contato.css">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@300;400;500;700&family=Playfair+Display:wght@400;600;700&display=swap" rel="stylesheet">
    <!-- Adicione este link para os ícones (Font Awesome) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script>(function(){const theme=localStorage.getItem('theme');if(theme==='light'){document.documentElement.classList.add('light-mode');}})();</script>
 
    <!-- Estilos para o campo de pesquisa com ícone -->
    <style>
        .nav-search{display:flex;align-items:center;gap:.5rem;}
        .nav-search input[type="text"]{padding:.45rem .75rem;border-radius:24px;border:1px solid rgba(0,0,0,.12);background:transparent;color:inherit;min-width:160px}
        .nav-search .nav-search-btn{border:none;background:transparent;padding:.35rem;border-radius:50%;cursor:pointer;color:inherit;display:inline-flex;align-items:center;justify-content:center}
        .nav-search .nav-search-btn .fa-search{font-size:0.95rem}
        .nav-search .nav-search-btn:focus{outline:2px solid rgba(124,58,237,.18)}
        @media (prefers-color-scheme: dark){
            .nav-search input[type="text"]{border:1px solid rgba(255,255,255,.08)}
        }
        
        /* CORREÇÃO: Estilos para remover sublinhado dos links de redes sociais */
        .social-links a, /* Para os links de texto no footer */
        .social-links-contact a { /* Para os ícones na seção de contato */
            text-decoration: none;
        }
    </style>
 
    <!-- Remover o CSS do SweetAlert2 -->
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css"> -->
</head>
 
<body>
    <?php
    // Bloco PHP para o link ativo do menu
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
                                <a href="../php/registro.php"><i class="fas fa-user-plus"></i>Registrar</a>
                                </li>
                                <li class="dropdown-link-item">
                                    <a href="../php/login.php"><i class="fas fa-sign-in-alt"></i>Login</a>
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
                <!-- Fim do Dropdown -->
                <a href="carrinho.php" class="nav-icon-link" aria-label="Carrinho"><i class="fas fa-shopping-bag"></i></a>
            </div>
        </div>
        <div class="hamburger" id="hamburger"><span></span><span></span><span></span></div>
    </div>
</nav>
   
    <main class="contact-page">
        <!-- Elemento de fundo para o efeito de gradiente animado -->
        <div class="background-gradient"></div>
 
            <div class="contact-container">
                <!-- Lado Esquerdo: Formulário -->
                <div class="contact-form-wrapper">
                    <div class="form-header">
                        <h1 class="form-title">Entre em Contato</h1>
                        <p class="form-subtitle">Sua jornada de autodescoberta começa com uma conversa.</p>
                    </div>
                    <form id="contactForm">
                        <div class="form-group">
                            <input type="text" id="name" name="name" required>
                            <label for="name">Nome Completo</label>
                        </div>
                        <div class="form-group">
                            <input type="email" id="email" name="email" required>
                            <label for="email">Seu Melhor E-mail</label>
                        </div>
                        <div class="form-group">
                            <input type="text" id="subject" name="subject" required>
                            <label for="subject">Assunto</label>
                        </div>
                        <div class="form-group">
                            <textarea id="message" name="message" rows="5" required></textarea>
                            <label for="message">Sua Mensagem</label>
                        </div>
                        <button type="submit" class="btn btn-primary btn-submit">
                            <span>Enviar Mensagem</span>
                        </button>
                    </form>
                </div>
 
            <!-- Lado Direito: Informações -->
            <div class="contact-info-wrapper">
                <div class="info-content">
                    <h2 class="info-title">Nossos Canais</h2>
                    <p class="info-description">Prefere outros meios? Nos encontre aqui:</p>
                    <ul class="info-list">
                        <li>
                            <span class="info-icon"><i class="fas fa-envelope"></i></span>
                            <div class="info-text">
                                <strong>E-mail</strong>
                                <a href="mailto:contato@susanoo.com">contatosusanoo@susanoo.com</a>
                            </div>
                        </li>
                        <li>
                            <span class="info-icon"><i class="fas fa-phone-alt"></i></span>
                            <div class="info-text">
                                <strong>Telefone</strong>
                                <a href="tel:+5512999998888">+55 (12) 99703-5066</a>
                            </div>
                        </li>
                        <li>
                            <span class="info-icon"><i class="fas fa-map-marker-alt"></i></span>
                            <div class="info-text">
                                <strong>Endereço</strong>
                                <p>Av. Monsenhor Theodomiro Lobo, 100 - Parque Res. Maria Elmira, Caçapava - SP</p>
                            </div>
                        </li>
                    </ul>
                    <div class="social-links-contact">
                        <a href="#" title="Instagram"><i class="fab fa-instagram"></i></a>
                        <a href="#" title="Facebook"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" title="X (Twitter)"><i class="fab fa-x-twitter"></i></a> 
                    </div>
                </div>
            </div>
        </div>
    </main>
   
    <!-- Footer colado diretamente -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <div class="footer-logo">
                        <h3>須佐能乎</h3>
                        <span>SUSANOO</span>
                    </div>
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
                <p>&copy; 2025 Susanoo. Todos os direitos reservados por Davi de Assis, Kauã souza, Lucas Limas e Vinicius Queiroz.</p>
            </div>
        </div>
    </footer>
    <script src="../js/theme.js"></script> <!-- ou ../js/theme.js para páginas internas -->
    <script src="../js/cart.js"></script>
    <script src="../js/script.js"></script>
 
    <!-- Remover o JS do SweetAlert2 -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> -->
 
    <script>
    document.getElementById('contactForm').addEventListener('submit', function(event) {
        event.preventDefault();
 
        var name = document.getElementById('name').value;
        var email = document.getElementById('email').value;
        var subject = document.getElementById('subject').value;
        var message = document.getElementById('message').value;
 
        if (name === '' || email === '' || subject === '' || message === '') {
            alert('Por favor, preencha todos os campos!');
            return;
        }
 
        alert('Mensagem enviada!');
        window.location.href = "../index.php"; // Redireciona para o index após mostrar a mensagem
    });
    </script>
</body>
</html>