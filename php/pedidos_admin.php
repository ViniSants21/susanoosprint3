<?php
// ==========================================================
// 1. LÓGICA PHP (Processamento de Dados)
// ==========================================================
session_start();
require_once 'conexao.php'; // Certifique-se que conecta ao banco corretamente

// -- A. Atualizar Status do Pedido --
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update_status') {
    $pedido_id = intval($_POST['pedido_id']);
    $novo_status = $conn->real_escape_string($_POST['status_pedido']);
    
    $sql_update = "UPDATE pedidos SET status = '$novo_status' WHERE id = $pedido_id";
    if ($conn->query($sql_update)) {
        // Redireciona para evitar reenvio do formulário ao atualizar (F5)
        header("Location: pedidos_admin.php?msg=status_updated");
        exit;
    } else {
        $error_msg = "Erro ao atualizar: " . $conn->error;
    }
}

// -- B. Buscar Pedidos e Itens --
// Array para armazenar pedidos e passar para o JS (para o modal funcionar rápido)
$orders_data = [];

// Busca pedidos ordenados por data
$sql = "SELECT * FROM pedidos ORDER BY data_pedido DESC";
$res = $conn->query($sql);

if ($res) {
    while ($row = $res->fetch_assoc()) {
        $id = $row['id'];
        
        // Busca itens deste pedido
        $sql_itens = "SELECT * FROM itens_pedido WHERE pedido_id = $id";
        $res_itens = $conn->query($sql_itens);
        $itens = [];
        $qtd_total_itens = 0;
        
        while ($item = $res_itens->fetch_assoc()) {
            $itens[] = $item;
            $qtd_total_itens += $item['quantidade'];
        }
        
        // Monta o objeto completo
        $row['itens'] = $itens;
        $row['qtd_itens_total'] = $qtd_total_itens;
        $orders_data[$id] = $row;
    }
}

