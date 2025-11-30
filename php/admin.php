<?php
// ==========================================================
// 1. CONEXÃO E LÓGICA DE DADOS (PHP NO TOPO)
// ==========================================================
require_once 'conexao.php'; // Certifique-se de que este arquivo existe e conecta ao BD

// --- A. Estatísticas Gerais (Cards) ---

// 1. Vendas Totais
$sql_total = "SELECT SUM(total) as total_vendas FROM pedidos";
$res_total = $conn->query($sql_total);
$total_vendas = 0;
if($res_total) {
    $row = $res_total->fetch_assoc();
    $total_vendas = $row['total_vendas'] ?? 0;
}

// 2. Pedidos Pendentes
$sql_pendentes = "SELECT COUNT(*) as total FROM pedidos WHERE status = 'Pendente'";
$res_pendentes = $conn->query($sql_pendentes);
$pedidos_pendentes = ($res_pendentes) ? $res_pendentes->fetch_assoc()['total'] : 0;

// 3. Contagem de Usuários
$sql_users = "SELECT COUNT(*) AS total FROM users";
$res_users = $conn->query($sql_users);
$users_count = ($res_users) ? $res_users->fetch_assoc()['total'] : 0;

// --- B. Dados para Gráficos ---

// 1. Categorias (Rosca)
$sql_cat = "SELECT categoria, COUNT(*) as qtd FROM itens_pedido GROUP BY categoria";
$res_cat = $conn->query($sql_cat);

$cat_labels = [];
$cat_data = [];
if($res_cat) {
    while($row = $res_cat->fetch_assoc()) {
        $cat_labels[] = $row['categoria'];
        $cat_data[] = $row['qtd'];
    }
}

// 2. Vendas por Mês (Linha) - Ano Atual
$sql_chart = "SELECT MONTH(data_pedido) as mes, SUM(total) as total 
              FROM pedidos 
              WHERE YEAR(data_pedido) = YEAR(CURRENT_DATE()) 
              GROUP BY MONTH(data_pedido) 
              ORDER BY mes";
$res_chart = $conn->query($sql_chart);

// Inicializa array com 0 para os 12 meses
$sales_month_data = array_fill(0, 12, 0); 
if($res_chart) {
    while($row = $res_chart->fetch_assoc()) {
        // Mês 1 (Jan) vira índice 0 no array JS
        $sales_month_data[intval($row['mes']) - 1] = floatval($row['total']); 
    }
}

// --- C. Listas Dinâmicas ---

// 1. Atividade Recente (Últimos 5 pedidos)
$sql_recent = "SELECT * FROM pedidos ORDER BY data_pedido DESC LIMIT 5";
$res_recent = $conn->query($sql_recent);

// 2. Produtos Mais Vendidos (Top 3)
// Agrupa itens pelo nome e soma a quantidade e receita
$sql_top = "SELECT produto_nome, SUM(quantidade) as qtd_total, SUM(quantidade * preco_unitario) as receita_total 
            FROM itens_pedido 
            GROUP BY produto_nome 
            ORDER BY qtd_total DESC 
            LIMIT 3";
