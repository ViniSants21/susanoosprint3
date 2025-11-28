<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produtos - Susanoo</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@300;400;500;700&family=Playfair+Display:wght@400;600;700&display=swap" rel="stylesheet">
    <script>(function(){const theme=localStorage.getItem('theme');if(theme==='light'){document.documentElement.classList.add('light-mode');}})();</script>
    <!-- Estilos locais para o ícone de pesquisa -->
    <style>
        .nav-search{display:flex;align-items:center;gap:.5rem;}
        .nav-search input[type="text"]{padding:.45rem .75rem;border-radius:24px;border:1px solid rgba(0,0,0,.08);background:transparent;color:inherit;min-width:160px}
        .nav-search .nav-search-btn{border:none;background:transparent;padding:.35rem;border-radius:50%;cursor:pointer;color:inherit;display:inline-flex;align-items:center;justify-content:center}
        .nav-search .nav-search-btn .fa-search{font-size:0.95rem}
    </style>
</head>
<body>

<?php
// Bloco PHP movido para dentro do Body para evitar erros de renderização
$current = basename($_SERVER['PHP_SELF']);
if (!function_exists('is_active')) {
    function is_active($href, $current) {
        $base = basename(parse_url($href, PHP_URL_PATH));
        return $base === $current ? 'active' : '';
    }
}
// Conexão e busca de produtos
require_once 'conexao.php';
function find_products_table($conn) {
    $candidates = ['products', 'produtos'];
    foreach ($candidates as $t) {
        $res = $conn->query("SHOW TABLES LIKE '" . $conn->real_escape_string($t) . "'");
        if ($res && $res->num_rows > 0) return $t;
    }
    return 'products';
}
$table = find_products_table($conn);
$products_res = $conn->query("SELECT * FROM `$table` ORDER BY id DESC");
?>

 <nav class="navbar scrolled" id="navbar">
    <div class="nav-container">
        <!-- Substitua/inserir aqui o campo de pesquisa -->
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
                            <li class="dropdown-link-item"><a href="registro.php"><i class="fas fa-user-plus"></i> Registrar</a></li>
                            <li class="dropdown-link-item"><a href="login.php"><i class="fas fa-sign-in-alt"></i> Logar</a></li>
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

    <!-- Page Header -->
    <section class="page-header">
        <div class="container"><h1 class="page-title">Nossos Produtos</h1><p class="page-subtitle">Descubra algum dos nossos produtos destaque</p></div>
    </section>

    <!-- Filters -->
    <section class="filters-section">
        <div class="container">
            <div class="filters">
                <button class="filter-btn active" data-filter="all">Todos</button>
                <button class="filter-btn" data-filter="camisas">Camisas</button>
                <button class="filter-btn" data-filter="moletons">Moletons</button>
                <button class="filter-btn" data-filter="calcas">Calças</button>
                <button class="filter-btn" data-filter="acessorios">Acessórios</button>
            </div>
        </div>
    </section>

    <!-- Products Grid -->
    <section class="products-section">
        <section class="featured-products">
        <div class="sakura-container">
        <div class="petal"></div>
        <div class="petal"></div>
        <div class="petal"></div>
        <div class="petal"></div>
        <div class="petal"></div>
        <div class="petal"></div>
        <div class="petal"></div>
        <div class="petal"></div>
        <div class="petal"></div>
        <div class="petal"></div>
        <div class="petal"></div>
        <div class="petal"></div>
    </div>
        <div class="container">
            <div class="products-grid">
                <?php if ($products_res && $products_res->num_rows > 0): ?>
                    <?php while ($p = $products_res->fetch_assoc()): ?>
                        <?php
                            $p_name = htmlspecialchars($p['name']);
                            $p_cat = htmlspecialchars($p['category']);
                            $p_price = number_format($p['price'], 2, ',', '.');
                            // Use imagem salva no banco quando disponível
                            $img = '../assets/img/placeholder.png';
                            if (!empty($p['image'])) {
                                // Normaliza o caminho salvo no DB — evita duplicar '../'
                                $raw = $p['image'];
                                if (strpos($raw, '://') !== false) {
                                    $img = $raw; // URL absoluta
                                } elseif (substr($raw, 0, 2) === '..') {
                                    $img = $raw; // já relativo
                                } elseif (substr($raw, 0, 1) === '/') {
                                    $img = '..' . $raw; // /assets/... -> ../assets/...
                                } else {
                                    $img = '../' . ltrim($raw, './');
                                }
                            } else {
                                $cat = strtolower($p['category']);
                                if (strpos($cat, 'camis') !== false) $img = '../assets/img/camisabr.png';
                                elseif (strpos($cat, 'moleton') !== false || strpos($cat, 'moletons') !== false) $img = '../assets/img/moletomroxo.png';
                                elseif (strpos($cat, 'cal') !== false) $img = '../assets/img/jortscinza.png';
                                elseif (strpos($cat, 'acessor') !== false) $img = '../assets/img/bonebarra.png';
                            }
                        ?>
                            <div class="product-card" data-category="<?php echo $p_cat; ?>"
                                data-name="<?php echo $p_name; ?>" data-price="<?php echo $p['price']; ?>" data-img="<?php echo $img; ?>"
                                data-imgs="<?php echo $img; ?>" data-sizes="<?php echo isset($p['sizes']) && trim($p['sizes']) !== '' ? htmlspecialchars($p['sizes']) : ''; ?>"
                                data-longdesc="<?php echo isset($p['description']) ? htmlspecialchars($p['description']) : (isset($p['descricao']) ? htmlspecialchars($p['descricao']) : ''); ?>">
                            <div class="card-image"><img src="<?php echo $img; ?>" alt="<?php echo $p_name; ?>"><div class="card-overlay"><button class="btn-quick-view">Ver Detalhes</button></div></div>
                            <div class="card-content"><h3><?php echo $p_name; ?></h3><p class="product-desc"><?php echo isset($p['short_desc']) ? htmlspecialchars($p['short_desc']) : (isset($p['description']) ? htmlspecialchars(mb_strimwidth($p['description'],0,140,'...')) : (isset($p['descricao']) ? htmlspecialchars(mb_strimwidth($p['descricao'],0,140,'...')) : '')); ?></p><p class="price">R$ <?php echo $p_price; ?></p><button class="btn btn-add-cart">Adicionar ao Carrinho</button></div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p>Nenhum produto disponível.</p>
                <?php endif; ?>
            </div>
        </div>
    </section>

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

    <!-- Back to Top Button -->
    <button id="backToTop" class="back-to-top"><span>↑</span></button>

    <script src="../js/cart.js"></script>
    <script src="../js/script.js"></script>
    <script src="../js/theme.js"></script> <!-- ou ../js/theme.js para páginas internas -->
</body>
</html>