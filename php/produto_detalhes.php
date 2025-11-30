<!DOCTYPE html>
<html lang="pt-BR">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Detalhes do Produto - Susanoo</title>

	<!-- CSS -->
	<link rel="stylesheet" href="../css/style.css">
	<link rel="stylesheet" href="../css/detalhes.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
	<link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@300;400;500;700&family=Playfair+Display:wght@400;600;700&display=swap" rel="stylesheet">

	<!-- Tema -->
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
<body class="detalhes-page">

<?php
$name = htmlspecialchars($_GET['name'] ?? 'Produto');
$shortDesc = htmlspecialchars($_GET['desc'] ?? 'Descrição não disponível.');
$price = htmlspecialchars($_GET['price'] ?? '');
$img = htmlspecialchars($_GET['img'] ?? '');
$category = htmlspecialchars($_GET['category'] ?? '');
$imgs_raw = $_GET['imgs'] ?? '';
$sizes_raw = $_GET['sizes'] ?? '';
$longdesc_raw = $_GET['longdesc'] ?? '';

$imgs = $imgs_raw ? array_map('htmlspecialchars', explode('|', $imgs_raw)) : [];
if (empty($imgs) && $img) $imgs[] = $img;

$sizes = $sizes_raw ? array_map('htmlspecialchars', explode('|', $sizes_raw)) : [];
// If no sizes provided from the product, provide sensible defaults by category
if (empty($sizes)) {
	$catLower = strtolower($category);
	if (strpos($catLower, 'camis') !== false || strpos($catLower, 'camisa') !== false) {
		$sizes = ['P','M','G','GG'];
	} elseif (strpos($catLower, 'cal') !== false || strpos($catLower, 'calça') !== false) {
		$sizes = ['38','40','42','44'];
	} else {
		$sizes = ['Único'];
	}
}

$longdesc = htmlspecialchars($longdesc_raw);

$current = basename($_SERVER['PHP_SELF']);
if (!function_exists('is_active')) {
	function is_active($href, $current) {
		$base = basename(parse_url($href, PHP_URL_PATH));
		return $base === $current ? 'active' : '';
	}
}
?>

<!-- Navbar -->
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
<li class="dropdown-link-item"><a href="php/logout.php"><i class="fas fa-sign-out-alt"></i> Sair</a></li>
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

<!-- Conteúdo Principal -->
<main class="product-page container">
	<div class="product-layout centered">
		<aside class="thumbs-col" aria-label="Miniaturas do produto">
			<?php if (!empty($imgs)): foreach ($imgs as $i => $u): ?>
				<button type="button" class="thumb <?php echo $i===0 ? 'active' : ''; ?>" data-src="<?php echo $u; ?>" style="background-image:url('<?php echo $u; ?>')"></button>
			<?php endforeach; endif; ?>
		</aside>

		<section class="image-col" aria-label="Imagem principal do produto">
			<div class="image-figure">
				<img id="mainImage" class="main-image" src="<?php echo $imgs[0] ?? '../assets/img/Camisapreta_essentials (1).png'; ?>" alt="<?php echo $name; ?>" />
			</div>
		</section>

		<aside class="details-col">
			<form id="addToCartForm" class="details-form">
				<input type="hidden" name="product_name" value="<?php echo $name; ?>">
				<input type="hidden" name="product_price" value="<?php echo $price; ?>">
				<input type="hidden" name="product_category" value="<?php echo $category; ?>">

				<h1 class="title"><?php echo $name; ?></h1>
				<?php if ($category): ?><div class="category"><?php echo $category; ?></div><?php endif; ?>
				<?php if ($price): ?><div class="price"><?php echo $price; ?></div><?php endif; ?>

					<div class="sizes" role="radiogroup" aria-label="Tamanhos">
						<?php foreach ($sizes as $i => $s): ?>
							<label class="size">
								<input type="radio" name="size" value="<?php echo $s; ?>" <?php echo $i === 0 ? 'checked' : ''; ?>>
								<span><?php echo $s; ?></span>
							</label>
						<?php endforeach; ?>
					</div>

				<div class="actions">
					<button type="submit" class="btn-cta">Adicionar ao carrinho</button>
					<button type="button" id="favBtn" class="btn-fav" aria-pressed="false" title="Favoritar">♡</button>
				</div>	
				<button type="button" class="btn-size-chart" id="openSizeChart">Ver Tabela de Tamanhos</button>

				<section class="description">
					<h3>Descrição completa</h3>
					<p><?php echo nl2br($longdesc ?: $shortDesc); ?></p>
				</section>
			</form>
		</aside>
	</div>