$res_top = $conn->query($sql_top);
?>

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
        .admin-dashboard { background-color: var(--bg-primary); min-height: 100vh; padding-top: 80px; }
        .admin-container { display: flex; max-width: 1400px; margin: 0 auto; padding: 0 20px; }
        
        /* Sidebar */
        .admin-sidebar { width: 280px; background: var(--bg-card); border-radius: 20px; padding: 2rem 1.5rem; margin-right: 2rem; height: fit-content; position: sticky; top: 100px; box-shadow: var(--shadow-soft); border: 1px solid rgba(139, 92, 246, 0.1); }
        .admin-logo { text-align: center; margin-bottom: 2rem; padding-bottom: 1.5rem; border-bottom: 1px solid var(--border-color); }
        .admin-logo h2 { font-family: var(--font-display); color: var(--primary-purple); margin: 0; font-size: 1.8rem; }
        .admin-logo span { color: var(--text-secondary); font-size: 0.9rem; }
        .admin-nav { list-style: none; padding: 0; margin: 0; }
        .admin-nav li { margin-bottom: 0.5rem; }
        .admin-nav a { display: flex; align-items: center; gap: 1rem; padding: 1rem 1.2rem; text-decoration: none; color: var(--text-secondary); border-radius: 12px; transition: all 0.3s ease; font-weight: 500; }
        .admin-nav a:hover, .admin-nav a.active { background: rgba(139, 92, 246, 0.1); color: var(--primary-purple); transform: translateX(5px); }
        .admin-nav a i { width: 20px; text-align: center; font-size: 1.1rem; }
        
        /* Conteúdo Principal */
        .admin-main { flex: 1; padding-bottom: 3rem; }
        .admin-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; padding-bottom: 1.5rem; border-bottom: 1px solid var(--border-color); }
        .admin-title { font-family: var(--font-display); font-size: 2.5rem; color: var(--text-primary); margin: 0; }
        .admin-actions { display: flex; gap: 1rem; }
        
        /* Cards de Estatísticas */
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.5rem; margin-bottom: 2rem; }
        .stat-card { background: var(--bg-card); border-radius: 15px; padding: 1.5rem; box-shadow: var(--shadow-soft); border: 1px solid rgba(139, 92, 246, 0.1); transition: all 0.3s ease; position: relative; overflow: hidden; }
        .stat-card:hover { transform: translateY(-5px); box-shadow: var(--shadow-medium); border-color: var(--primary-purple); }
        .stat-card::before { content: ''; position: absolute; top: 0; left: 0; width: 100%; height: 4px; background: linear-gradient(90deg, var(--primary-purple), var(--secondary-purple)); }
        .stat-icon { width: 50px; height: 50px; border-radius: 12px; display: flex; align-items: center; justify-content: center; margin-bottom: 1rem; font-size: 1.5rem; }
        .stat-icon.primary { background: rgba(139, 92, 246, 0.2); color: var(--primary-purple); }
        .stat-icon.success { background: rgba(16, 185, 129, 0.2); color: var(--success); }
        .stat-icon.warning { background: rgba(245, 158, 11, 0.2); color: var(--warning); }
        .stat-icon.info { background: rgba(59, 130, 246, 0.2); color: #3b82f6; }
        .stat-value { font-size: 2rem; font-weight: 700; margin: 0.5rem 0; color: var(--text-primary); }
        .stat-label { color: var(--text-secondary); font-size: 0.9rem; margin-bottom: 0.5rem; }
        .stat-change { display: flex; align-items: center; font-size: 0.85rem; font-weight: 600; }
        .stat-change.positive { color: var(--success); }
        .stat-change.negative { color: var(--error); }
        
        /* Grid de Gráficos */
        .charts-grid { display: grid; grid-template-columns: 2fr 1fr; gap: 1.5rem; margin-bottom: 2rem; }
        .chart-container { background: var(--bg-card); border-radius: 15px; padding: 1.5rem; box-shadow: var(--shadow-soft); border: 1px solid rgba(139, 92, 246, 0.1); }
        .chart-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; }
        .chart-title { font-size: 1.2rem; font-weight: 600; color: var(--text-primary); margin: 0; }
        .chart-actions { display: flex; gap: 0.5rem; }
        .chart-actions button { background: transparent; border: 1px solid var(--border-color); color: var(--text-secondary); padding: 0.4rem 0.8rem; border-radius: 6px; font-size: 0.8rem; cursor: pointer; transition: all 0.2s ease; }
        .chart-actions button:hover, .chart-actions button.active { background: rgba(139, 92, 246, 0.1); color: var(--primary-purple); border-color: var(--primary-purple); }
        .chart-wrapper { height: 300px; position: relative; }
        
        /* Listas */
        .activity-list, .product-list { list-style: none; padding: 0; margin: 0; }
        .activity-item, .product-item { display: flex; align-items: center; padding: 1rem 0; border-bottom: 1px solid var(--border-color); }
        .activity-item:last-child, .product-item:last-child { border-bottom: none; }
        .activity-icon, .product-image { width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-right: 1rem; font-size: 1rem; }
        .activity-icon.order { background: rgba(16, 185, 129, 0.2); color: var(--success); }
        .activity-icon.user { background: rgba(59, 130, 246, 0.2); color: #3b82f6; }
        .activity-icon.product { background: rgba(139, 92, 246, 0.2); color: var(--primary-purple); }
        .activity-content, .product-info { flex: 1; }
        .activity-title, .product-name { font-weight: 600; color: var(--text-primary); margin: 0 0 0.2rem 0; }
        .activity-desc, .product-sales { color: var(--text-secondary); font-size: 0.85rem; margin: 0; }
        .activity-time { color: var(--text-muted); font-size: 0.8rem; }
        .product-image { border-radius: 8px; object-fit: cover; }
        .product-revenue { font-weight: 600; color: var(--primary-purple); }
        
        /* Acesso Rápido */
        .quick-access-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem; margin-top: 2rem; }
        .quick-access-card { background: var(--bg-card); border-radius: 15px; padding: 1.5rem; text-align: center; text-decoration: none; color: var(--text-secondary); transition: all 0.3s ease; border: 1px solid rgba(139, 92, 246, 0.1); }
        .quick-access-card:hover { transform: translateY(-5px); border-color: var(--primary-purple); color: var(--primary-purple); box-shadow: var(--shadow-medium); }
        .quick-access-icon { width: 60px; height: 60px; border-radius: 15px; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem; font-size: 1.5rem; background: rgba(139, 92, 246, 0.1); color: var(--primary-purple); }
        .quick-access-card h3 { margin: 0 0 0.5rem 0; font-size: 1.1rem; }
        .quick-access-card p { margin: 0; font-size: 0.9rem; opacity: 0.8; }
        
        /* Responsividade */
        @media (max-width: 1024px) { .admin-container { flex-direction: column; } .admin-sidebar { width: 100%; margin-right: 0; margin-bottom: 2rem; position: static; } .charts-grid { grid-template-columns: 1fr; } }
        @media (max-width: 768px) { .admin-header { flex-direction: column; align-items: flex-start; gap: 1rem; } .admin-actions { width: 100%; justify-content: space-between; } .stats-grid { grid-template-columns: 1fr; } .quick-access-grid { grid-template-columns: repeat(2, 1fr); } }
    </style>
