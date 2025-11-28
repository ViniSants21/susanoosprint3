<?php
session_start();
require 'conexao.php'; // Certifique-se de que o caminho está correto

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Captura os dados com base nos 'name' corrigidos no formulário abaixo
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);

    // Upload da imagem
    // Nota: Certifique-se que a pasta 'uploads' existe no diretório correto
    $fotoNome = time() . "_" . basename($_FILES['foto']['name']);
    
    // Caminho relativo para salvar no banco (ex: uploads/foto.jpg)
    $fotoCaminho = "uploads/" . $fotoNome; 
    
    // Caminho físico para mover o arquivo. 
    // O "../" indica que volta uma pasta (sai de 'php') e entra em 'uploads' na raiz ou na mesma pasta pai.
    // Ajuste conforme sua estrutura de pastas real.
    if(move_uploaded_file($_FILES['foto']['tmp_name'], "../" . $fotoCaminho)) {
        // Se o upload der certo, salva no banco
        $stmt = $conn->prepare("INSERT INTO users(nome,email,senha,foto) VALUES(?,?,?,?)");
        // Ajuste o caminho da foto se necessário para salvar o caminho completo relativo à raiz do site
        $caminhoBanco = "../" . $fotoCaminho; 
        $stmt->bind_param("ssss", $nome, $email, $senha, $caminhoBanco);
        
        if($stmt->execute()){
            header("Location: login.php");
            exit;
        } else {
            $erro = "Erro ao inserir no banco.";
        }
    } else {
        // Fallback se não tiver foto ou der erro no upload (opcional)
        $erro = "Erro ao fazer upload da imagem.";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Conta - Susanoo</title>

    <!-- CSS (Voltando um diretório com ../) -->
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/login-style.css">
    
    <!-- Ícones e Fontes -->
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
// Bloco PHP para a lógica da navbar
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

            <!-- Lado Esquerdo: Formulário de Registro -->
            <div class="card-left">
                <div class="avatar-wrap">
                    <img id="avatarPreview" src="../assets/img/avatar.png" alt="Avatar" class="avatar-default">
                </div>
                
                <?php if(isset($erro)): ?>
                    <p style="color:red; text-align:center"><?php echo $erro; ?></p>
                <?php endif; ?>

                <form method="post" action="registro.php" enctype="multipart/form-data" novalidate>
                    <label class="field">
                        <span class="label-title">Nome Completo</span>
                        <div class="input-wrap">
                            <!-- Corrigido name="name" para name="nome" -->
                            <input type="text" name="nome" required placeholder="Seu nome completo">
                            <i class="fas fa-user icon"></i>
                        </div>
                    </label>
                    <label class="field">
                        <span class="label-title">Email</span>
                        <div class="input-wrap">
                            <input type="email" name="email" required placeholder="seu@email.com">
                            <i class="fas fa-envelope icon"></i>
                        </div>
                    </label>
                    <label class="field">
                        <span class="label-title">Crie uma Senha</span>
                        <div class="input-wrap">
                            <!-- Corrigido name="password" para name="senha" -->
                            <input type="password" name="senha" required placeholder="Senha segura">
                            <i class="fas fa-lock icon"></i>
                        </div>
                    </label>
                    <!-- Campo de confirmação de senha é visual no HTML, mas seu PHP atual não verifica ele. 
                         Idealmente você adicionaria essa verificação no PHP. -->
                    <label class="field">
                        <span class="label-title">Confirme a Senha</span>
                        <div class="input-wrap">
                            <input type="password" name="senha_confirma" placeholder="Repita a senha">
                            <i class="fas fa-check-double icon"></i>
                        </div>
                    </label>
                    <label class="field file-field">
                        <span class="label-title">Subir foto de perfil (opcional)</span>
                        <!-- Corrigido name="avatar" para name="foto" -->
                        <input id="avatarInput" type="file" name="foto" accept="image/*">
                    </label>
                    <button type="submit" class="btn-login">Criar Conta</button>
                    <div class="form-footer">
                        <a class="link" href="login.php">Já tem uma conta? Entrar</a>
                    </div>
                </form>
            </div>

            <!-- Lado Direito: Imagem -->
            <div class="card-right">
                <img class="card-right-bg-image" src="../assets/img/vermelhoroupa.png" alt="Modelo Susanoo">
                <div class="card-right-content">
                    <h2>Crie sua Conta na Susanoo</h2>
                    <p>Salve seus pedidos, crie listas de desejos e finalize suas compras mais rápido.</p>
                </div>
            </div>

        </section>
    </main>

    <!-- Footer Padrão do Site -->
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

<!-- SCRIPTS CORRIGIDOS -->
<script src="../js/cart.js"></script>
<script src="../js/script.js"></script>
<script src="../js/theme.js"></script> 

<script>
document.addEventListener('DOMContentLoaded', function() {
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
});
</script>

</body>
</html>