</main>

<!-- Modal para Tabela de Tamanhos -->
<div class="size-chart-modal" id="sizeChartModal" data-category="<?php echo htmlspecialchars(strtolower($category)); ?>">
    <div class="size-chart-content">
        <button class="close-size-chart" id="closeSizeChart">&times;</button>
        <table class="size-chart-table" id="shirtSizeChart">
            <caption>Tabela de Tamanhos - Camisas</caption>
            <thead>
                <tr>
                    <th>Tamanho</th>
                    <th>Peito (cm)</th>
                    <th>Cintura (cm)</th>
                    <th>Comprimento (cm)</th>
                </tr>
            </thead>
            <tbody>
                <tr><td>P</td><td>88-92</td><td>76-80</td><td>65</td></tr>
                <tr><td>M</td><td>93-97</td><td>81-85</td><td>68</td></tr>
                <tr><td>G</td><td>98-102</td><td>86-90</td><td>71</td></tr>
                <tr><td>GG</td><td>103-107</td><td>91-95</td><td>74</td></tr>
                <tr><td>XG</td><td>108-112</td><td>96-100</td><td>77</td></tr>
            </tbody>
        </table>
        <table class="size-chart-table" id="pantsSizeChart">
            <caption>Tabela de Tamanhos - Calças</caption>
            <thead>
                <tr>
                    <th>Tamanho</th>
                    <th>Cintura (cm)</th>
                    <th>Quadril (cm)</th>
                    <th>Comprimento (cm)</th>
                </tr>
            </thead>
            <tbody>
                <tr><td>P</td><td>70-74</td><td>88-92</td><td>100</td></tr>
                <tr><td>M</td><td>75-79</td><td>93-97</td><td>103</td></tr>
                <tr><td>G</td><td>80-84</td><td>98-102</td><td>106</td></tr>
                <tr><td>GG</td><td>85-89</td><td>103-107</td><td>109</td></tr>
                <tr><td>XG</td><td>90-94</td><td>108-112</td><td>112</td></tr>
            </tbody>
        </table>
    </div>
</div>

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

</body>
<!-- JS -->
<script src="../js/cart.js"></script>
<script src="../js/script.js"></script>
<script src="../js/theme.js"></script>
</script>
<style>
/* Animação e cor para o coração de favorito */
.btn-fav {
  transition: color 0.2s;
  font-size: 1.6em;
  color: #888;
  outline: none;
  background: none;
  border: none;
  cursor: pointer;
  vertical-align: middle;
  will-change: transform;
}
.btn-fav.favorited {
  color: #e63946;
  animation: fav-pop 0.35s cubic-bezier(.4,2,.6,1) both;
}
@keyframes fav-pop {
  0% { transform: scale(1); }
  40% { transform: scale(1.4); }
  60% { transform: scale(0.9); }
  100% { transform: scale(1); }
}

/* Estilos para o modal da tabela de tamanhos */
.size-chart-modal {
  display: none;
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.8);
  z-index: 1000;
  justify-content: center;
  align-items: center;
}

.size-chart-content {
  background: #1e1e2e;
  padding: 2rem;
  border-radius: 8px;
  position: relative;
  max-width: 90%;
  margin: 0 auto;
  color: #e0e0e0;
}

.size-chart-table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 1rem;
}

.size-chart-table th,
.size-chart-table td {
  padding: 0.75rem;
  text-align: center;
  border: 1px solid #444;
}

.size-chart-table th {
  background: #333;
  color: #f0f0f0;
}

