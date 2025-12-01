<?php
session_start();
require 'conexao.php';

// ==========================================
// LÓGICA DE EXIBIÇÃO DA FOTO NA NAV (ADAPTADO)
// ==========================================
$foto_perfil = '../assets/img/placeholder-user.png'; // Foto padrão com caminho relativo

if (isset($_SESSION['foto']) && !empty($_SESSION['foto'])) {
    $temp_foto = $_SESSION['foto'];
    
    // Se a foto salva na sessão NÃO tiver "../" no começo, adicionamos
    // porque estamos dentro da pasta php/ e precisamos subir um nível
    if (substr($temp_foto, 0, 3) != '../') {
        $foto_perfil = '../' . $temp_foto;
    } else {
        $foto_perfil = $temp_foto;
    }
}

// ==========================================
// LÓGICA DE REGISTRO (SEU CÓDIGO ORIGINAL)
// ==========================================
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 1. Pegando os nomes corretos do HTML
    $nome = $_POST['name']; 
    $email = $_POST['email'];
    $senha = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // 2. Definindo foto padrão (caso não envie imagem)
    $fotoCaminho = "../assets/img/placeholder-user.png"; 

    // 3. Processando o Upload (Se houver)
    if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === 0) {
        $extensao = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);
        $novoNome = "user_" . time() . "." . $extensao;
        
        // Caminho físico para salvar o arquivo
        $diretorioFisico = "../assets/uploads/";
        
        // Cria a pasta se não existir
        if (!is_dir($diretorioFisico)) {
            mkdir($diretorioFisico, 0777, true);
        }

        if (move_uploaded_file($_FILES['avatar']['tmp_name'], $diretorioFisico . $novoNome)) {
            // Caminho para salvar no Banco
            $fotoCaminho = "../assets/uploads/" . $novoNome;
        }
    }

    // 4. Inserção no banco
    $stmt = $conn->prepare("INSERT INTO users (nome, email, senha, foto) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $nome, $email, $senha, $fotoCaminho);
    
    if ($stmt->execute()) {
        header("Location: login.php?msg=criada");
        exit;
    } else {
        echo "Erro ao registrar: " . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Conta - Susanoo</title>
    
    <!-- CSS -->
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/login-style.css">
    
    <!-- Fontes e Ícones -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@300;400;500;700&display=swap" rel="stylesheet">

    <script>(function(){const theme=localStorage.getItem('theme');if(theme==='light'){document.documentElement.classList.add('light-mode');}})();</script>

    <!-- ESTILO ESPECÍFICO PARA A NAVBAR (Copiado da Index) -->
    <style>
        .nav-search { display:flex; align-items:center; gap:.5rem; }
        .nav-search input[type="text"] { padding:.45rem .75rem; border-radius:24px; border:1px solid rgba(0,0,0,.08); background:transparent; color:inherit; min-width:160px; }
        .nav-search .nav-search-btn { border:none; background:transparent; padding:.35rem; border-radius:50%; cursor:pointer; color:inherit; display:inline-flex; align-items:center; justify-content:center; }
        .nav-search .nav-search-btn .fa-search { font-size:0.95rem; }
        
        /* Ajuste para garantir que o dropdown apareça corretamente sobre o fundo do login */
        .profile-dropdown-menu { z-index: 1000; }
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

<!-- NAVBAR ATUALIZADA -->
<nav class="navbar scrolled" id="navbar">
    <div class="nav-container">
        <!-- Form de Busca -->
        <form action="produtos.php" method="GET" class="nav-search">
            <input type="text" name="busca" placeholder="Pesquisar..." aria-label="Pesquisar">
            <button type="submit" class="nav-search-btn" aria-label="Pesquisar">
                <i class="fas fa-search"></i>
            </button>
        </form>

        <!-- Logo (Caminho ajustado para ../) -->
        <div class="nav-logo">
            <a href="../index.php"><img src="../assets/img/LOGOSUSANOO.png" alt="LOGOSUSANOO"></a>
        </div>

        <div class="nav-right-group">
            <ul class="nav-menu" id="nav-menu">
                <li><a href="../index.php" class="nav-link <?php echo is_active('index.php', $current); ?>">Home</a></li>
                <li><a href="produtos.php" class="nav-link <?php echo is_active('produtos.php', $current); ?>">Produtos</a></li>
                <li><a href="colecoes.php" class="nav-link <?php echo is_active('colecoes.php', $current); ?>">Coleções</a></li>
                <li><a href="sobre.php" class="nav-link <?php echo is_active('sobre.php', $current); ?>">Sobre</a></li>
                <li><a href="contato.php" class="nav-link <?php echo is_active('contato.php', $current); ?>">Contato</a></li>
            </ul>

            <div class="nav-icons">
                <!-- Wrapper do Dropdown de Perfil -->
                <div class="profile-dropdown-wrapper">
                    
                    <?php if (!isset($_SESSION['user_id'])): ?>
                        <!-- USUÁRIO DESLOGADO -->
                        <a href="login.php" class="nav-icon-link" aria-label="Login">
                            <i class="fas fa-user"></i>
                        </a>

                        <div class="profile-dropdown-menu">
                            <ul class="dropdown-links">
                                <li class="dropdown-link-item">
                                    <a href="registro.php"><i class="fas fa-user-plus"></i> Registrar</a>
                                </li>
                                <li class="dropdown-link-item">
                                    <a href="login.php"><i class="fas fa-sign-in-alt"></i> Login</a>
                                </li>
                            </ul>
                        </div>

                    <?php else: ?>
                        <!-- USUÁRIO LOGADO -->
                        <a href="#" class="nav-icon-link" aria-label="Perfil">
                            <img src="<?php echo $foto_perfil; ?>" class="dropdown-avatar" style="width:28px; height:28px; border-radius:50%; object-fit:cover;">
                        </a>

                        <div class="profile-dropdown-menu">
                            <div class="dropdown-header">
                                <img src="<?php echo $foto_perfil; ?>" alt="Avatar" class="dropdown-avatar">
                                <div>
                                    <div class="dropdown-user-name"><?php echo htmlspecialchars($_SESSION['nome']); ?></div>
                                    <div class="dropdown-user-email"><?php echo htmlspecialchars($_SESSION['email']); ?></div>
                                </div>
                            </div>

                            <ul class="dropdown-links">
                                <li class="dropdown-link-item"><a href="perfil.php"><i class="fas fa-id-card"></i> Visualizar Perfil</a></li>
                                <li class="dropdown-link-item"><a href="configuracoes.php"><i class="fas fa-cog"></i> Configurações</a></li>
                                <li class="dropdown-link-item"><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Sair</a></li>
                            </ul>
                        </div>
                    <?php endif; ?>
                </div>
                
                <!-- Ícone do Carrinho -->
                <a href="carrinho.php" class="nav-icon-link" aria-label="Carrinho"><i class="fas fa-shopping-bag"></i></a>
            </div>
        </div>
        <div class="hamburger" id="hamburger"><span></span><span></span><span></span></div>
    </div>
</nav>

    <main class="login-wrap">
        <section class="login-card">
            <div class="card-left">
                <div class="avatar-wrap">
                    <!-- Preview da imagem -->
                    <img id="avatarPreview" src="../assets/img/avatar.png" alt="Avatar" class="avatar-default" style="object-fit: cover;">
                </div>

                <form method="post" action="" enctype="multipart/form-data">
                    <label class="field">
                        <span class="label-title">Nome Completo</span>
                        <div class="input-wrap">
                            <input type="text" name="name" required>
                            <i class="fas fa-user icon"></i>
                        </div>
                    </label>
                    <label class="field">
                        <span class="label-title">Email</span>
                        <div class="input-wrap">
                            <input type="email" name="email" required>
                            <i class="fas fa-envelope icon"></i>
                        </div>
                    </label>
                    <label class="field">
                        <span class="label-title">Crie uma Senha</span>
                        <div class="input-wrap">
                            <input type="password" name="password" required>
                            <i class="fas fa-lock icon"></i>
                        </div>
                    </label>
                    <!-- Campo de Foto -->
                    <label class="field file-field">
                        <span class="label-title">Subir foto de perfil (opcional)</span>
                        <input id="avatarInput" type="file" name="avatar" accept="image/*">
                    </label>
                    
                    <button type="submit" class="btn-login">Criar Conta</button>
                    <div class="form-footer">
                        <a class="link" href="login.php">Já tem uma conta? Entrar</a>
                    </div>
                </form>
            </div>

            <div class="card-right">
                <img class="card-right-bg-image" src="../assets/img/vermelhoroupa.png" alt="Modelo Susanoo">
                <div class="card-right-content">
                    <h2>Crie sua Conta na Susanoo</h2>
                    <p>Salve seus pedidos, crie listas de desejos e finalize suas compras mais rápido.</p>
                </div>
            </div>
        </section>
    </main>

    <footer class="footer">
       <!-- Footer Conteudo -->
    </footer>

<script src="../js/script.js"></script>
<script>
// Script para mostrar o preview da imagem selecionada
const avatarInput = document.getElementById('avatarInput');
const avatarPreview = document.getElementById('avatarPreview');
if (avatarInput) {
    avatarInput.addEventListener('change', (e) => {
        const f = e.target.files[0];
        if (!f) return;
        const reader = new FileReader();
        reader.onload = function(ev) { avatarPreview.src = ev.target.result; };
        reader.readAsDataURL(f);
    });
}
</script>
</body>
</html>