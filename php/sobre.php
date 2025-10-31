<!-- davi de assis fabricio -->
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sobre Nós - Susanoo</title>
    <link rel="stylesheet" href="../css/style.css"> 
    <link rel="stylesheet" href="../css/sobre.css"> 
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@300;400;500;700&family=Playfair+Display:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script>(function(){const theme=localStorage.getItem('theme');if(theme==='light'){document.documentElement.classList.add('light-mode');}})();</script>
</head>
<body>
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
                <li><a href="../index.php" class="nav-link <?php echo is_active('index.php', $current); ?>">Home</a></li>
                <li><a href="produtos.php" class="nav-link <?php echo is_active('produtos.php', $current); ?>">Produtos</a></li>
                <li><a href="colecoes.php" class="nav-link <?php echo is_active('colecoes.php', $current); ?>">Coleções</a></li>
                <li><a href="sobre.php" class="nav-link <?php echo is_active('sobre.php', $current); ?>">Sobre</a></li>
                <li><a href="contato.php" class="nav-link <?php echo is_active('contato.php', $current); ?>">Contato</a></li>
            </ul>
            <div class="nav-icons">
                <!-- NOVO: Dropdown do Perfil -->
                <div class="profile-dropdown-wrapper">
                    <a href="login.php" class="nav-icon-link" aria-label="Login"><i class="fas fa-user"></i></a>
                    <div class="profile-dropdown-menu">
                        <div class="dropdown-header">
                            <img src="../assets/img/avatar.png" alt="Avatar" class="dropdown-avatar">
                            <div>
                                <div class="dropdown-user-name">Seu Nome</div>
                                <div class="dropdown-user-email">seu@email.com</div>
                            </div>
                        </div>
                        <ul class="dropdown-links">
                            <li class="dropdown-link-item"><a href="perfil.php"><i class="fas fa-id-card"></i> Visualizar Perfil</a></li>
                            <li class="dropdown-link-item"><a href="configuracoes.php"><i class="fas fa-cog"></i> Configurações</a></li>
                        </ul>
                    </div>
                </div>
                <!-- Fim do Dropdown -->
                <a href="carrinho.php" class="nav-icon-link" aria-label="Carrinho"><i class="fas fa-shopping-bag"></i></a>
            </div>
        </div>
        <div class="hamburger" id="hamburger"><span></span><span></span><span></span></div>
    </div>
</nav>
    <!-- Conteúdo principal da página Sobre -->
    <main class="about-page-content">

        <!-- Hero Section com Título Duplo -->
        <section class="about-hero">
            <div class="about-hero-content">
                <h2 class="hero-japanese-name">須佐能乎</h2>
                <h1 class="about-title-main">Susanoo</h1>
                <p class="about-title-sub">O Estilo que Domina as Ruas</p>
            </div>
        </section>

        <!-- Seção de Missão, Visão e Valores -->
        <section class="mission-vision-values">
            <div class="container">
                <div class="mvv-grid">
                    <div class="mvv-card animate-on-scroll">
                        <div class="card-content">
                            <h3>Nossa Missão</h3>
                            <p>Democratizar o streetwear de inspiração japonesa, oferecendo peças de alta qualidade, design exclusivo e preço justo para que todos possam expressar seu poder interior.</p>
                        </div>
                    </div>
                    <div class="mvv-card animate-on-scroll" style="animation-delay: 0.2s;">
                        <div class="card-content">
                            <h3>Nossa Visão</h3>
                            <p>Ser a marca líder em moda streetwear japonesa no Brasil, reconhecida pela autenticidade e por criar uma comunidade forte e conectada pela cultura urbana e oriental.</p>
                        </div>
                    </div>
                    <div class="mvv-card animate-on-scroll" style="animation-delay: 0.4s;">
                        <div class="card-content">
                            <h3>Nossos Valores</h3>
                            <p>Autenticidade, Qualidade, Acessibilidade e Comunidade. Valorizamos a cultura de rua, o respeito às origens e a criatividade como forma de expressão.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Seção: Por Trás do Nome -->
        <section class="behind-the-name">
            <div class="container name-container">
                <div class="name-text animate-on-scroll">
                    <h2 class="section-title">Por Trás do Nome</h2>
                    <p>Nosso nome é uma homenagem a <strong>Susanoo-no-Mikoto (須佐能乎命)</strong>, uma poderosa divindade da mitologia japonesa. Deus da tempestade e do mar, ele representa a dualidade da natureza: a força destrutiva e o poder de criar.</p>
                    <p>Essa energia rebelde, indomável e autêntica é a essência da nossa marca. Assim como Susanoo, o streetwear nasceu nas ruas, com uma força que desafiou o status quo. Queremos que você sinta esse poder.</p>
                </div>
                <div class="name-visual animate-on-scroll">
                    <!-- A imagem de fundo será colocada via CSS -->
                </div>
            </div>
        </section>

        <!-- Seção: Linha do Tempo da História -->
        <section class="our-history">
            <div class="container">
                <div class="section-header">
                    <h2 class="section-title">Nossa Jornada</h2>
                    <p class="section-subtitle">Das ruas para o seu guarda-roupa</p>
                </div>
                
                <div class="history-timeline">
                    <div class="timeline-line"></div>
                    
                    <div class="timeline-item animate-on-scroll">
                        <div class="timeline-node"></div>
                        <div class="timeline-content"><h3>A Faísca</h3><p>A ideia da Susanoo surgiu da frustração. Víamos o streetwear se tornar caro e inacessível, perdendo sua alma: a voz das ruas. Decidimos mudar essa realidade.</p></div>
                    </div>
                    
                    <div class="timeline-item animate-on-scroll">
                        <div class="timeline-node"></div>
                        <div class="timeline-content"><h3>A Fundação</h3><p>Com um propósito claro, fundamos a marca: criar peças com design autêntico e custo-benefício real, unindo a estética japonesa à cultura urbana global.</p></div>
                    </div>

                    <div class="timeline-item animate-on-scroll">
                        <div class="timeline-node"></div>
                        <div class="timeline-content"><h3>A Identidade</h3><p>O nome "Susanoo" foi escolhido para simbolizar a força, a rebeldia e a energia indomável que acreditamos que a moda de rua deve ter. Cada peça carrega essa energia.</p></div>
                    </div>

                    <div class="timeline-item animate-on-scroll">
                        <div class="timeline-node"></div>
                        <div class="timeline-content"><h3>O Futuro</h3><p>Hoje, continuamos a crescer, não apenas como uma marca, mas como uma comunidade. Convidamos você a se juntar à nossa jornada e despertar seu poder interior.</p></div>
                    </div>
                </div>
            </div>
        </section>

    </main>

    <!-- Footer Completo -->
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
                        <a href="#" class="social-link">Twitter</a>
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

    <button id="backToTop" class="back-to-top"><span>↑</span></button>

    <script src="../js/script.js"></script>
    <script src="../js/sobre-anim.js"></script> 
    <script src="../js/theme.js"></script> <!-- ou ../js/theme.js para páginas internas -->
</body>
</html>