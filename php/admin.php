<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Susanoo Admin</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        (function(){
            const theme = localStorage.getItem('theme');
            if(theme === 'light') {
                document.documentElement.classList.add('light-mode');
            }
        })();
    </script>
    <style>
        /* ===== ESTILOS DO PAINEL ADMIN ===== */
        .admin-dashboard {
            background-color: var(--bg-primary);
            min-height: 100vh;
            padding-top: 80px;
        }
        
        .admin-container {
            display: flex;
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 20px;
        }
        
        /* Sidebar */
        .admin-sidebar {
            width: 280px;
            background: var(--bg-card);
            border-radius: 20px;
            padding: 2rem 1.5rem;
            margin-right: 2rem;
            height: fit-content;
            position: sticky;
            top: 100px;
            box-shadow: var(--shadow-soft);
            border: 1px solid rgba(139, 92, 246, 0.1);
        }
        
        .admin-logo {
            text-align: center;
            margin-bottom: 2rem;
            padding-bottom: 1.5rem;
            border-bottom: 1px solid var(--border-color);
        }
        
        .admin-logo h2 {
            font-family: var(--font-display);
            color: var(--primary-purple);
            margin: 0;
            font-size: 1.8rem;
        }
        
        .admin-logo span {
            color: var(--text-secondary);
            font-size: 0.9rem;
        }
        
        .admin-nav {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        
        .admin-nav li {
            margin-bottom: 0.5rem;
        }
        
        .admin-nav a {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1rem 1.2rem;
            text-decoration: none;
            color: var(--text-secondary);
            border-radius: 12px;
            transition: all 0.3s ease;
            font-weight: 500;
        }
        
        .admin-nav a:hover,
        .admin-nav a.active {
            background: rgba(139, 92, 246, 0.1);
            color: var(--primary-purple);
            transform: translateX(5px);
        }
        
        .admin-nav a i {
            width: 20px;
            text-align: center;
            font-size: 1.1rem;
        }
        
        /* Conteúdo Principal */
        .admin-main {
            flex: 1;
            padding-bottom: 3rem;
        }
        
        .admin-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            padding-bottom: 1.5rem;
            border-bottom: 1px solid var(--border-color);
        }
        
        .admin-title {
            font-family: var(--font-display);
            font-size: 2.5rem;
            color: var(--text-primary);
            margin: 0;
        }
        
        .admin-actions {
            display: flex;
            gap: 1rem;
        }
        
        /* Cards de Estatísticas */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }
        
        .stat-card {
            background: var(--bg-card);
            border-radius: 15px;
            padding: 1.5rem;
            box-shadow: var(--shadow-soft);
            border: 1px solid rgba(139, 92, 246, 0.1);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-medium);
            border-color: var(--primary-purple);
        }
        
        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(90deg, var(--primary-purple), var(--secondary-purple));
        }
        
        .stat-icon {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1rem;
            font-size: 1.5rem;
        }
        
        .stat-icon.primary { background: rgba(139, 92, 246, 0.2); color: var(--primary-purple); }
        .stat-icon.success { background: rgba(16, 185, 129, 0.2); color: var(--success); }
        .stat-icon.warning { background: rgba(245, 158, 11, 0.2); color: var(--warning); }
        .stat-icon.info { background: rgba(59, 130, 246, 0.2); color: #3b82f6; }
        
        .stat-value {
            font-size: 2rem;
            font-weight: 700;
            margin: 0.5rem 0;
            color: var(--text-primary);
        }
        
        .stat-label {
            color: var(--text-secondary);
            font-size: 0.9rem;
            margin-bottom: 0.5rem;
        }
        
        .stat-change {
            display: flex;
            align-items: center;
            font-size: 0.85rem;
            font-weight: 600;
        }
        
        .stat-change.positive { color: var(--success); }
        .stat-change.negative { color: var(--error); }
        
        /* Grid de Gráficos */
        .charts-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 1.5rem;
            margin-bottom: 2rem;
        }
        
        .chart-container {
            background: var(--bg-card);
            border-radius: 15px;
            padding: 1.5rem;
            box-shadow: var(--shadow-soft);
            border: 1px solid rgba(139, 92, 246, 0.1);
        }
        
        .chart-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }
        
        .chart-title {
            font-size: 1.2rem;
            font-weight: 600;
            color: var(--text-primary);
            margin: 0;
        }
        
        .chart-actions {
            display: flex;
            gap: 0.5rem;
        }
        
        .chart-actions button {
            background: transparent;
            border: 1px solid var(--border-color);
            color: var(--text-secondary);
            padding: 0.4rem 0.8rem;
            border-radius: 6px;
            font-size: 0.8rem;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        
        .chart-actions button:hover,
        .chart-actions button.active {
            background: rgba(139, 92, 246, 0.1);
            color: var(--primary-purple);
            border-color: var(--primary-purple);
        }
        
        .chart-wrapper {
            height: 300px;
            position: relative;
        }
        
        /* Listas de Atividade */
        .activity-list, .product-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        
        .activity-item, .product-item {
            display: flex;
            align-items: center;
            padding: 1rem 0;
            border-bottom: 1px solid var(--border-color);
        }
        
        .activity-item:last-child, .product-item:last-child {
            border-bottom: none;
        }
        
        .activity-icon, .product-image {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 1rem;
            font-size: 1rem;
        }
        
        .activity-icon.order { background: rgba(16, 185, 129, 0.2); color: var(--success); }
        .activity-icon.user { background: rgba(59, 130, 246, 0.2); color: #3b82f6; }
        .activity-icon.product { background: rgba(139, 92, 246, 0.2); color: var(--primary-purple); }
        
        .activity-content, .product-info {
            flex: 1;
        }
        
        .activity-title, .product-name {
            font-weight: 600;
            color: var(--text-primary);
            margin: 0 0 0.2rem 0;
        }
        
        .activity-desc, .product-sales {
            color: var(--text-secondary);
            font-size: 0.85rem;
            margin: 0;
        }
        
        .activity-time {
            color: var(--text-muted);
            font-size: 0.8rem;
        }
        
        .product-image {
            border-radius: 8px;
            object-fit: cover;
        }
        
        .product-revenue {
            font-weight: 600;
            color: var(--primary-purple);
        }
        
        /* Cards de Acesso Rápido */
        .quick-access-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            margin-top: 2rem;
        }
        
        .quick-access-card {
            background: var(--bg-card);
            border-radius: 15px;
            padding: 1.5rem;
            text-align: center;
            text-decoration: none;
            color: var(--text-secondary);
            transition: all 0.3s ease;
            border: 1px solid rgba(139, 92, 246, 0.1);
        }
        
        .quick-access-card:hover {
            transform: translateY(-5px);
            border-color: var(--primary-purple);
            color: var(--primary-purple);
            box-shadow: var(--shadow-medium);
        }
        
        .quick-access-icon {
            width: 60px;
            height: 60px;
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            font-size: 1.5rem;
            background: rgba(139, 92, 246, 0.1);
            color: var(--primary-purple);
        }
        
        .quick-access-card h3 {
            margin: 0 0 0.5rem 0;
            font-size: 1.1rem;
        }
        
        .quick-access-card p {
            margin: 0;
            font-size: 0.9rem;
            opacity: 0.8;
        }
        
        /* Responsividade */
        @media (max-width: 1024px) {
            .admin-container {
                flex-direction: column;
            }
            
            .admin-sidebar {
                width: 100%;
                margin-right: 0;
                margin-bottom: 2rem;
                position: static;
            }
            
            .charts-grid {
                grid-template-columns: 1fr;
            }
        }
        
        @media (max-width: 768px) {
            .admin-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
            }
            
            .admin-actions {
                width: 100%;
                justify-content: space-between;
            }
            
            .stats-grid {
                grid-template-columns: 1fr;
            }
            
            .quick-access-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }
    </style>
