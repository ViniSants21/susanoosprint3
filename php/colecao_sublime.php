<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coleção Sublime</title>
    <link rel="stylesheet" href="../css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@300;400;500;700&family=Playfair+Display:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script>
        (function() {
            const theme = localStorage.getItem('theme');
            if (theme === 'light') {
                document.documentElement.classList.add('light-mode');
            }
        })();
    </script>
    <style>
        .nav-search{display:flex;align-items:center;gap:.5rem;}
        .nav-search input[type="text"]{padding:.45rem .75rem;border-radius:24px;border:1px solid rgba(0,0,0,.08);background:transparent;color:inherit;min-width:160px}
        .nav-search .nav-search-btn{border:none;background:transparent;padding:.35rem;border-radius:50%;cursor:pointer;color:inherit;display:inline-flex;align-items:center;justify-content:center}
        .nav-search .nav-search-btn .fa-search{font-size:0.95rem}

         /* --- Banner Promocional --- */
        .promo-banner-section {
            width: 100vw;
            position: relative;
            left: 50%;
            right: 50%;
            margin-left: -50vw;
            margin-right: -50vw;
            margin-top: -11px;
            height: 500px; 
            margin-bottom: -180px; /* Sobrepõe o conteúdo principal levemente */
            overflow: hidden;
        }
        .promo-banner-link {
            display: block;
            width: 100%;
            height: 100%;
        }
        .promo-banner-image {
            width: 100%;
            height: 100%;
            display: block;
            object-fit: cover;
            object-position: center;
        }

        /* Estilo para o botão esgotado */
        .btn-disabled {
            background-color: #2a2a2a !important;
            color: #777 !important;
            cursor: not-allowed !important;
            border: 1px solid #444 !important;
            pointer-events: none;
        }

    </style>
</head>

<?php
// === LÓGICA PHP INSERIDA AQUI ===
require_once 'conexao.php';

// Função auxiliar para achar tabela (igual ao produtos.php)
function find_products_table($conn) {
    $candidates = ['products', 'produtos'];
    foreach ($candidates as $t) {
        $res = $conn->query("SHOW TABLES LIKE '" . $conn->real_escape_string($t) . "'");
        if ($res && $res->num_rows > 0) return $t;
    }
    return 'products';
}
$table = find_products_table($conn);

// Seleciona APENAS produtos da coleção Sublime
$stmt = $conn->prepare("SELECT * FROM `$table` WHERE collection = 'sublime' ORDER BY id DESC");
$stmt->execute();
$products_res = $stmt->get_result();
// ==================================

$current = basename($_SERVER['PHP_SELF']);
if (!function_exists('is_active')) {
    function is_active($href, $current) {
        $base = basename(parse_url($href, PHP_URL_PATH));
        return $base === $current ? 'active' : '';
    }
}
?>

<body>

<!-- Navbar -->
<nav class="navbar" id="navbar">
    <div class="nav-container">
        <!-- Barra de busca -->
        <div class="nav-search">
            <input type="text" placeholder="Pesquisar..." aria-label="Pesquisar">
            <button class="nav-search-btn" aria-label="Pesquisar"><i class="fas fa-search"></i></button>
        </div>

        <!-- Logo central -->
        <div class="nav-logo">
            <a href="../index.php"><img src="../assets/img/LOGOSUSANOO.png" alt="LOGOSUSANOO"></a>
        </div>

        <!-- Menu e ícones à direita -->
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
                        <?php if (!isset($_SESSION)) { session_start(); } ?>
                        <?php if (!isset($_SESSION['user_id'])): ?>
                    <!-- USUÁRIO DESLOGADO -->
                        <a href="login.php" class="nav-icon-link" aria-label="Login">
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

        <!-- Menu hambúrguer -->
        <div class="hamburger" id="hamburger"><span></span><span></span><span></span></div>
    </div>
</nav>

<!-- Banner -->
<section class="promo-banner-section">
    <img src="../assets/img/ban2.png"
         alt="Banner promocional da nova coleção"
         class="promo-banner-image"
         style="pointer-events: none; cursor: default;">
</section>

<!-- Cabeçalho -->
<section class="page-header">
    <div class="container">
        <h1 class="page-title">Coleção Sublime</h1>
        <p class="page-subtitle">Vista a Coleção Sublime e transcenda o comum.</p>
    </div>
</section>

