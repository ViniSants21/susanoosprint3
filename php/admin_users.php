<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Usuários - Susanoo</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/configuracoes-style.css"> <!-- Reutilizando o CSS de configurações -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script>(function(){const theme=localStorage.getItem('theme');if(theme==='light'){document.documentElement.classList.add('light-mode');}})();</script>
</head>
<body class="settings-page-body">

<?php
$current = basename($_SERVER['PHP_SELF']);
if (!function_exists('is_active')) {
    function is_active($href, $current) {
        $base = basename(parse_url($href, PHP_URL_PATH));
        return $base === $current ? 'active' : '';
    }
}
?>

<!-- Navbar Padrão (igual às outras páginas internas) -->
<nav class="navbar scrolled" id="navbar">
    <!-- Cole aqui o código completo da sua navbar de páginas internas -->
</nav>

    <main class="settings-main-content">
        <div class="container">
            <div class="settings-header"><h1>Painel de Administração</h1></div>
            <div class="settings-layout">
                <!-- Menu Lateral de Administração -->
                <aside class="settings-nav">
                    <ul>
                        <li><a href="admin.php"><i class="fas fa-chart-pie"></i> Overview</a></li>
                        <li><a href="admin_products.php"><i class="fas fa-box"></i> Produtos</a></li>
                        <li><a href="admin_users.php" class="active"><i class="fas fa-users"></i> Usuários</a></li>
                    </ul>
                </aside>
                
                <!-- Conteúdo Principal -->
                <div class="settings-content">
                    <section class="settings-panel active">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
                            <h2 style="margin: 0;">Gerenciar Usuários</h2>
                            <a href="#" class="btn btn-primary" style="font-size: 0.9rem; padding: 10px 15px;">Adicionar Usuário</a>
                        </div>
                        
                        <!-- Tabela de Usuários (Estilizada para o tema do site) -->
                        <div class="data-table-wrapper" style="background-color: var(--dark-bg); border-radius: 8px;">
                            <table class="data-table" style="width: 100%; border-collapse: collapse;">
                                <thead>
                                    <tr style="border-bottom: 1px solid var(--border-color);">
                                        <th style="padding: 15px; text-align: left;">Usuário</th>
                                        <th style="padding: 15px; text-align: left;">Email</th>
                                        <th style="padding: 15px; text-align: left;">Tipo</th>
                                        <th style="padding: 15px; text-align: left;">Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr style="border-bottom: 1px solid var(--border-color);">
                                        <td style="padding: 15px;">Admin Susanoo</td>
                                        <td style="padding: 15px;">admin@susanoo.com</td>
                                        <td style="padding: 15px;">Admin</td>
                                        <td class="action-buttons" style="padding: 15px;">
                                            <button title="Editar" style="background:none; border:none; color: var(--text-muted); font-size: 1.1rem; cursor: pointer;"><i class="fas fa-pen"></i></button>
                                            <button title="Deletar" style="background:none; border:none; color: var(--text-muted); font-size: 1.1rem; cursor: not-allowed; opacity: 0.5;" disabled><i class="fas fa-trash"></i></button>
                                        </td>
                                    </tr>
                                    <tr style="border-bottom: 1px solid var(--border-color);">
                                        <td style="padding: 15px;">Cliente Exemplo 1</td>
                                        <td style="padding: 15px;">cliente1@email.com</td>
                                        <td style="padding: 15px;">Cliente</td>
                                        <td class="action-buttons" style="padding: 15px;">
                                            <button title="Editar" style="background:none; border:none; color: var(--text-muted); font-size: 1.1rem; cursor: pointer;"><i class="fas fa-pen"></i></button>
                                            <button title="Deletar" style="background:none; border:none; color: var(--text-muted); font-size: 1.1rem; cursor: pointer;"><i class="fas fa-trash"></i></button>
                                        </td>
                                    </tr>
                                     <tr>
                                        <td style="padding: 15px;">Cliente Exemplo 2</td>
                                        <td style="padding: 15px;">cliente2@email.com</td>
                                        <td style="padding: 15px;">Cliente</td>
                                        <td class="action-buttons" style="padding: 15px;">
                                            <button title="Editar" style="background:none; border:none; color: var(--text-muted); font-size: 1.1rem; cursor: pointer;"><i class="fas fa-pen"></i></button>
                                            <button title="Deletar" style="background:none; border:none; color: var(--text-muted); font-size: 1.1rem; cursor: pointer;"><i class="fas fa-trash"></i></button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </main>

    <footer class="footer">
        <!-- Cole aqui o código completo do seu footer -->
    </footer>

    <script src="../js/cart.js"></script>
    <script src="../js/script.js"></script>
    <script src="../js/theme.js"></script>
</body>
</html>