</head>
<body class="admin-dashboard">

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
            <li><a href="relatorios_admin.php" class="active"><i class="fas fa-comment"></i>Mensagens</a></li>
           
            <li><a href="../index.php"><i class="fas fa-sign-out-alt"></i> Voltar ao Site</a></li>
        </ul>
    </aside>

    <!-- Conteúdo Principal -->
    <main class="admin-main">
        <div class="admin-header">
            <h1 class="admin-title">Dashboard</h1>
            <div class="admin-actions">
                <button class="btn btn-primary" onclick="window.location.reload()">
                    <i class="fas fa-sync-alt"></i> Atualizar
                </button>
            </div>
        </div>

        <!-- Grid de Estatísticas (DADOS REAIS) -->
        <div class="stats-grid">
            <!-- Vendas Totais -->
            <div class="stat-card">
                <div class="stat-icon primary">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <div class="stat-label">Vendas Totais</div>
                <div class="stat-value">R$ <?php echo number_format($total_vendas, 2, ',', '.'); ?></div>
                <div class="stat-change positive">
                    <i class="fas fa-check-circle"></i> Dados atualizados
                </div>
            </div>
            
            <!-- Novos Clientes -->
            <div class="stat-card">
                <div class="stat-icon success">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-label">Usuários Cadastrados</div>
                <div class="stat-value"><?php echo $users_count; ?></div>
                <div class="stat-change info">
                    <i class="fas fa-user-check"></i> Total registrado
                </div>
            </div>
            
            <!-- Pedidos Pendentes -->
            <div class="stat-card">
                <div class="stat-icon warning">
                    <i class="fas fa-box"></i>
                </div>
                <div class="stat-label">Pedidos Pendentes</div>
                <div class="stat-value"><?php echo $pedidos_pendentes; ?></div>
                <div class="stat-change <?php echo $pedidos_pendentes > 0 ? 'negative' : 'positive'; ?>">
                    <?php echo $pedidos_pendentes > 0 ? '<i class="fas fa-clock"></i> Requer atenção' : '<i class="fas fa-check"></i> Tudo em dia'; ?>
                </div>
            </div>
            
            <!-- Taxa (Estática/Exemplo pois precisa de tracking de visitas) -->
            <div class="stat-card">
                <div class="stat-icon info">
                    <i class="fas fa-chart-line"></i>
                </div>
                <div class="stat-label">Status do Sistema</div>
                <div class="stat-value" style="font-size:1.5rem">Online</div>
                <div class="stat-change positive">
                    <i class="fas fa-server"></i> Conectado
                </div>
            </div>
        </div>
        
        <!-- Grid de Gráficos -->
        <div class="charts-grid">
            <div class="chart-container">
                <div class="chart-header">
                    <h3 class="chart-title">Vendas este Ano</h3>
                </div>
                <div class="chart-wrapper">
                    <canvas id="salesChart"></canvas>
                </div>
            </div>
            
            <div class="chart-container">
                <div class="chart-header">
                    <h3 class="chart-title">Categorias Vendidas</h3>
                </div>
                <div class="chart-wrapper">
                    <canvas id="categoriesChart"></canvas>
                </div>
            </div>
        </div>
        
        <!-- Grid Inferior (Listas) -->
        <div class="charts-grid">
            <!-- Atividade Recente (DADOS REAIS) -->
            <div class="chart-container">
                <div class="chart-header">
                    <h3 class="chart-title">Pedidos Recentes</h3>
                    <div class="chart-actions">
                        <a href="pedidos_admin.php" style="text-decoration:none; font-size:0.8rem;">Ver Todos</a>
                    </div>
                </div>
                <ul class="activity-list">
                    <?php if($res_recent && $res_recent->num_rows > 0): ?>
                        <?php while($order = $res_recent->fetch_assoc()): ?>
                            <li class="activity-item">
                                <div class="activity-icon order">
                                    <i class="fas fa-shopping-bag"></i>
                                </div>
                                <div class="activity-content">
                                    <h4 class="activity-title">Pedido #<?php echo $order['id']; ?></h4>
                                    <p class="activity-desc">
                                        <?php echo htmlspecialchars($order['cliente_nome']); ?> - 
                                        R$ <?php echo number_format($order['total'], 2, ',', '.'); ?>
                                    </p>
                                </div>
                                <div class="activity-time">
                                    <?php echo date('d/m H:i', strtotime($order['data_pedido'])); ?>
                                </div>
                            </li>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <li class="activity-item"><p style="padding:10px; color:var(--text-secondary);">Nenhum pedido recente.</p></li>
                    <?php endif; ?>
                </ul>
            </div>
            
            <!-- Produtos Mais Vendidos (DADOS REAIS) -->
            <div class="chart-container">
                <div class="chart-header">
                    <h3 class="chart-title">Top 3 Produtos</h3>
                </div>
                <ul class="product-list">
                    <?php if($res_top && $res_top->num_rows > 0): ?>
                        <?php while($prod = $res_top->fetch_assoc()): ?>
                            <li class="product-item">
                                <div class="activity-icon product">
                                    <i class="fas fa-crown"></i>
                                </div>
                                <div class="product-info">
                                    <h4 class="product-name"><?php echo htmlspecialchars($prod['produto_nome']); ?></h4>
                                    <p class="product-sales"><?php echo $prod['qtd_total']; ?> unidades vendidas</p>
                                </div>
                                <div class="product-revenue">
                                    R$ <?php echo number_format($prod['receita_total'], 2, ',', '.'); ?>
                                </div>
                            </li>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <li class="product-item"><p style="padding:10px; color:var(--text-secondary);">Ainda não há vendas suficientes.</p></li>
                    <?php endif; ?>
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
                    <div class="quick-access-icon"><i class="fas fa-box"></i></div>
                    <h3>Gerenciar Produtos</h3>
                    <p>Adicionar, editar ou remover</p>
                </a>
                <a href="usuarios_admin.php" class="quick-access-card">
                    <div class="quick-access-icon"><i class="fas fa-users"></i></div>
                    <h3>Gerenciar Usuários</h3>
                    <p>Administrar contas</p>
                </a>
                <a href="pedidos_admin.php" class="quick-access-card">
                    <div class="quick-access-icon"><i class="fas fa-shopping-cart"></i></div>
                    <h3>Ver Pedidos</h3>
                    <p>Gerenciar status de envio</p>
                </a>
                <a href="relatorios_admin.php" class="quick-access-card">
                    <div class="quick-access-icon"><i class="fas fa-chart-line"></i></div>
                    <h3>Relatórios</h3>
                    <p>Visualizar métricas</p>
                </a>
            </div>
        </div>
    </main>
