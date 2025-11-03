<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatórios - Susanoo Admin</title>
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
        
        /* Filtros de Relatórios */
        .report-filters {
            background: var(--bg-card);
            border-radius: 15px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            box-shadow: var(--shadow-soft);
            border: 1px solid rgba(139, 92, 246, 0.1);
        }
        
        .filter-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-bottom: 1rem;
        }
        
        .filter-group {
            display: flex;
            flex-direction: column;
        }
        
        .filter-group label {
            margin-bottom: 0.5rem;
            color: var(--text-primary);
            font-weight: 500;
            font-size: 0.9rem;
        }
        
        .filter-group select,
        .filter-group input {
            padding: 0.8rem;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            background: var(--bg-primary);
            color: var(--text-primary);
            font-size: 0.9rem;
        }
        
        /* Grid de Relatórios */
        .reports-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }
        
        .report-card {
            background: var(--bg-card);
            border-radius: 15px;
            padding: 1.5rem;
            box-shadow: var(--shadow-soft);
            border: 1px solid rgba(139, 92, 246, 0.1);
        }
        
        .report-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }
        
        .report-title {
            font-size: 1.2rem;
            font-weight: 600;
            color: var(--text-primary);
            margin: 0;
        }
        
        .report-actions {
            display: flex;
            gap: 0.5rem;
        }
        
        .report-actions button {
            background: transparent;
            border: 1px solid var(--border-color);
            color: var(--text-secondary);
            padding: 0.4rem 0.8rem;
            border-radius: 6px;
            font-size: 0.8rem;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        
        .report-actions button:hover {
            background: rgba(139, 92, 246, 0.1);
            color: var(--primary-purple);
            border-color: var(--primary-purple);
        }
        
        .chart-wrapper {
            height: 300px;
            position: relative;
        }
        
        /* Métricas de Resumo */
        .summary-metrics {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-bottom: 2rem;
        }
        
        .metric-card {
            background: var(--bg-card