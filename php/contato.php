<?php
// Inicia a sessão
if (!isset($_SESSION)) {
    session_start();
}

require_once 'conexao.php';

$feedback_msg = "";
$feedback_type = ""; // 'success' ou 'error'

// Processamento do Formulário
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($conn)) {
        $nome = $conn->real_escape_string(trim($_POST['name']));
        $email = $conn->real_escape_string(trim($_POST['email']));
        $assunto = $conn->real_escape_string(trim($_POST['subject']));
        $mensagem = $conn->real_escape_string(trim($_POST['message']));

        if (!empty($nome) && !empty($email) && !empty($assunto) && !empty($mensagem)) {
            $sql = "INSERT INTO mensagens_contato (nome, email, assunto, mensagem) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            
            if ($stmt) {
                $stmt->bind_param("ssss", $nome, $email, $assunto, $mensagem);
                if ($stmt->execute()) {
                    $feedback_type = "success";
                    $feedback_msg = "Mensagem enviada com sucesso! Em breve entraremos em contato.";
                    // Limpa os campos para não reenviar se der F5
                    $nome = $email = $assunto = $mensagem = ""; 
                } else {
                    $feedback_type = "error";
                    $feedback_msg = "Erro ao enviar: " . $stmt->error;
                }
                $stmt->close();
            } else {
                $feedback_type = "error";
                $feedback_msg = "Erro interno no banco de dados.";
            }
        } else {
            $feedback_type = "error";
            $feedback_msg = "Por favor, preencha todos os campos.";
        }
    } else {
        $feedback_type = "error";
        $feedback_msg = "Erro de conexão com o banco.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contato - Susanoo</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/contato.css">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@300;400;500;700&family=Playfair+Display:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script>(function(){const theme=localStorage.getItem('theme');if(theme==='light'){document.documentElement.classList.add('light-mode');}})();</script>
 
    <style>
        /* --- ESTILOS GERAIS --- */
        .nav-search{display:flex;align-items:center;gap:.5rem;}
        .nav-search input[type="text"]{padding:.45rem .75rem;border-radius:24px;border:1px solid rgba(0,0,0,.12);background:transparent;color:inherit;min-width:160px}
        .nav-search .nav-search-btn{border:none;background:transparent;padding:.35rem;border-radius:50%;cursor:pointer;color:inherit;display:inline-flex;align-items:center;justify-content:center}
        
        /* --- ESTILOS DE VALIDAÇÃO --- */
        .form-group {
            position: relative;
            margin-bottom: 1.5rem; /* Espaço extra para a mensagem de erro */
        }

        /* Classe de erro aplicada via JS */
        .form-group.error input,
        .form-group.error textarea {
            border-color: #ff4444 !important;
            animation: shake 0.3s ease-in-out;
        }

        .form-group.success input,
        .form-group.success textarea {
            border-color: #00C851 !important;
        }

        /* Mensagem de erro pequena abaixo do input */
        .form-group small {
            visibility: hidden;
            position: absolute;
            bottom: -20px;
            left: 0;
            font-size: 0.75rem;
            color: #ff4444;
            transition: 0.3s;
        }

        .form-group.error small {
            visibility: visible;
        }

        /* Animação de tremor para erro */
        @keyframes shake {
            0% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            50% { transform: translateX(5px); }
            75% { transform: translateX(-5px); }
            100% { transform: translateX(0); }
        }

        /* --- NOTIFICAÇÃO TOAST (Pop-up bonito) --- */
        .toast-container {
            position: fixed;
            top: 100px;
            right: 20px;
            z-index: 9999;
        }

        .toast {
            background: rgba(20, 20, 20, 0.95);
            backdrop-filter: blur(10px);
            color: #fff;
            padding: 1rem 1.5rem;
            border-radius: 8px;
            border-left: 5px solid #7c3aed; /* Cor roxa do tema */
            box-shadow: 0 5px 15px rgba(0,0,0,0.3);
            display: flex;
            align-items: center;
            gap: 1rem;
            transform: translateX(120%);
            transition: transform 0.5s ease-in-out;
            min-width: 300px;
        }

        .toast.show {
            transform: translateX(0);
        }

        .toast.success { border-left-color: #00C851; }
        .toast.error { border-left-color: #ff4444; }

        .toast i { font-size: 1.2rem; }
        .toast .toast-msg { font-size: 0.9rem; font-weight: 500; }

    </style>
</head>
 
<body>
    <!-- Container para Notificações -->
    <div class="toast-container">
        <div id="toast" class="toast">
            <i class="fas fa-info-circle" id="toast-icon"></i>
            <span class="toast-msg" id="toast-text">Mensagem aqui</span>
        </div>
    </div>

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
    <?php
// Certifique-se que o session_start() está no início do arquivo PHP
if (session_status() === PHP_SESSION_NONE) { session_start(); }

// Lógica active link
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
        <!-- PESQUISA FUNCIONAL (Aponta para o próprio diretório) -->
        <form action="produtos.php" method="GET" class="nav-search">
            <input type="text" name="busca" placeholder="Pesquisar..." aria-label="Pesquisar" 
                   value="<?php echo isset($_GET['busca']) ? htmlspecialchars($_GET['busca']) : ''; ?>">
            <button type="submit" class="nav-search-btn" aria-label="Pesquisar">
                <i class="fas fa-search"></i>
            </button>
        </form>

        <div class="nav-logo">
            <!-- Caminho volta uma pasta para pegar a logo -->
            <a href="../index.php"><img src="../assets/img/LOGOSUSANOO.png" alt="LOGOSUSANOO"></a>
        </div>

        <div class="nav-right-group">
            <ul class="nav-menu" id="nav-menu">
                <!-- Caminhos ajustados para sair da pasta php/ -->
                <li><a href="../index.php" class="nav-link <?php echo is_active('index.php', $current); ?>">Home</a></li>
                <li><a href="produtos.php" class="nav-link <?php echo is_active('produtos.php', $current); ?>">Produtos</a></li>
                <li><a href="colecoes.php" class="nav-link <?php echo is_active('colecoes.php', $current); ?>">Coleções</a></li>
                <li><a href="sobre.php" class="nav-link <?php echo is_active('sobre.php', $current); ?>">Sobre</a></li>
                <li><a href="contato.php" class="nav-link <?php echo is_active('contato.php', $current); ?>">Contato</a></li>
            </ul>

            <div class="nav-icons">
                <div class="profile-dropdown-wrapper">
                    <?php if (!isset($_SESSION['user_id'])): ?>
                        <!-- USUÁRIO DESLOGADO -->
                        <a href="login.php" class="nav-icon-link" aria-label="Login">
                            <i class="fas fa-user"></i>
                        </a>
                        <div class="profile-dropdown-menu">
                            <ul class="dropdown-links">
                                <li class="dropdown-link-item"><a href="registro.php"><i class="fas fa-user-plus"></i> Registrar</a></li>
                                <li class="dropdown-link-item"><a href="login.php"><i class="fas fa-sign-in-alt"></i> Login</a></li>
                            </ul>
                        </div>
                    <?php else: ?>
                        <!-- USUÁRIO LOGADO -->
                        <a href="#" class="nav-icon-link" aria-label="Perfil">
                            <!-- Aqui usamos $_SESSION['foto'] direto pois já deve conter ../ -->
                            <img src="<?php echo $_SESSION['foto']; ?>" class="dropdown-avatar" style="width:28px; height:28px; border-radius:50%; object-fit:cover;" onerror="this.src='../assets/img/placeholder-user.png'">
                        </a>
                        <div class="profile-dropdown-menu">
                            <div class="dropdown-header">
                                <img src="<?php echo $_SESSION['foto']; ?>" alt="Avatar" class="dropdown-avatar" onerror="this.src='../assets/img/placeholder-user.png'">
                                <div>
                                    <div class="dropdown-user-name"><?php echo $_SESSION['nome']; ?></div>
                                    <div class="dropdown-user-email"><?php echo $_SESSION['email']; ?></div>
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
                <a href="carrinho.php" class="nav-icon-link" aria-label="Carrinho"><i class="fas fa-shopping-bag"></i></a>
            </div>
        </div>
        <div class="hamburger" id="hamburger"><span></span><span></span><span></span></div>
    </div>
</nav>
   
    <main class="contact-page">
        <div class="background-gradient"></div>
 
            <div class="contact-container">
                <!-- Lado Esquerdo: Formulário -->
                <div class="contact-form-wrapper">
                    <div class="form-header">
                        <h1 class="form-title">Entre em Contato</h1>
                        <p class="form-subtitle">Sua jornada de autodescoberta começa com uma conversa.</p>
                    </div>
                    
                    <!-- Novidade: novalidate desativa a validação padrão feia do navegador -->
                    <form id="contactForm" method="POST" action="" novalidate>
                        
                        <div class="form-group">
                            <!-- Value recupera o valor se der erro -->
                            <input type="text" id="name" name="name" value="<?php echo isset($_POST['name']) && $feedback_type == 'error' ? htmlspecialchars($_POST['name']) : ''; ?>" required>
                            <label for="name">Nome Completo</label>
                            <small>Mensagem de erro aqui</small>
                        </div>

                        <div class="form-group">
                            <input type="email" id="email" name="email" value="<?php echo isset($_POST['email']) && $feedback_type == 'error' ? htmlspecialchars($_POST['email']) : ''; ?>" required>
                            <label for="email">Seu Melhor E-mail</label>
                            <small>E-mail inválido</small>
                        </div>

                        <div class="form-group">
                            <input type="text" id="subject" name="subject" value="<?php echo isset($_POST['subject']) && $feedback_type == 'error' ? htmlspecialchars($_POST['subject']) : ''; ?>" required>
                            <label for="subject">Assunto</label>
                            <small>Assunto é obrigatório</small>
                        </div>

                        <div class="form-group">
                            <textarea id="message" name="message" rows="5" required><?php echo isset($_POST['message']) && $feedback_type == 'error' ? htmlspecialchars($_POST['message']) : ''; ?></textarea>
                            <label for="message">Sua Mensagem</label>
                            <small>A mensagem não pode ficar vazia</small>
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
                        <li><a href="index.php">Home</a></li>
                        <li><a href="php/produtos.php">Produtos</a></li>
                        <li><a href="php/colecoes.php">Coleções</a></li>
                        <li><a href="php/sobre.php">Sobre Nós</a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h4>Atendimento</h4>
                    <ul>
                        <li><a href="php/contato.php">Contato</a></li>
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
                <p>&copy; <?php echo date('Y'); ?> Susanoo. Todos os direitos reservados por Davi de Assis, Kauã souza, Lucas Limas e Vinicius Queiroz.</p>
            </div>
        </div>
    </footer>

    <script src="../js/theme.js"></script>
    <script src="../js/cart.js"></script>
    <script src="../js/script.js"></script>
 
    <script>
    // --- LÓGICA DE VALIDAÇÃO VISUAL ---

    // Função para mostrar notificação (Toast)
    function showToast(message, type = 'success') {
        const toast = document.getElementById('toast');
        const toastText = document.getElementById('toast-text');
        const toastIcon = document.getElementById('toast-icon');

        toast.className = `toast ${type}`; // Adiciona classe success ou error
        toastText.innerText = message;

        // Ícone baseado no tipo
        if(type === 'success') toastIcon.className = 'fas fa-check-circle';
        else toastIcon.className = 'fas fa-exclamation-circle';

        // Mostrar
        toast.classList.add('show');

        // Esconder depois de 4 segundos
        setTimeout(() => {
            toast.classList.remove('show');
        }, 4000);
    }

    // Se o PHP definiu uma mensagem, mostrar ao carregar a página
    <?php if(!empty($feedback_msg)): ?>
        showToast("<?php echo $feedback_msg; ?>", "<?php echo $feedback_type; ?>");
    <?php endif; ?>

    const form = document.getElementById('contactForm');
    const inputs = form.querySelectorAll('input, textarea');

    // Validação de um campo individual
    function validateField(input) {
        const formGroup = input.parentElement;
        const small = formGroup.querySelector('small');
        let isValid = true;
        let message = '';

        // Validação de Campo Vazio
        if(input.value.trim() === '') {
            isValid = false;
            message = 'Este campo é obrigatório';
        } 
        // Validação Específica de Email
        else if (input.type === 'email') {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if(!emailRegex.test(input.value.trim())) {
                isValid = false;
                message = 'Por favor, insira um e-mail válido';
            }
        }

        // Aplica estilos visuais
        if(isValid) {
            formGroup.classList.remove('error');
            formGroup.classList.add('success');
        } else {
            formGroup.classList.remove('success');
            formGroup.classList.add('error');
            small.innerText = message;
        }

        return isValid;
    }

    // Adiciona evento "blur" (quando sai do campo) para validar instantaneamente
    inputs.forEach(input => {
        input.addEventListener('blur', () => {
            validateField(input);
        });
        // Remove erro enquanto digita
        input.addEventListener('input', () => {
            input.parentElement.classList.remove('error');
        });
    });

    // Validação no envio (Submit)
    form.addEventListener('submit', function(event) {
        let isFormValid = true;

        inputs.forEach(input => {
            if(!validateField(input)) {
                isFormValid = false;
            }
        });

        if (!isFormValid) {
            event.preventDefault(); // Impede envio se houver erro
            showToast('Por favor, corrija os erros destacadados.', 'error');
        }
        // Se isFormValid for true, deixa o PHP processar
    });
    </script>
</body>
</html>