<!-- Produtos -->
<section class="products-section">
    <div class="container">
        <div class="products-grid">
            <?php if ($products_res && $products_res->num_rows > 0): ?>
                <?php while ($p = $products_res->fetch_assoc()): ?>
                    <?php
                        $p_name = htmlspecialchars($p['name']);
                        $p_cat = htmlspecialchars($p['category']);
                        $p_price = number_format($p['price'], 2, ',', '.');
                        
                        // --- LÓGICA DE ESTOQUE ---
                        $qtd_estoque = 0;
                        if (isset($p['estoque'])) {
                            $qtd_estoque = $p['estoque'];
                        } elseif (isset($p['stock'])) {
                            $qtd_estoque = $p['stock'];
                        }
                        
                        // --- LÓGICA DE DESCRIÇÃO CORRIGIDA ---
                        // 1. Descrição Completa (para o modal/quickview)
                        $rawLong = isset($p['descricao']) ? $p['descricao'] : (isset($p['description']) ? $p['description'] : '');
                        if (empty($rawLong) && isset($p['short_desc']) && !empty($p['short_desc'])) {
                            $rawLong = $p['short_desc'];
                        }

                        // 2. Descrição Curta (para o card)
                        $rawShort = isset($p['short_desc']) ? $p['short_desc'] : '';
                        if (empty($rawShort) && !empty($rawLong)) {
                            // Se não tiver descrição curta, trunca a longa em 100 caracteres
                            $rawShort = mb_strimwidth($rawLong, 0, 100, '...');
                        }
                        
                        $displayLong = htmlspecialchars($rawLong);
                        $displayShort = htmlspecialchars($rawShort);

                        // --- LÓGICA DE TAMANHOS DINÂMICA ---
                        $sizes_data = "P|M|G|GG"; 
                        if (isset($p['sizes']) && !empty($p['sizes'])) {
                            $sizes_data = $p['sizes'];
                        } else {
                            $cat_lower = strtolower($p['category']);
                            if (strpos($cat_lower, 'cal') !== false) {
                                $sizes_data = "38|40|42|44";
                            } elseif (strpos($cat_lower, 'acessor') !== false || strpos($cat_lower, 'bone') !== false || strpos($cat_lower, 'anel') !== false || strpos($cat_lower, 'colar') !== false) {
                                $sizes_data = "Único";
                            }
                        }

                        // --- LÓGICA DE IMAGEM (MÚLTIPLAS) ---
                        $img = '../assets/img/placeholder.png';
                        $raw_db_images = $p['image'] ?? '';
                        $images_array = explode('|', $raw_db_images);
                        $first_image = !empty($images_array) ? $images_array[0] : '';

                        if (!empty($first_image)) {
                            if (strpos($first_image, '://') !== false) {
                                $img = $first_image;
                            } elseif (substr($first_image, 0, 3) === '../') {
                                $img = $first_image;
                            } elseif (substr($first_image, 0, 1) === '/') {
                                $img = '..' . $first_image;
                            } else {
                                $img = '../' . ltrim($first_image, './');
                            }
                        } else {
                            // Fallback de categoria
                            $cat = strtolower($p['category']);
                            if (strpos($cat, 'camis') !== false) $img = '../assets/img/camisabr.png';
                            elseif (strpos($cat, 'moleton') !== false || strpos($cat, 'moletons') !== false) $img = '../assets/img/moletomroxo.png';
                            elseif (strpos($cat, 'cal') !== false) $img = '../assets/img/jortscinza.png';
                            elseif (strpos($cat, 'acessor') !== false) $img = '../assets/img/bonebarra.png';
                        }
                    ?>
                    
                    <div class="product-card" data-category="<?php echo $p_cat; ?>"
                        data-name="<?php echo $p_name; ?>" 
                        data-price="<?php echo $p['price']; ?>" 
                        data-img="<?php echo $img; ?>"
                        data-stock="<?php echo $qtd_estoque; ?>"
                        data-imgs="<?php echo htmlspecialchars($raw_db_images); ?>" 
                        data-sizes="<?php echo htmlspecialchars($sizes_data); ?>"
                        data-longdesc="<?php echo $displayLong; ?>">
                        
                        <div class="card-image">
                            <img src="<?php echo $img; ?>" alt="<?php echo $p_name; ?>">
                            <div class="card-overlay">
                                <button class="btn-quick-view">Ver Detalhes</button>
                            </div>
                        </div>
                        
                        <div class="card-content">
                            <h3><?php echo $p_name; ?></h3>
                            <!-- DESCRIÇÃO CURTA (Corrigido) -->
                            <p class="product-desc"><?php echo $displayShort; ?></p>
                            
                            <p class="price">R$ <?php echo $p_price; ?></p>
                            
                             <!-- BOTÃO COM VERIFICAÇÃO DE ESTOQUE -->
                             <?php if ($qtd_estoque > 0): ?>
                                <button class="btn btn-add-cart">Adicionar ao Carrinho</button>
                            <?php else: ?>
                                <button class="btn btn-disabled" disabled>Esgotado</button>
                            <?php endif; ?>
                            
                        </div>
                    </div>

                <?php endwhile; ?>
            <?php else: ?>
                <div style="grid-column: 1 / -1; text-align: center; padding: 2rem;">
                    <p>Nenhum produto encontrado nesta coleção.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- Rodapé -->
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
                    <a href="#">Instagram</a>
                    <a href="#">Facebook</a>
                    <a href="#">X</a>
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
            <p>&copy; 2024 Susanoo. Todos os direitos reservados.</p>
        </div>
    </div>
</footer>

<!-- Botão Voltar ao Topo -->
<button id="backToTop" class="back-to-top"><span>↑</span></button>

<script src="../js/script.js"></script>
<script src="../js/theme.js"></script>

</body>
</html>