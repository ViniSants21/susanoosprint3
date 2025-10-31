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

				<?php if (!empty($sizes)): ?>
					<div class="sizes" role="radiogroup" aria-label="Tamanhos">
						<?php foreach ($sizes as $i => $s): ?>
							<label class="size">
								<input type="radio" name="size" value="<?php echo $s; ?>" <?php echo count($sizes) === 1 || $i === 0 ? 'checked' : ''; ?>>
								<span><?php echo $s; ?></span>
							</label>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>

				<div class="actions">
					<button type="submit" class="btn-cta">Adicionar ao carrinho</button>
					<button type="button" id="favBtn" class="btn-fav" aria-pressed="false" title="Favoritar">♡</button>
				</div>

				<div class="note">Disponível no checkout com parcelamento</div>

				<section class="description">
					<h3>Descrição completa</h3>
					<p><?php echo nl2br($longdesc ?: $shortDesc); ?></p>
				</section>
			</form>
		</aside>
	</div>
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
			<p>&copy; <?php echo date('Y'); ?> Susanoo. Todos os direitos reservados.</p>
		</div>
	</div>
</footer>

<!-- JS -->
<script src="../js/cart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
	const thumbs = document.querySelectorAll('.thumb');
	const mainImage = document.getElementById('mainImage');
	if (mainImage && thumbs.length > 0) {
		thumbs.forEach(thumb => {
			thumb.addEventListener('click', function() {
				mainImage.src = this.dataset.src;
				thumbs.forEach(t => t.classList.remove('active'));
				this.classList.add('active');
			});
		});
	}
	document.getElementById('favBtn')?.addEventListener('click', function() {
		this.classList.toggle('active');
	});
	document.getElementById('addToCartForm')?.addEventListener('submit', function(e) {
		e.preventDefault();
		let selectedSize = 'Único';
		const radios = this.querySelectorAll('input[name="size"]');
		if (radios.length > 0) {
			const checkedRadio = Array.from(radios).find(r => r.checked);
			if (!checkedRadio) {
				alert('Por favor, selecione um tamanho.');
				return;
			}
			selectedSize = checkedRadio.value;
		}
		const productData = {
			id: (this.querySelector('input[name="product_name"]').value + '-' + selectedSize).replace(/\s+/g, '-').toLowerCase(),
			name: this.querySelector('input[name="product_name"]').value,
			price: parseFloat(this.querySelector('input[name="product_price"]').value.replace('R$', '').replace(',', '.')),
			image: mainImage.src,
			size: selectedSize,
			category: this.querySelector('input[name="product_category"]').value
		};
		if (typeof addToCart === 'function') {
			addToCart(productData);
			const button = this.querySelector('.btn-cta');
			const originalText = button.textContent;
			button.textContent = 'Adicionado!';
			button.style.background = '#10B981';
			setTimeout(() => {
				button.textContent = originalText;
				button.style.background = '';
			}, 2000);
		} else {
			console.error("A função addToCart não foi encontrada. Verifique se o script cart.js está sendo carregado corretamente.");
		}
	});
});
</script>
<script src="../js/theme.js"></script>
</body>
</html>
