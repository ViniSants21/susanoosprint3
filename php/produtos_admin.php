<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Produtos - Susanoo Admin</title>
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
        
        /* Produtos */
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
        
        .status-active {
            background: rgba(16, 185, 129, 0.2);
            color: var(--success);
        }
        
        .status-inactive {
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
            width: 50px;
            height: 50px;
            border-radius: 10px;
            object-fit: cover;
            margin-right: 1rem;
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
            max-width: 600px;
            max-height: 90vh;
            overflow-y: auto;
            box-shadow: var(--shadow-strong);
        }
        
        .modal-header {
            display: flex;
            justify-content: between;
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
        
        .form-group {
            margin-bottom: 1.5rem;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            color: var(--text-primary);
            font-weight: 500;
        }
        
        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 0.8rem 1rem;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            background: var(--bg-primary);
            color: var(--text-primary);
            font-size: 0.9rem;
            transition: all 0.3s ease;
        }
        
        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: var(--primary-purple);
            box-shadow: 0 0 0 3px rgba(139, 92, 246, 0.1);
        }
        
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }
        
        .image-upload {
            border: 2px dashed var(--border-color);
            border-radius: 10px;
            padding: 2rem;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .image-upload:hover {
            border-color: var(--primary-purple);
        }
        
        .image-upload i {
            font-size: 2rem;
            color: var(--text-muted);
            margin-bottom: 1rem;
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
            
            .form-row {
                grid-template-columns: 1fr;
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
            <li><a href="produtos_admin.php" class="active"><i class="fas fa-box"></i> Produtos</a></li>
            <li><a href="usuarios_admin.php"><i class="fas fa-users"></i> Usuários</a></li>
            <li><a href="#"><i class="fas fa-shopping-cart"></i> Pedidos</a></li>
            <li><a href="#"><i class="fas fa-chart-line"></i> Relatórios</a></li>
            <li><a href="#"><i class="fas fa-cog"></i> Configurações</a></li>
            <li><a href="../index.php"><i class="fas fa-sign-out-alt"></i> Voltar ao Site</a></li>
        </ul>
    </aside>

    <!-- Conteúdo Principal -->
    <main class="admin-main">
        <div class="admin-header">
            <h1 class="admin-title">Gerenciar Produtos</h1>
            <div class="admin-actions">
                <button class="btn btn-primary" id="add-product">
                    <i class="fas fa-plus"></i> Adicionar Produto
                </button>
                <button class="btn btn-secondary" id="export-products">
                    <i class="fas fa-download"></i> Exportar
                </button>
            </div>
        </div>

        <div class="products-header">
            <div class="search-box">
                <i class="fas fa-search"></i>
                <input type="text" placeholder="Buscar produtos..." id="search-products">
            </div>
            <div class="filter-options">
                <select id="category-filter">
                    <option value="">Todas as categorias</option>
                    <option value="camisetas">Camisetas</option>
                    <option value="moletons">Moletons</option>
                    <option value="acessorios">Acessórios</option>
                    <option value="colecoes">Coleções</option>
                </select>
                <select id="status-filter">
                    <option value="">Todos os status</option>
                    <option value="ativo">Ativo</option>
                    <option value="inativo">Inativo</option>
                </select>
            </div>
        </div>

        <div class="data-table">
            <table>
                <thead>
                    <tr>
                        <th>Produto</th>
                        <th>Categoria</th>
                        <th>Status</th>
                        <th>Preço</th>
                        <th>Estoque</th>
                        <th>Vendas</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <div class="user-info">
                                <img src="../assets/img/IMG3.png" alt="Camisa Brazil" class="user-avatar">
                                <div class="user-details">
                                    <h4>Camisa Brazil</h4>
                                    <span>SKU: CB-001</span>
                                </div>
                            </div>
                        </td>
                        <td>Camisetas</td>
                        <td><span class="status-badge status-active">Ativo</span></td>
                        <td>R$ 99,90</td>
                        <td>150</td>
                        <td>128</td>
                        <td>
                            <div class="action-buttons">
                                <button class="btn-icon btn-view" title="Visualizar"><i class="fas fa-eye"></i></button>
                                <button class="btn-icon btn-edit" title="Editar"><i class="fas fa-edit"></i></button>
                                <button class="btn-icon btn-delete" title="Excluir"><i class="fas fa-trash"></i></button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="user-info">
                                <img src="../assets/img/Imagem2.png" alt="Moletom Sakura" class="user-avatar">
                                <div class="user-details">
                                    <h4>Moletom Sakura</h4>
                                    <span>SKU: MS-002</span>
                                </div>
                            </div>
                        </td>
                        <td>Moletons</td>
                        <td><span class="status-badge status-active">Ativo</span></td>
                        <td>R$ 249,90</td>
                        <td>80</td>
                        <td>94</td>
                        <td>
                            <div class="action-buttons">
                                <button class="btn-icon btn-view" title="Visualizar"><i class="fas fa-eye"></i></button>
                                <button class="btn-icon btn-edit" title="Editar"><i class="fas fa-edit"></i></button>
                                <button class="btn-icon btn-delete" title="Excluir"><i class="fas fa-trash"></i></button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="user-info">
                                <img src="../assets/img/IMG5.png" alt="Boné AMATERASU" class="user-avatar">
                                <div class="user-details">
                                    <h4>Boné AMATERASU</h4>
                                    <span>SKU: BA-003</span>
                                </div>
                            </div>
                        </td>
                        <td>Acessórios</td>
                        <td><span class="status-badge status-inactive">Inativo</span></td>
                        <td>R$ 69,90</td>
                        <td>0</td>
                        <td>76</td>
                        <td>
                            <div class="action-buttons">
                                <button class="btn-icon btn-view" title="Visualizar"><i class="fas fa-eye"></i></button>
                                <button class="btn-icon btn-edit" title="Editar"><i class="fas fa-edit"></i></button>
                                <button class="btn-icon btn-delete" title="Excluir"><i class="fas fa-trash"></i></button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="user-info">
                                <img src="../assets/img/Imagem.png" alt="Coleção Especial" class="user-avatar">
                                <div class="user-details">
                                    <h4>Coleção Especial</h4>
                                    <span>SKU: CE-004</span>
                                </div>
                            </div>
                        </td>
                        <td>Coleções</td>
                        <td><span class="status-badge status-active">Ativo</span></td>
                        <td>R$ 359,90</td>
                        <td>25</td>
                        <td>42</td>
                        <td>
                            <div class="action-buttons">
                                <button class="btn-icon btn-view" title="Visualizar"><i class="fas fa-eye"></i></button>
                                <button class="btn-icon btn-edit" title="Editar"><i class="fas fa-edit"></i></button>
                                <button class="btn-icon btn-delete" title="Excluir"><i class="fas fa-trash"></i></button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </main>
</div>

<!-- Modal Adicionar/Editar Produto -->
<div class="modal" id="product-modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title" id="modal-title">Adicionar Produto</h3>
            <button class="close-modal">&times;</button>
        </div>
        <form id="product-form">
            <div class="form-group">
                <label for="product-image">Imagem do Produto</label>
                <div class="image-upload" id="image-upload">
                    <i class="fas fa-cloud-upload-alt"></i>
                    <p>Clique para fazer upload da imagem</p>
                    <input type="file" id="product-image" accept="image/*" style="display: none;">
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="product-name">Nome do Produto</label>
                    <input type="text" id="product-name" required>
                </div>
                <div class="form-group">
                    <label for="product-sku">SKU</label>
                    <input type="text" id="product-sku" required>
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="product-category">Categoria</label>
                    <select id="product-category" required>
                        <option value="">Selecione uma categoria</option>
                        <option value="camisetas">Camisetas</option>
                        <option value="moletons">Moletons</option>
                        <option value="acessorios">Acessórios</option>
                        <option value="colecoes">Coleções</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="product-status">Status</label>
                    <select id="product-status" required>
                        <option value="ativo">Ativo</option>
                        <option value="inativo">Inativo</option>
                    </select>
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="product-price">Preço (R$)</label>
                    <input type="number" id="product-price" step="0.01" required>
                </div>
                <div class="form-group">
                    <label for="product-stock">Estoque</label>
                    <input type="number" id="product-stock" required>
                </div>
            </div>
            
            <div class="form-group">
                <label for="product-description">Descrição</label>
                <textarea id="product-description" rows="4"></textarea>
            </div>
            
            <div class="admin-actions" style="margin-top: 2rem;">
                <button type="button" class="btn btn-secondary close-modal">Cancelar</button>
                <button type="submit" class="btn btn-primary">Salvar Produto</button>
            </div>
        </form>
    </div>
</div>

<script src="../js/script.js"></script>
<script>
    // Controle do Modal
    const modal = document.getElementById('product-modal');
    const addProductBtn = document.getElementById('add-product');
    const closeModalBtns = document.querySelectorAll('.close-modal');
    const imageUpload = document.getElementById('image-upload');
    const productImage = document.getElementById('product-image');

    // Abrir modal
    addProductBtn.addEventListener('click', () => {
        modal.classList.add('active');
        document.getElementById('modal-title').textContent = 'Adicionar Produto';
        document.getElementById('product-form').reset();
    });

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

    // Upload de imagem
    imageUpload.addEventListener('click', () => {
        productImage.click();
    });

    productImage.addEventListener('change', (e) => {
        if (e.target.files.length > 0) {
            const fileName = e.target.files[0].name;
            imageUpload.innerHTML = `
                <i class="fas fa-check" style="color: var(--success);"></i>
                <p>${fileName}</p>
                <small>Clique para alterar</small>
            `;
        }
    });

    // Busca de produtos
    const searchInput = document.getElementById('search-products');
    searchInput.addEventListener('input', filterProducts);

    // Filtros
    const categoryFilter = document.getElementById('category-filter');
    const statusFilter = document.getElementById('status-filter');
    
    categoryFilter.addEventListener('change', filterProducts);
    statusFilter.addEventListener('change', filterProducts);

    function filterProducts() {
        const searchTerm = searchInput.value.toLowerCase();
        const categoryValue = categoryFilter.value;
        const statusValue = statusFilter.value;
        
        const rows = document.querySelectorAll('.data-table tbody tr');
        
        rows.forEach(row => {
            const productName = row.querySelector('.user-details h4').textContent.toLowerCase();
            const category = row.cells[1].textContent.toLowerCase();
            const status = row.cells[2].textContent.toLowerCase();
            
            const matchesSearch = productName.includes(searchTerm);
            const matchesCategory = !categoryValue || category.includes(categoryValue);
            const matchesStatus = !statusValue || status.includes(statusValue);
            
            if (matchesSearch && matchesCategory && matchesStatus) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    // Ações dos botões
    document.querySelectorAll('.btn-edit').forEach(btn => {
        btn.addEventListener('click', function() {
            const row = this.closest('tr');
            const productName = row.querySelector('.user-details h4').textContent;
            
            document.getElementById('modal-title').textContent = `Editar ${productName}`;
            modal.classList.add('active');
            
            // Aqui você preencheria o formulário com os dados existentes
        });
    });

    document.querySelectorAll('.btn-delete').forEach(btn => {
        btn.addEventListener('click', function() {
            const row = this.closest('tr');
            const productName = row.querySelector('.user-details h4').textContent;
            
            if (confirm(`Tem certeza que deseja excluir o produto "${productName}"?`)) {
                row.style.opacity = '0.5';
                setTimeout(() => {
                    row.remove();
                    showNotification('Produto excluído com sucesso!', 'success');
                }, 500);
            }
        });
    });

    // Submit do formulário
    document.getElementById('product-form').addEventListener('submit', function(e) {
        e.preventDefault();
        modal.classList.remove('active');
        showNotification('Produto salvo com sucesso!', 'success');
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

    // Exportar produtos
    document.getElementById('export-products').addEventListener('click', function() {
        this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Exportando...';
        setTimeout(() => {
            this.innerHTML = '<i class="fas fa-download"></i> Exportar';
            showNotification('Produtos exportados com sucesso!', 'success');
        }, 1500);
    });
</script>
</body>
</html>