.close-size-chart {
  position: absolute;
  top: 1rem;
  right: 1rem;
  background: none;
  border: none;
  color: #e63946;
  font-size: 1.5rem;
  cursor: pointer;
}
</style>
<script>
// Corrige adicionar ao carrinho, favoritar e troca de imagem
document.addEventListener('DOMContentLoaded', function() {
	// --- Adicionar ao carrinho ---
	const addToCartForm = document.getElementById('addToCartForm');
	if (addToCartForm) {
		addToCartForm.addEventListener('submit', function(e) {
			e.preventDefault();
			const name = addToCartForm.querySelector('input[name="product_name"]').value;
			const priceText = addToCartForm.querySelector('input[name="product_price"]').value;
			const price = parseFloat(priceText.replace('R$', '').replace(',', '.').trim());
			const category = addToCartForm.querySelector('input[name="product_category"]').value;
			const sizeInput = addToCartForm.querySelector('input[name="size"]:checked');
			const size = sizeInput ? sizeInput.value : '';
			const image = document.getElementById('mainImage')?.src || '';
			// Cria um id único para o produto + tamanho
			const id = (name + '-' + size).replace(/\s+/g, '-').toLowerCase();
			if (typeof addToCart === 'function') {
				addToCart({ id, name, price, image, size, category });
				// Feedback visual
				const btn = addToCartForm.querySelector('.btn-cta');
				if (btn) {
					const original = btn.textContent;
					btn.textContent = 'Adicionado!';
					btn.style.background = '#10B981';
					setTimeout(() => {
						btn.textContent = original;
						btn.style.background = '';
					}, 1800);
				}
			} else {
				alert('Erro ao adicionar ao carrinho.');
			}
		});
	}

	// --- Favoritar produto ---
	const favBtn = document.getElementById('favBtn');
	if (favBtn) {
		favBtn.addEventListener('click', function() {
			const pressed = favBtn.getAttribute('aria-pressed') === 'true';
			favBtn.setAttribute('aria-pressed', String(!pressed));
			favBtn.textContent = pressed ? '♡' : '♥';
			favBtn.classList.toggle('favorited', !pressed);
			if (!pressed) {
				favBtn.classList.remove('fav-pop-reset');
				void favBtn.offsetWidth; // força reflow para reiniciar animação
				favBtn.classList.add('fav-pop-reset');
			}
		});
		favBtn.addEventListener('animationend', function() {
			favBtn.classList.remove('fav-pop-reset');
		});
	}

	// --- Troca de imagem principal ao clicar nas miniaturas ---
	const thumbs = document.querySelectorAll('.thumb');
	const mainImage = document.getElementById('mainImage');
	if (thumbs.length && mainImage) {
		thumbs.forEach(thumb => {
			thumb.addEventListener('click', function() {
				thumbs.forEach(t => t.classList.remove('active'));
				thumb.classList.add('active');
				const src = thumb.getAttribute('data-src');
				if (src) {
					mainImage.src = src;
				}
			});
		});
	}

	// --- Abrir e fechar modal da tabela de tamanhos ---
	const sizeChartModal = document.getElementById('sizeChartModal');
	const openSizeChartBtn = document.getElementById('openSizeChart');
	const closeSizeChartBtn = document.getElementById('closeSizeChart');

	if (openSizeChartBtn && sizeChartModal) {
		openSizeChartBtn.addEventListener('click', function() {
			// Show the table relevant to the product category
			const cat = (sizeChartModal.dataset.category || '').toLowerCase();
			const shirt = document.getElementById('shirtSizeChart');
			const pants = document.getElementById('pantsSizeChart');
			if (shirt && pants) {
				shirt.style.display = 'none';
				pants.style.display = 'none';
				if (cat.includes('camis') || cat.includes('camisa')) {
					shirt.style.display = '';
				} else if (cat.includes('cal')) {
					pants.style.display = '';
				} else {
					// se categoria indefinida, mostra ambas
					shirt.style.display = '';
					pants.style.display = '';
				}
			}
			sizeChartModal.style.display = 'flex';
		});
	}

	if (closeSizeChartBtn && sizeChartModal) {
		closeSizeChartBtn.addEventListener('click', function() {
			// hide modal and its specific tables
			const shirt = document.getElementById('shirtSizeChart');
			const pants = document.getElementById('pantsSizeChart');
			if (shirt) shirt.style.display = 'none';
			if (pants) pants.style.display = 'none';
			sizeChartModal.style.display = 'none';
		});
	}

	// Fechar modal ao clicar fora do conteúdo
	window.addEventListener('click', function(event) {
		if (event.target === sizeChartModal) {
			const shirt = document.getElementById('shirtSizeChart');
			const pants = document.getElementById('pantsSizeChart');
			if (shirt) shirt.style.display = 'none';
			if (pants) pants.style.display = 'none';
			sizeChartModal.style.display = 'none';
		}
	});
});
</script>
</html>
</body>
</html>