// Função auxiliar para classe CSS do status
function getStatusClass($status) {
    $s = strtolower($status);
    if (strpos($s, 'pendente') !== false) return 'status-pending';
    if (strpos($s, 'process') !== false) return 'status-processing';
    if (strpos($s, 'envia') !== false) return 'status-shipped';
    if (strpos($s, 'entregue') !== false || strpos($s, 'conclu') !== false) return 'status-delivered';
    if (strpos($s, 'cancel') !== false) return 'status-cancelled';
    return 'status-processing'; // Padrão
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Pedidos - Susanoo Admin</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <!-- SweetAlert2 (Para alertas bonitos) -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        (function(){
            const theme = localStorage.getItem('theme');
            if(theme === 'light') {
                document.documentElement.classList.add('light-mode');
            }
        })();
    </script>
    <style>
        /* ===== ESTILOS DO PAINEL ADMIN (MANTIDOS) ===== */
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
        
        /* Pedidos Styles */
        .products-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; }
        .search-box { position: relative; width: 300px; }
        .search-box input { width: 100%; padding: 0.8rem 1rem 0.8rem 2.5rem; border: 1px solid var(--border-color); border-radius: 10px; background: var(--bg-card); color: var(--text-primary); font-size: 0.9rem; }
        .search-box i { position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: var(--text-muted); }
        
        .filter-options select { padding: 0.8rem; border-radius: 10px; border: 1px solid var(--border-color); background: var(--bg-card); color: var(--text-primary); margin-left: 10px; }

        .data-table { width: 100%; background: var(--bg-card); border-radius: 15px; overflow: hidden; box-shadow: var(--shadow-soft); border: 1px solid rgba(139, 92, 246, 0.1); }
        .data-table table { width: 100%; border-collapse: collapse; }
        .data-table th { background: rgba(139, 92, 246, 0.05); padding: 1.2rem 1rem; text-align: left; font-weight: 600; color: var(--text-primary); border-bottom: 1px solid var(--border-color); }
        .data-table td { padding: 1.2rem 1rem; border-bottom: 1px solid var(--border-color); color: var(--text-secondary); vertical-align: middle; }
        .data-table tr:last-child td { border-bottom: none; }
        .data-table tr:hover { background: rgba(139, 92, 246, 0.02); }
        
        /* Badges */
        .status-badge { padding: 0.4rem 0.8rem; border-radius: 20px; font-size: 0.8rem; font-weight: 600; white-space: nowrap; }
        .status-pending { background: rgba(245, 158, 11, 0.2); color: var(--warning); }
        .status-processing { background: rgba(59, 130, 246, 0.2); color: #3b82f6; }
        .status-shipped { background: rgba(139, 92, 246, 0.2); color: var(--primary-purple); }
        .status-delivered { background: rgba(16, 185, 129, 0.2); color: var(--success); }
        .status-cancelled { background: rgba(239, 68, 68, 0.2); color: var(--error); }
        
        .action-buttons { display: flex; gap: 0.5rem; }
        .btn-icon { width: 35px; height: 35px; border: none; border-radius: 8px; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.2s ease; font-size: 0.9rem; }
        .btn-view { background: rgba(139, 92, 246, 0.1); color: var(--primary-purple); }
        .btn-view:hover { background: var(--primary-purple); color: white; }
        
        .user-info { display: flex; align-items: center; }
        .user-avatar { width: 40px; height: 40px; border-radius: 50%; background: rgba(139, 92, 246, 0.1); display: flex; align-items: center; justify-content: center; margin-right: 1rem; color: var(--primary-purple); }
        .user-details h4 { margin: 0 0 0.2rem 0; color: var(--text-primary); }
        .user-details span { font-size: 0.85rem; color: var(--text-muted); }
        
        /* Modal */
        .modal { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.5); z-index: 1000; align-items: center; justify-content: center; backdrop-filter: blur(5px); }
        .modal.active { display: flex; }
        .modal-content { background: var(--bg-card); border-radius: 20px; padding: 2rem; width: 90%; max-width: 800px; max-height: 90vh; overflow-y: auto; box-shadow: var(--shadow-strong); border: 1px solid rgba(139, 92, 246, 0.2); }
        .modal-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; padding-bottom: 1rem; border-bottom: 1px solid var(--border-color); }
        .modal-title { font-size: 1.5rem; color: var(--text-primary); margin: 0; }
        .close-modal { background: none; border: none; font-size: 1.5rem; color: var(--text-muted); cursor: pointer; }
        
        .order-details { display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; margin-bottom: 2rem; }
        .order-section { background: rgba(139, 92, 246, 0.05); padding: 1.5rem; border-radius: 10px; border: 1px solid rgba(139, 92, 246, 0.1); }
        .order-section h4 { margin: 0 0 1rem 0; color: var(--primary-purple); font-size: 1.1rem; }
        
        .order-items { width: 100%; }
        .order-item { display: flex; align-items: center; padding: 1rem 0; border-bottom: 1px solid var(--border-color); }
        .order-item:last-child { border-bottom: none; }
        .order-item-img { width: 50px; height: 50px; border-radius: 8px; object-fit: cover; margin-right: 1rem; background: #333; }
        .order-item-info { flex: 1; }
        .order-item-name { font-weight: 600; color: var(--text-primary); margin: 0 0 0.2rem 0; }
        .order-item-details { color: var(--text-muted); font-size: 0.85rem; margin: 0; }
        .order-total { text-align: right; font-size: 1.2rem; font-weight: 700; color: var(--primary-purple); margin-top: 1rem; padding-top: 1rem; border-top: 2px solid var(--border-color); }
        
        /* Form elements inside modal */
        .status-select-container { margin-top: 1.5rem; padding-top: 1.5rem; border-top: 1px solid var(--border-color); }
        .form-select { width: 100%; padding: 0.8rem; border-radius: 10px; border: 1px solid var(--border-color); background: var(--bg-primary); color: var(--text-primary); margin-bottom: 1rem; }
        .btn-save { width: 100%; padding: 10px; background: var(--primary-purple); color: white; border: none; border-radius: 8px; font-weight: bold; cursor: pointer; transition: 0.3s; }
        .btn-save:hover { background: var(--secondary-purple); }

        /* Responsividade */
        @media (max-width: 1024px) { .admin-container { flex-direction: column; } .admin-sidebar { width: 100%; margin-right: 0; margin-bottom: 2rem; position: static; } .order-details { grid-template-columns: 1fr; } }
        @media (max-width: 768px) { .admin-header { flex-direction: column; align-items: flex-start; gap: 1rem; } .admin-actions { width: 100%; justify-content: space-between; } .products-header { flex-direction: column; gap: 1rem; align-items: flex-start; } .search-box { width: 100%; } .data-table { overflow-x: auto; } }
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
            <li><a href="admin.php"><i class="fas fa-chart-pie"></i> Dashboard</a></li>
            <li><a href="produtos_admin.php"><i class="fas fa-box"></i> Produtos</a></li>
            <li><a href="usuarios_admin.php"><i class="fas fa-users"></i> Usuários</a></li>
            <li><a href="pedidos_admin.php" class="active"><i class="fas fa-shopping-cart"></i> Pedidos</a></li>
            <li><a href="relatorios_admin.php" class="active"><i class="fas fa-comment"></i>Mensagens</a></li>
            
            <li><a href="../index.php"><i class="fas fa-sign-out-alt"></i> Voltar ao Site</a></li>
        </ul>
    </aside>

    <!-- Conteúdo Principal -->
    <main class="admin-main">
        <div class="admin-header">
            <h1 class="admin-title">Gerenciar Pedidos</h1>
            <div class="admin-actions">
                <!-- Botão de exemplo -->
                
            </div>
        </div>

        <div class="products-header">
            <div class="search-box">
                <i class="fas fa-search"></i>
                <input type="text" placeholder="Buscar por cliente ou ID..." id="search-orders">
            </div>
            <div class="filter-options">
                <select id="status-filter">
                    <option value="">Todos os status</option>
                    <option value="Pendente">Pendente</option>
                    <option value="Processando">Processando</option>
                    <option value="Enviado">Enviado</option>
                    <option value="Entregue">Entregue</option>
                    <option value="Cancelado">Cancelado</option>
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
                    <?php if (empty($orders_data)): ?>
                        <tr>
                            <td colspan="6" style="text-align:center; padding: 2rem;">Nenhum pedido encontrado.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach($orders_data as $order): ?>
                        <tr class="order-row" data-status="<?php echo $order['status']; ?>">
                            <!-- Coluna Pedido -->
                            <td>
                                <div class="user-info">
                                    <div class="user-avatar">
                                        <i class="fas fa-receipt"></i>
                                    </div>
                                    <div class="user-details">
                                        <h4>#<?php echo $order['id']; ?></h4>
                                        <span><?php echo $order['qtd_itens_total']; ?> produtos</span>
                                    </div>
                                </div>
                            </td>
                            
                            <!-- Coluna Cliente -->
                            <td>
                                <div class="user-details">
                                    <h4><?php echo htmlspecialchars($order['cliente_nome']); ?></h4>
                                    <span><?php echo htmlspecialchars($order['cliente_email']); ?></span>
                                </div>
                            </td>
                            
                            <!-- Coluna Data -->
                            <td><?php echo date('d/m/Y', strtotime($order['data_pedido'])); ?></td>
                            
                            <!-- Coluna Valor -->
                            <td style="font-weight:bold; color:var(--primary-purple);">
                                R$ <?php echo number_format($order['total'], 2, ',', '.'); ?>
                            </td>
                            
                            <!-- Coluna Status -->
                            <td>
                                <span class="status-badge <?php echo getStatusClass($order['status']); ?>">
                                    <?php echo htmlspecialchars($order['status']); ?>
                                </span>
                            </td>
                            
                            <!-- Coluna Ações -->
                            <td>
                                <div class="action-buttons">
                                    <button class="btn-icon btn-view" title="Visualizar e Editar" onclick="openOrderModal(<?php echo $order['id']; ?>)">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </main>
</div>

<!-- Modal Detalhes do Pedido com Formulário de Edição -->
<div class="modal" id="order-modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title">Detalhes do Pedido #<span id="modal-order-id"></span></h3>
            <button class="close-modal">&times;</button>
        </div>
        
        <div class="order-details">
            <div class="order-section">
                <h4>Informações do Cliente</h4>
                <p><strong>Nome:</strong> <span id="modal-customer-name"></span></p>
                <p><strong>Email:</strong> <span id="modal-customer-email"></span></p>
                <p><strong>Data:</strong> <span id="modal-order-date"></span></p>
            </div>
            
            <div class="order-section" id="modal-status-section">
                <h4>Status do Pedido</h4>
                
                <!-- Formulário de Atualização -->
                <form method="POST" action="pedidos_admin.php">
                    <input type="hidden" name="action" value="update_status">
                    <input type="hidden" name="pedido_id" id="form-pedido-id">
                    
                    <select name="status_pedido" id="status-select" class="form-select">
                        <option value="Pendente">Pendente</option>
                        <option value="Processando">Processando</option>
                        <option value="Enviado">Enviado</option>
                        <option value="Entregue">Entregue</option>
                        <option value="Cancelado">Cancelado</option>
                    </select>
                    
                    <button type="submit" class="btn-save">
                        <i class="fas fa-save"></i> Atualizar Status
                    </button>
                </form>
            </div>
        </div>
        
        <div class="order-section">
            <h4>Itens do Pedido</h4>
            <div class="order-items" id="modal-items-list">
                <!-- Itens injetados via JS -->
            </div>
            <div class="order-total" id="modal-total">
                Total: R$ 0,00
            </div>
        </div>
    </div>
</div>

<script src="../js/script.js"></script>
<script>
    // 1. Dados dos pedidos vindos do PHP para o JS
    const ordersData = <?php echo json_encode($orders_data); ?>;

    // 2. Elementos do Modal
    const modal = document.getElementById('order-modal');
    const closeModalBtns = document.querySelectorAll('.close-modal');

    // 3. Função para abrir o modal e preencher dados
    function openOrderModal(id) {
        const order = ordersData[id];
        if(!order) return;

        // Preencher textos
        document.getElementById('modal-order-id').textContent = order.id;
        document.getElementById('form-pedido-id').value = order.id;
        document.getElementById('modal-customer-name').textContent = order.cliente_nome;
        document.getElementById('modal-customer-email').textContent = order.cliente_email;
        
        // Data formatada
        const dateObj = new Date(order.data_pedido);
        document.getElementById('modal-order-date').textContent = dateObj.toLocaleDateString('pt-BR') + ' ' + dateObj.toLocaleTimeString('pt-BR');
        
        // Selecionar o status atual no select
        document.getElementById('status-select').value = order.status;

        // Limpar e preencher lista de itens
        const itemsContainer = document.getElementById('modal-items-list');
        itemsContainer.innerHTML = '';

        let total = parseFloat(order.total);

        if(order.itens && order.itens.length > 0) {
            order.itens.forEach(item => {
                const itemTotal = parseFloat(item.preco_unitario);
                const html = `
                    <div class="order-item">
                        <div class="order-item-img" style="display:flex;align-items:center;justify-content:center;color:#fff;">
                            <i class="fas fa-box"></i>
                        </div>
                        <div class="order-item-info">
                            <div class="order-item-name">${item.produto_nome}</div>
                            <div class="order-item-details">Qtd: ${item.quantidade} • Categoria: ${item.categoria || 'Geral'}</div>
                        </div>
                        <div class="order-item-price">R$ ${itemTotal.toLocaleString('pt-BR', {minimumFractionDigits: 2})}</div>
                    </div>
                `;
                itemsContainer.insertAdjacentHTML('beforeend', html);
            });
        } else {
            itemsContainer.innerHTML = '<p>Sem itens registrados.</p>';
        }

        // Total
        document.getElementById('modal-total').textContent = 'Total: ' + total.toLocaleString('pt-BR', {style: 'currency', currency: 'BRL'});

        // Exibir modal
        modal.classList.add('active');
    }

    // 4. Fechar Modal
    closeModalBtns.forEach(btn => btn.addEventListener('click', () => modal.classList.remove('active')));
    window.addEventListener('click', (e) => { if (e.target === modal) modal.classList.remove('active'); });

    // 5. Filtros de Pesquisa na Tabela
    const searchInput = document.getElementById('search-orders');
    const statusFilter = document.getElementById('status-filter');

    function filterTable() {
        const term = searchInput.value.toLowerCase();
        const status = statusFilter.value;
        const rows = document.querySelectorAll('.order-row');

        rows.forEach(row => {
            const txt = row.innerText.toLowerCase();
            const rowStatus = row.getAttribute('data-status');
            
            const matchSearch = txt.includes(term);
            const matchStatus = status === "" || rowStatus === status;

            row.style.display = (matchSearch && matchStatus) ? '' : 'none';
        });
    }

    searchInput.addEventListener('keyup', filterTable);
    statusFilter.addEventListener('change', filterTable);

    // 6. Alerta de Sucesso (se vier do PHP após salvar)
    const urlParams = new URLSearchParams(window.location.search);
    if(urlParams.get('msg') === 'status_updated') {
        Swal.fire({
            icon: 'success',
            title: 'Sucesso!',
            text: 'Status do pedido atualizado.',
            timer: 2000,
            showConfirmButton: false
        }).then(() => {
            // Limpa a URL
            window.history.replaceState(null, null, window.location.pathname);
        });
    }
</script>
</body>
</html>