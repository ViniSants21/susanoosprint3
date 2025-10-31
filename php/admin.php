<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Susanoo</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/configuracoes-style.css"> <!-- Reutilizando CSS -->
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
                        <li><a href="admin.php" class="active"><i class="fas fa-chart-pie"></i> Overview</a></li>
                        <li><a href="admin_products.php"><i class="fas fa-box"></i> Produtos</a></li>
                        <li><a href="admin_users.php"><i class="fas fa-users"></i> Usuários</a></li>
                    </ul>
                </aside>
                
                <!-- Conteúdo Principal -->
                <div class="settings-content">
                    <section class="settings-panel active">
                        <h2>Overview</h2>
                        
                        <!-- Grid de Estatísticas -->
                        <div class="stats-grid" style="grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin-top: 20px;">
                            
                            <div class="stat-card" style="background-color: var(--dark-bg); padding: 20px; border-radius: 8px; border: 1px solid var(--border-color);">
                                <h3>Vendas Totais</h3>
                                <p class="stat-value" style="font-size: 2rem; font-weight: 700;">R$ 1.234,56</p>
                                <p class="stat-change" style="color: #10B981;">+2.6%</p>
                            </div>

                            <div class="stat-card" style="background-color: var(--dark-bg); padding: 20px; border-radius: 8px; border: 1px solid var(--border-color);">
                                <h3>Visitantes Online</h3>
                                <p class="stat-value" style="font-size: 2rem; font-weight: 700;">452</p>
                                <p class="stat-change" style="color: #EF4444;">-0.6%</p>
                            </div>

                            <div class="stat-card" style="background-color: var(--dark-bg); padding: 20px; border-radius: 8px; border: 1px solid var(--border-color);">
                                <h3>Novos Pedidos</h3>
                                <p class="stat-value" style="font-size: 2rem; font-weight: 700;">38</p>
                                <p class="stat-change" style="color: #10B981;">+5.1%</p>
                            </div>

                        </div>

                        <!-- Gráfico Placeholder -->
                        <div style="margin-top: 30px;">
                            <h3 style="font-family: 'Playfair Display', serif; font-size: 1.5rem; margin-bottom: 20px;">Vendas ao Longo do Tempo</h3>
                            <div class="chart-placeholder" style="background-color: var(--dark-bg); padding: 20px; border-radius: 8px; border: 1px solid var(--border-color); height: 250px; display: flex; align-items: flex-end;">
                                <svg width="100%" height="100%" viewBox="0 0 100 50">
                                    <polyline fill="none" stroke="#8B5CF6" stroke-width="0.5" points="0,40 10,35 20,45 30,20 40,28 50,22 60,32 70,28 80,35 90,30 100,25"/>
                                </svg>
                            </div>
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