</head>
<body class="admin-dashboard">

<!-- Navbar -->
<nav class="navbar scrolled" id="navbar">
    <div class="nav-container">
        <div class="nav-search">
            <input type="text" placeholder="Pesquisar...">
        </div>
        <div class="nav-logo">
            <img src="../assets/logo.png" alt="Susanoo">
        </div>
        <div class="nav-right-group">
            <ul class="nav-menu">
                <li><a href="../index.php" class="nav-link">Início</a></li>
                <li><a href="../produtos.php" class="nav-link">Produtos</a></li>
                <li><a href="../sobre.php" class="nav-link">Sobre</a></li>
                <li><a href="../contato.php" class="nav-link">Contato</a></li>
            </ul>
            <div class="nav-icons">
                <a href="#" class="nav-icon-link"><i class="fas fa-shopping-cart"></i></a>
                <a href="#" class="nav-icon-link"><i class="fas fa-user"></i></a>
            </div>
        </div>
    </div>
</nav>

<div class="admin-container">
    <!-- Sidebar -->
    <aside class="admin-sidebar">
        <div class="admin-logo">
            <h2>Susanoo Admin</h2>
            <span>Painel de Controle</span>
        </div>
        <ul class="admin-nav">
            <li><a href="admin.php" class="active"><i class="fas fa-chart-pie"></i> Dashboard</a></li>
            <li><a href="produtos_admin.php"><i class="fas fa-box"></i> Produtos</a></li>
            <li><a href="usuarios_admin.php"><i class="fas fa-users"></i> Usuários</a></li>
            <li><a href="pedidos_admin.php"><i class="fas fa-shopping-cart"></i> Pedidos</a></li>
            <li><a href="relatorios_admin.php"><i class="fas fa-chart-line"></i> Relatórios</a></li>
            <li><a href="configuracoes_admin.php"><i class="fas fa-cog"></i> Configurações</a></li>
            <li><a href="../index.php"><i class="fas fa-sign-out-alt"></i> Voltar ao Site</a></li>
        </ul>
    </aside>

    <!-- Conteúdo Principal -->
    <main class="admin-main">
        <div class="admin-header">
            <h1 class="admin-title">Dashboard</h1>
            <div class="admin-actions">
                <button class="btn btn-primary" id="refresh-data">
                    <i class="fas fa-sync-alt"></i> Atualizar Dados
                </button>
                <button class="btn btn-secondary" id="export-report">
                    <i class="fas fa-download"></i> Exportar Relatório
                </button>
            </div>
        </div>

        <!-- Grid de Estatísticas -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon primary">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <div class="stat-label">Vendas Totais</div>
                <div class="stat-value">R$ 12.847,90</div>
                <div class="stat-change positive">
                    <i class="fas fa-arrow-up"></i> 12.4% vs mês anterior
                </div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon success">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-label">Novos Clientes</div>
                <div class="stat-value">342</div>
                <div class="stat-change positive">
                    <i class="fas fa-arrow-up"></i> 5.2% vs mês anterior
                </div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon warning">
                    <i class="fas fa-box"></i>
                </div>
                <div class="stat-label">Pedidos Pendentes</div>
                <div class="stat-value">18</div>
                <div class="stat-change negative">
                    <i class="fas fa-arrow-down"></i> 2.1% vs mês anterior
                </div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon info">
                    <i class="fas fa-chart-line"></i>
                </div>
                <div class="stat-label">Taxa de Conversão</div>
                <div class="stat-value">3.8%</div>
                <div class="stat-change positive">
                    <i class="fas fa-arrow-up"></i> 0.7% vs mês anterior
                </div>
            </div>
        </div>
        
        <!-- Grid de Gráficos -->
        <div class="charts-grid">
            <div class="chart-container">
                <div class="chart-header">
                    <h3 class="chart-title">Vendas ao Longo do Tempo</h3>
                    <div class="chart-actions">
                        <button data-period="week">Semana</button>
                        <button data-period="month" class="active">Mês</button>
                        <button data-period="year">Ano</button>
                    </div>
                </div>
                <div class="chart-wrapper">
                    <canvas id="salesChart"></canvas>
                </div>
            </div>
            
            <div class="chart-container">
                <div class="chart-header">
                    <h3 class="chart-title">Categorias de Produtos</h3>
                    <div class="chart-actions">
                        <button><i class="fas fa-download"></i></button>
                    </div>
                </div>
                <div class="chart-wrapper">
                    <canvas id="categoriesChart"></canvas>
                </div>
            </div>
        </div>
        
        <!-- Grid Inferior -->
        <div class="charts-grid">
            <div class="chart-container">
                <div class="chart-header">
                    <h3 class="chart-title">Atividade Recente</h3>
                    <div class="chart-actions">
                        <button>Ver Tudo</button>
                    </div>
                </div>
                <ul class="activity-list">
                    <li class="activity-item">
                        <div class="activity-icon order">
                            <i class="fas fa-shopping-cart"></i>
                        </div>
                        <div class="activity-content">
                            <h4 class="activity-title">Novo Pedido Recebido</h4>
                            <p class="activity-desc">Pedido #4582 de João Silva</p>
                        </div>
                        <div class="activity-time">5 min atrás</div>
                    </li>
                    <li class="activity-item">
                        <div class="activity-icon user">
                            <i class="fas fa-user-plus"></i>
                        </div>
                        <div class="activity-content">
                            <h4 class="activity-title">Novo Cliente Registrado</h4>
                            <p class="activity-desc">Maria Oliveira se cadastrou</p>
                        </div>
                        <div class="activity-time">1 hora atrás</div>
                    </li>
                    <li class="activity-item">
                        <div class="activity-icon product">
                            <i class="fas fa-box"></i>
                        </div>
                        <div class="activity-content">
                            <h4 class="activity-title">Produto Esgotado</h4>
                            <p class="activity-desc">Camisa Brazil está sem estoque</p>
                        </div>
                        <div class="activity-time">2 horas atrás</div>
                    </li>
                </ul>
            </div>
            
            <div class="chart-container">
                <div class="chart-header">
                    <h3 class="chart-title">Produtos Mais Vendidos</h3>
                    <div class="chart-actions">
                        <button>Ver Tudo</button>
                    </div>
                </div>
                <ul class="product-list">
                    <li class="product-item">
                        <img src="../assets/img/IMG3.png" alt="Camisa Brazil" class="product-image">
                        <div class="product-info">
                            <h4 class="product-name">Camisa Brazil</h4>
                            <p class="product-sales">128 vendas</p>
                        </div>
                        <div class="product-revenue">R$ 12.672,00</div>
                    </li>
                    <li class="product-item">
                        <img src="../assets/img/Imagem2.png" alt="Moletom Sakura" class="product-image">
                        <div class="product-info">
                            <h4 class="product-name">Moletom Sakura</h4>
                            <p class="product-sales">94 vendas</p>
                        </div>
                        <div class="product-revenue">R$ 23.490,60</div>
                    </li>
                    <li class="product-item">
                        <img src="../assets/img/IMG5.png" alt="Boné AMATERASU" class="product-image">
                        <div class="product-info">
                            <h4 class="product-name">Boné AMATERASU</h4>
                            <p class="product-sales">76 vendas</p>
                        </div>
                        <div class="product-revenue">R$ 5.312,40</div>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Acesso Rápido -->
        <div class="chart-container">
            <div class="chart-header">
                <h3 class="chart-title">Acesso Rápido</h3>
            </div>
            <div class="quick-access-grid">
                <a href="produtos_admin.php" class="quick-access-card">
                    <div class="quick-access-icon">
                        <i class="fas fa-box"></i>
                    </div>
                    <h3>Gerenciar Produtos</h3>
                    <p>Adicionar, editar ou remover produtos</p>
                </a>
                
                <a href="usuarios_admin.php" class="quick-access-card">
                    <div class="quick-access-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <h3>Gerenciar Usuários</h3>
                    <p>Administrar contas de usuários</p>
                </a>
                
                <a href="pedidos_admin.php" class="quick-access-card">
                    <div class="quick-access-icon">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <h3>Ver Pedidos</h3>
                    <p>Visualizar e gerenciar pedidos</p>
                </a>
                
                <a href="relatorios_admin.php" class="quick-access-card">
                    <div class="quick-access-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <h3>Relatórios</h3>
                    <p>Relatórios detalhados de vendas</p>
                </a>
            </div>
        </div>
    </main>