</div>

<script src="../js/script.js"></script>
<script>
    // ==========================================
    // INJETANDO DADOS PHP NO JAVASCRIPT
    // ==========================================
    const phpSalesData = <?php echo json_encode(array_values($sales_month_data)); ?>;
    const phpCatLabels = <?php echo json_encode($cat_labels); ?>;
    const phpCatData   = <?php echo json_encode($cat_data); ?>;

    document.addEventListener('DOMContentLoaded', function() {
        
        // 1. Configuração do Gráfico de Vendas (Linha)
        const salesCtx = document.getElementById('salesChart').getContext('2d');
        new Chart(salesCtx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
                datasets: [{
                    label: 'Vendas (R$)',
                    data: phpSalesData, // Usa os dados do PHP
                    borderColor: 'rgba(139, 92, 246, 1)',
                    backgroundColor: 'rgba(139, 92, 246, 0.1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: 'rgba(139, 92, 246, 1)',
                    pointBorderColor: '#fff',
                    pointRadius: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        mode: 'index',
                        intersect: false,
                        callbacks: {
                            label: function(context) {
                                return `R$ ${context.raw.toLocaleString('pt-BR', {minimumFractionDigits: 2})}`;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { color: 'rgba(255, 255, 255, 0.1)' },
                        ticks: {
                            color: 'rgba(255, 255, 255, 0.7)',
                            callback: function(value) { return 'R$ ' + value; }
                        }
                    },
                    x: {
                        grid: { color: 'rgba(255, 255, 255, 0.1)' },
                        ticks: { color: 'rgba(255, 255, 255, 0.7)' }
                    }
                }
            }
        });
        
        // 2. Configuração do Gráfico de Categorias (Rosca)
        const categoriesCtx = document.getElementById('categoriesChart').getContext('2d');
        
        // Se não houver dados, mostra um placeholder
        const finalCatData = phpCatData.length > 0 ? phpCatData : [1];
        const finalCatLabels = phpCatLabels.length > 0 ? phpCatLabels : ['Sem dados'];
        const finalColors = phpCatData.length > 0 ? 
            ['rgba(139, 92, 246, 0.8)', 'rgba(167, 139, 250, 0.8)', 'rgba(196, 181, 253, 0.8)', 'rgba(59, 130, 246, 0.8)'] : 
            ['rgba(255, 255, 255, 0.1)'];

        new Chart(categoriesCtx, {
            type: 'doughnut',
            data: {
                labels: finalCatLabels,
                datasets: [{
                    data: finalCatData,
                    backgroundColor: finalColors,
                    borderColor: 'rgba(30, 30, 40, 1)', // Cor de fundo do card para "separar" fatias
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            color: 'rgba(255, 255, 255, 0.7)',
                            padding: 15,
                            usePointStyle: true
                        }
                    }
                },
                cutout: '70%'
            }
        });
    });
</script>
</body>
</html>