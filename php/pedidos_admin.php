<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Pedidos - Susanoo Admin</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
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
        
        /* Pedidos */
        .products-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }
        
        .search-box {
            position: relative;
            width: 300px;
        }
        
        .search-box input {
            width: 100%;
            padding: 0.8rem 1rem 0.8rem 2.5rem;
            border: 1px solid var(--border-color);
            border-radius: 10px;
            background: var(--bg-card);
            color: var(--text-primary);
            font-size: 0.9rem;
        }
        
        .search-box i {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
        }
        
        .data-table {
            width: 100%;
            background: var(--bg-card);
            border-radius: 15px;
            overflow: hidden;
            box-shadow: var(--shadow-soft);
            border: 1px solid rgba(139, 92, 246, 0.1);
        }
        
        .data-table table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .data-table th {
            background: rgba(139, 92, 246, 0.05);
            padding: 1.2rem 1rem;
            text-align: left;
            font-weight: 600;
            color: var(--text-primary);
            border-bottom: 1px solid var(--border-color);
        }
        
        .data-table td {
            padding: 1.2rem 1rem;
            border-bottom: 1px solid var(--border-color);
            color: var(--text-secondary);
        }
        
        .data-table tr:last-child td {
            border-bottom: none;
        }
        
        .data-table tr:hover {
            background: rgba(139, 92, 246, 0.02);
        }
        
        .status-badge {
            padding: 0.4rem 0.8rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
        }
        
        .status-pending {
            background: rgba(245, 158, 11, 0.2);
            color: var(--warning);
        }
        
        .status-processing {
            background: rgba(59, 130, 246, 0.2);
            color: #3b82f6;
        }
        
        .status-shipped {
            background: rgba(139, 92, 246, 0.2);
            color: var(--primary-purple);
        }
        
        .status-delivered {
            background: rgba(16, 185, 129, 0.2);
            color: var(--success);
        }
        
        .status-cancelled {
            background: rgba(239, 68, 68, 0.2);
            color: var(--error);
        }
        
        .action-buttons {
            display: flex;
            gap: 0.5rem;
        }
        
        .btn-icon {
            width: 35px;
            height: 35px;
            border: none;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s ease;
            font-size: 0.9rem;
        }
        
        .btn-edit {
            background: rgba(59, 130, 246, 0.1);
            color: #3b82f6;
        }
        
        .btn-delete {
            background: rgba(239, 68, 68, 0.1);
            color: var(--error);
        }
        
        .btn-view {
            background: rgba(139, 92, 246, 0.1);
            color: var(--primary-purple);
        }
        
        .btn-edit:hover {
            background: #3b82f6;
            color: white;
        }
        
        .btn-delete:hover {
            background: var(--error);
            color: white;
        }
        
        .btn-view:hover {
            background: var(--primary-purple);
            color: white;
        }
        
        .user-info {
            display: flex;
            align-items: center;
        }
        
        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: rgba(139, 92, 246, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 1rem;
            color: var(--primary-purple);
        }
        
        .user-details h4 {
            margin: 0 0 0.2rem 0;
            color: var(--text-primary);
        }
        
        .user-details span {
            font-size: 0.85rem;
            color: var(--text-muted);
        }
        
        /* Modal */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            align-items: center;
            justify-content: center;
        }
        
        .modal.active {
            display: flex;
        }
        
        .modal-content {
            background: var(--bg-card);
            border-radius: 20px;
            padding: 2rem;
            width: 90%;
            max-width: 800px;
            max-height: 90vh;
            overflow-y: auto;
            box-shadow: var(--shadow-strong);
        }
        
        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid var(--border-color);
        }
        
        .modal-title {
            font-size: 1.5rem;
            color: var(--text-primary);
            margin: 0;
        }
        
        .close-modal {
            background: none;
            border: none;
            font-size: 1.5rem;
            color: var(--text-muted);
            cursor: pointer;
        }
        
        .order-details {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
            margin-bottom: 2rem;
        }
        
        .order-section {
            background: rgba(139, 92, 246, 0.05);
            padding: 1.5rem;
            border-radius: 10px;
            border: 1px solid rgba(139, 92, 246, 0.1);
        }
        
        .order-section h4 {
            margin: 0 0 1rem 0;
            color: var(--primary-purple);
            font-size: 1.1rem;
        }
        
        .order-items {
            width: 100%;
        }
        
        .order-item {
            display: flex;
            align-items: center;
            padding: 1rem 0;
            border-bottom: 1px solid var(--border-color);
        }
        
        .order-item:last-child {
            border-bottom: none;
        }
        
        .order-item-img {
            width: 50px;
            height: 50px;
            border-radius: 8px;
            object-fit: cover;
            margin-right: 1rem;
        }
        
        .order-item-info {
            flex: 1;
        }
        
        .order-item-name {
            font-weight: 600;
            color: var(--text-primary);
            margin: 0 0 0.2rem 0;
        }
        
        .order-item-details {
            color: var(--text-muted);
            font-size: 0.85rem;
            margin: 0;
        }
        
        .order-total {
            text-align: right;
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--primary-purple);
            margin-top: 1rem;
            padding-top: 1rem;
            border-top: 2px solid var(--border-color);
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
            
            .order-details {
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
            
            .products-header {
                flex-direction: column;
                gap: 1rem;
                align-items: flex-start;
            }
            
            .search-box {
                width: 100%;
            }
            
            .data-table {
                overflow-x: auto;
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
            <li><a href="admin.php"><i class="fas fa-chart-pie"></i> Dashboard</a></li>
            <li><a href="produtos_admin.php"><i class="fas fa-box"></i> Produtos</a></li>
            <li><a href="usuarios_admin.php"><i class="fas fa-users"></i> Usuários</a></li>
            <li><a href="pedidos_admin.php" class="active"><i class="fas fa-shopping-cart"></i> Pedidos</a></li>
            <li><a href="relatorios_admin.php"><i class="fas fa-chart-line"></i> Relatórios</a></li>
            <li><a href="configuracoes_admin.php"><i class="fas fa-cog"></i> Configurações</a></li>
            <li><a href="../index.php"><i class="fas fa-sign-out-alt"></i> Voltar ao Site</a></li>
        </ul>
    </aside>

    <!-- Conteúdo Principal -->
    <main class="admin-main">
        <div class="admin-header">
            <h1 class="admin-title">Gerenciar Pedidos</h1>
            <div class="admin-actions">
                <button class="btn btn-secondary" id="export-orders">
                    <i class="fas fa-download"></i> Exportar
                </button>
            </div>
        </div>

        <div class="products-header">
            <div class="search-box">
                <i class="fas fa-search"></i>
                <input type="text" placeholder="Buscar pedidos..." id="search-orders">
            </div>
            <div class="filter-options">
                <select id="status-filter">
                    <option value="">Todos os status</option>
                    <option value="pending">Pendente</option>
                    <option value="processing">Processando</option>
                    <option value="shipped">Enviado</option>
                    <option value="delivered">Entregue</option>
                    <option value="cancelled">Cancelado</option>
                </select>
                <select id="date-filter">
                    <option value="">Todos os períodos</option>
                    <option value="today">Hoje</option>
                    <option value="week">Esta semana</option>
                    <option value="month">Este mês</option>
                </select>
            </div>
        </div>

        <div class="data-table">
            <table>
                <thead>
                    <tr>
                        <th>Pedido</th>
                        <th>Cliente</th>
                        <th>Data</th>
                        <th>Valor</th>
                        <th>Status</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <div class="user-info">
                                <div class="user-avatar">
                                    <i class="fas fa-receipt"></i>
                                </div>
                                <div class="user-details">
                                    <h4>#4582</h4>
                                    <span>3 produtos</span>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="user-details">
                                <h4>João Silva</h4>
                                <span>joao.silva@email.com</span>
                            </div>
                        </td>
                        <td>15/03/2024</td>
                        <td>R$ 419,70</td>
                        <td><span class="status-badge status-processing">Processando</span></td>
                        <td>
                            <div class="action-buttons">
                                <button class="btn-icon btn-view" title="Visualizar" data-order="4582">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn-icon btn-edit" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="user-info">
                                <div class="user-avatar">
                                    <i class="fas fa-receipt"></i>
                                </div>
                                <div class="user-details">
                                    <h4>#4581</h4>
                                    <span>2 produtos</span>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="user-details">
                                <h4>Maria Oliveira</h4>
                                <span>maria.oliveira@email.com</span>
                            </div>
                        </td>
                        <td>14/03/2024</td>
                        <td>R$ 249,90</td>
                        <td><span class="status-badge status-shipped">Enviado</span></td>
                        <td>
                            <div class="action-buttons">
                                <button class="btn-icon btn-view" title="Visualizar" data-order="4581">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn-icon btn-edit" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="user-info">
                                <div class="user-avatar">
                                    <i class="fas fa-receipt"></i>
                                </div>
                                <div class="user-details">
                                    <h4>#4580</h4>
                                    <span>1 produto</span>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="user-details">
                                <h4>Pedro Santos</h4>
                                <span>pedro.santos@email.com</span>
                            </div>
                        </td>
                        <td>13/03/2024</td>
                        <td>R$ 99,90</td>
                        <td><span class="status-badge status-delivered">Entregue</span></td>
                        <td>
                            <div class="action-buttons">
                                <button class="btn-icon btn-view" title="Visualizar" data-order="4580">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn-icon btn-edit" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="user-info">
                                <div class="user-avatar">
                                    <i class="fas fa-receipt"></i>
                                </div>
                                <div class="user-details">
                                    <h4>#4579</h4>
                                    <span>4 produtos</span>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="user-details">
                                <h4>Ana Costa</h4>
                                <span>ana.costa@email.com</span>
                            </div>
                        </td>
                        <td>12/03/2024</td>
                        <td>R$ 729,60</td>
                        <td><span class="status-badge status-pending">Pendente</span></td>
                        <td>
                            <div class="action-buttons">
                                <button class="btn-icon btn-view" title="Visualizar" data-order="4579">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn-icon btn-edit" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </main>
</div>

<!-- Modal Detalhes do Pedido -->
<div class="modal" id="order-modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title">Detalhes do Pedido #<span id="order-number"></span></h3>
            <button class="close-modal">&times;</button>
        </div>
        
        <div class="order-details">
            <div class="order-section">
                <h4>Informações do Cliente</h4>
                <p><strong>Nome:</strong> <span id="customer-name">João Silva</span></p>
                <p><strong>Email:</strong> <span id="customer-email">joao.silva@email.com</span></p>
                <p><strong>Telefone:</strong> <span id="customer-phone">(11) 99999-9999</span></p>
            </div>
            
            <div class="order-section">
                <h4>Endereço de Entrega</h4>
                <p id="shipping-address">Rua das Flores, 123 - Centro<br>São Paulo - SP<br>CEP: 01234-567</p>
            </div>
        </div>
        
        <div class="order-section">
            <h4>Itens do Pedido</h4>
            <div class="order-items">
                <div class="order-item">
                    <img src="../assets/img/IMG3.png" alt="Camisa Brazil" class="order-item-img">
                    <div class="order-item-info">
                        <div class="order-item-name">Camisa Brazil</div>
                        <div class="order-item-details">Quantidade: 1 • Tamanho: M</div>
                    </div>
                    <div class="order-item-price">R$ 99,90</div>
                </div>
                <div class="order-item">
                    <img src="../assets/img/Imagem2.png" alt="Moletom Sakura" class="order-item-img">
                    <div class="order-item-info">
                        <div class="order-item-name">Moletom Sakura</div>
                        <div class="order-item-details">Quantidade: 1 • Tamanho: G</div>
                    </div>
                    <div class="order-item-price">R$ 249,90</div>
                </div>
                <div class="order-item">
                    <img src="../assets/img/IMG5.png" alt="Boné AMATERASU" class="order-item-img">
                    <div class="order-item-info">
                        <div class="order-item-name">Boné AMATERASU</div>
                        <div class="order-item-details">Quantidade: 1</div>
                    </div>
                    <div class="order-item-price">R$ 69,90</div>
                </div>
            </div>
            <div class="order-total">
                Total: R$ 419,70
            </div>
        </div>
        
        <div class="admin-actions" style="margin-top: 2rem;">
            <button type="button" class="btn btn-secondary close-modal">Fechar</button>
            <button type="button" class="btn btn-primary" id="update-status">Atualizar Status</button>
        </div>
    </div>
</div>

<script src="../js/script.js"></script>
<script>
    // Controle do Modal
    const modal = document.getElementById('order-modal');
    const closeModalBtns = document.querySelectorAll('.close-modal');

    // Fechar modal
    closeModalBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            modal.classList.remove('active');
        });
    });

    // Fechar modal clicando fora
    modal.addEventListener('click', (e) => {
        if (e.target === modal) {
            modal.classList.remove('active');
        }
    });

    // Visualizar pedido
    document.querySelectorAll('.btn-view').forEach(btn => {
        btn.addEventListener('click', function() {
            const orderNumber = this.getAttribute('data-order');
            document.getElementById('order-number').textContent = orderNumber;
            modal.classList.add('active');
        });
    });

    // Busca de pedidos
    const searchInput = document.getElementById('search-orders');
    searchInput.addEventListener('input', filterOrders);

    // Filtros
    const statusFilter = document.getElementById('status-filter');
    const dateFilter = document.getElementById('date-filter');
    
    statusFilter.addEventListener('change', filterOrders);
    dateFilter.addEventListener('change', filterOrders);

    function filterOrders() {
        const searchTerm = searchInput.value.toLowerCase();
        const statusValue = statusFilter.value;
        const dateValue = dateFilter.value;
        
        const rows = document.querySelectorAll('.data-table tbody tr');
        
        rows.forEach(row => {
            const orderNumber = row.querySelector('.user-details h4').textContent.toLowerCase();
            const customerName = row.cells[1].querySelector('h4').textContent.toLowerCase();
            const status = row.cells[4].textContent.toLowerCase();
            
            const matchesSearch = orderNumber.includes(searchTerm) || customerName.includes(searchTerm);
            const matchesStatus = !statusValue || status.includes(statusValue);
            const matchesDate = !dateValue; // Implementação básica
            
            if (matchesSearch && matchesStatus && matchesDate) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    // Atualizar status do pedido
    document.getElementById('update-status').addEventListener('click', function() {
        const statusSelect = document.createElement('select');
        statusSelect.innerHTML = `
            <option value="pending">Pendente</option>
            <option value="processing">Processando</option>
            <option value="shipped">Enviado</option>
            <option value="delivered">Entregue</option>
            <option value="cancelled">Cancelado</option>
        `;
        
        const currentStatus = document.querySelector('.status-badge').textContent.toLowerCase();
        statusSelect.value = currentStatus;
        
        if (confirm('Deseja atualizar o status do pedido?')) {
            showNotification('Status do pedido atualizado com sucesso!', 'success');
            modal.classList.remove('active');
        }
    });

    // Exportar pedidos
    document.getElementById('export-orders').addEventListener('click', function() {
        this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Exportando...';
        setTimeout(() => {
            this.innerHTML = '<i class="fas fa-download"></i> Exportar';
            showNotification('Pedidos exportados com sucesso!', 'success');
        }, 1500);
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