</div>

<script src="../js/script.js"></script>
<script>
    // Dados simulados para os gráficos
    const salesData = {
        week: [1200, 1900, 1500, 2100, 1800, 2500, 2200],
        month: [8500, 9200, 9800, 10200, 11000, 12500, 11800, 13200, 12800, 12400, 13000, 12800],
        year: [45000, 52000, 58000, 62000, 68000, 75000, 82000, 90000, 95000, 102000, 110000, 128000]
    };
    
    const categoriesData = {
        labels: ['Camisetas', 'Moletons', 'Acessórios', 'Coleções', 'Outros'],
        datasets: [{
            data: [35, 25, 20, 15, 5],
            backgroundColor: [
                'rgba(139, 92, 246, 0.8)',
                'rgba(167, 139, 250, 0.8)',
                'rgba(196, 181, 253, 0.8)',
                'rgba(221, 214, 254, 0.8)',
                'rgba(243, 240, 255, 0.8)'
            ],
            borderColor: [
                'rgba(139, 92, 246, 1)',
                'rgba(167, 139, 250, 1)',
                'rgba(196, 181, 253, 1)',
                'rgba(221, 214, 254, 1)',
                'rgba(243, 240, 255, 1)'
            ],
            borderWidth: 1
        }]
    };
    
    // Inicializar gráficos
    let salesChart, categoriesChart;
    
    document.addEventListener('DOMContentLoaded', function() {
        // Gráfico de vendas
        const salesCtx = document.getElementById('salesChart').getContext('2d');
        salesChart = new Chart(salesCtx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
                datasets: [{
                    label: 'Vendas (R$)',
                    data: salesData.month,
                    borderColor: 'rgba(139, 92, 246, 1)',
                    backgroundColor: 'rgba(139, 92, 246, 0.1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: 'rgba(139, 92, 246, 1)',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        mode: 'index',
                        intersect: false,
                        callbacks: {
                            label: function(context) {
                                return `R$ ${context.raw.toLocaleString('pt-BR')}`;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(255, 255, 255, 0.1)'
                        },
                        ticks: {
                            color: 'rgba(255, 255, 255, 0.7)',
                            callback: function(value) {
                                return 'R$ ' + value.toLocaleString('pt-BR');
                            }
                        }
                    },
                    x: {
                        grid: {
                            color: 'rgba(255, 255, 255, 0.1)'
                        },
                        ticks: {
                            color: 'rgba(255, 255, 255, 0.7)'
                        }
                    }
                }
            }
        });
        
        // Gráfico de categorias
        const categoriesCtx = document.getElementById('categoriesChart').getContext('2d');
        categoriesChart = new Chart(categoriesCtx, {
            type: 'doughnut',
            data: categoriesData,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            color: 'rgba(255, 255, 255, 0.7)',
                            padding: 15,
                            usePointStyle: true,
                            pointStyle: 'circle'
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return `${context.label}: ${context.raw}%`;
                            }
                        }
                    }
                },
                cutout: '65%'
            }
        });
        
        // Interatividade para os botões de período
        document.querySelectorAll('.chart-actions button[data-period]').forEach(button => {
            button.addEventListener('click', function() {
                // Remover classe active de todos os botões
                document.querySelectorAll('.chart-actions button[data-period]').forEach(btn => {
                    btn.classList.remove('active');
                });
                
                // Adicionar classe active ao botão clicado
                this.classList.add('active');
                
                // Atualizar gráfico com dados do período selecionado
                const period = this.getAttribute('data-period');
                let labels, data;
                
                if (period === 'week') {
                    labels = ['Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb', 'Dom'];
                    data = salesData.week;
                } else if (period === 'month') {
                    labels = ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'];
                    data = salesData.month;
                } else {
                    labels = ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'];
                    data = salesData.year;
                }
                
                salesChart.data.labels = labels;
                salesChart.data.datasets[0].data = data;
                salesChart.update();
            });
        });
        
        // Botão de atualizar dados
        document.getElementById('refresh-data').addEventListener('click', function() {
            // Simular atualização de dados
            this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Atualizando...';
            this.disabled = true;
            
            setTimeout(() => {
                // Gerar dados aleatórios para simular atualização
                const randomData = salesData.month.map(value => 
                    Math.max(0, value + (Math.random() * 2000 - 1000))
                );
                
                salesChart.data.datasets[0].data = randomData;
                salesChart.update();
                
                // Atualizar estatísticas
                document.querySelectorAll('.stat-value').forEach((stat, index) => {
                    if (index === 0) {
                        const newValue = Math.floor(Math.random() * 5000) + 10000;
                        stat.textContent = `R$ ${newValue.toLocaleString('pt-BR')}`;
                    } else if (index === 1) {
                        const newValue = Math.floor(Math.random() * 100) + 300;
                        stat.textContent = newValue;
                    } else if (index === 2) {
                        const newValue = Math.floor(Math.random() * 10) + 10;
                        stat.textContent = newValue;
                    } else {
                        const newValue = (Math.random() * 2 + 3).toFixed(1);
                        stat.textContent = `${newValue}%`;
                    }
                });
                
                this.innerHTML = '<i class="fas fa-sync-alt"></i> Atualizar Dados';
                this.disabled = false;
                
                showNotification('Dados atualizados com sucesso!', 'success');
            }, 1500);
        });
        
        // Botão de exportar relatório
        document.getElementById('export-report').addEventListener('click', function() {
            // Simular exportação
            this.innerHTML = '<i class="fas fa-download"></i> Exportando...';
            this.disabled = true;
            
            setTimeout(() => {
                this.innerHTML = '<i class="fas fa-download"></i> Exportar Relatório';
                this.disabled = false;
                showNotification('Relatório exportado com sucesso!', 'success');
            }, 1000);
        });
    });

    // Função de notificação
    function showNotification(message, type) {
        const notification = document.createElement('div');
        notification.style.cssText = `
            position: fixed;
            top: 100px;
            right: 20px;
            background: ${type === 'success' ? 'var(--success)' : 'var(--error)'};
            color: white;
            padding: 1rem 1.5rem;
            border-radius: 10px;
            z-index: 10000;
            box-shadow: var(--shadow-medium);
            animation: slideIn 0.3s ease;
        `;
        notification.textContent = message;
        document.body.appendChild(notification);
        
        setTimeout(() => {
            notification.remove();
        }, 3000);
    }
</script>
</body>
</html>