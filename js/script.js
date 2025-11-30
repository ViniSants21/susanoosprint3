// ========================================================== //
//          JAVASCRIPT UNIFICADO FINAL - SUSANOO              //
// ========================================================== //

document.addEventListener('DOMContentLoaded', function() {
    
    // --- LÓGICA DA NAVBAR (SCROLL E MOBILE) ---
    const navbar = document.getElementById('navbar');
    if (navbar) {
        const handleScroll = () => {
            const isHome = document.body.classList.contains('home');
            if (!isHome || window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        };
        window.addEventListener('scroll', handleScroll);
        handleScroll(); // Verifica no carregamento
    }
    const hamburger = document.getElementById('hamburger');
    const navMenuContainer = document.querySelector('.nav-right-group');
    if (hamburger && navMenuContainer) {
        hamburger.addEventListener('click', function() {
            hamburger.classList.toggle('active');
            navMenuContainer.classList.toggle('active'); 
        });
    }

    // --- LÓGICA DOS FILTROS (BOTÕES DA PÁGINA DE PRODUTOS) ---
    const filterButtons = document.querySelectorAll('.filter-btn');
    const productCardsForFilter = document.querySelectorAll('.products-grid .product-card');
    if (filterButtons.length > 0) {
        filterButtons.forEach(btn => {
            btn.addEventListener('click', function() {
                document.querySelector('.filter-btn.active')?.classList.remove('active');
                this.classList.add('active');
                const filter = this.dataset.filter;
                productCardsForFilter.forEach(card => {
                    card.style.display = (filter === 'all' || card.dataset.category === filter) ? 'block' : 'none';
                });
            });
        });
    }

    // --- DELEGAÇÃO DE EVENTOS PARA OS CARDS DE PRODUTO (Ver Detalhes e Add Carrinho) ---
    document.body.addEventListener('click', function(e) {
        const quickViewButton = e.target.closest('.btn-quick-view');
        const addToCartButton = e.target.closest('.btn-add-cart');

        if (quickViewButton) {
            const card = quickViewButton.closest('.product-card');
            if (!card) return;
            const params = new URLSearchParams();
            for (const key in card.dataset) { params.set(key, card.dataset[key]); }
            params.set('desc', card.querySelector('.product-desc')?.textContent.trim() || '');
            params.set('price', card.querySelector('.price')?.textContent.trim() || '');
            const isIndex = document.body.classList.contains('home');
            const path = isIndex ? 'php/produto_detalhes.php' : 'produto_detalhes.php';
            window.location.href = path + '?' + params.toString();
        }

        if (addToCartButton) {
            const card = addToCartButton.closest('.product-card');
            if (!card) return;
            const sizes = card.dataset.sizes || '';
            if (sizes.includes('|')) {
                card.querySelector('.btn-quick-view')?.click();
                return;
            }
            const productData = {
                id: (card.dataset.name + '-único').replace(/\s+/g, '-').toLowerCase(),
                name: card.dataset.name, price: parseFloat(card.dataset.price),
                image: card.dataset.img, size: 'Único', category: card.dataset.category
            };
            if (typeof addToCart === 'function') {
                addToCart(productData);
                const originalText = addToCartButton.textContent;
                addToCartButton.textContent = 'Adicionado!';
                addToCartButton.style.background = '#10B981';
                setTimeout(() => {
                    addToCartButton.textContent = originalText;
                    addToCartButton.style.background = '';
                }, 2000);
            } else { console.error("Função addToCart não encontrada."); }
        }
    });

    // --- FUNCIONALIDADE DA BARRA DE PESQUISA (MODO BANCO DE DADOS) ---
    const searchInput = document.querySelector('.nav-search input');
    const productsGrid = document.querySelector('.products-grid');

    if (searchInput) {
        // Normaliza texto (remove acentos e põe em minúsculo)
        function normalizeString(str) {
            return str.normalize('NFD').replace(/[\u0300-\u036f]/g, '').toLowerCase();
        }

        // Se estivermos na página de produtos, permitimos um filtro visual rápido
        // enquanto o usuário digita. Mas o "Enter" enviará o formulário para o PHP.
        if (productsGrid) {
            const allProductCards = Array.from(productsGrid.querySelectorAll('.product-card'));
            
            searchInput.addEventListener('input', () => {
                const searchTerm = normalizeString(searchInput.value.trim());
                
                // Se a caixa estiver vazia, mostra tudo que foi carregado pelo PHP
                if (searchTerm === '') {
                    allProductCards.forEach(card => card.style.display = 'block');
                    return;
                }

                // Filtro visual instantâneo (sem recarregar)
                allProductCards.forEach(card => {
                    const productName = normalizeString(card.querySelector('h3')?.textContent || '');
                    const productDesc = normalizeString(card.querySelector('.product-desc')?.textContent || '');
                    
                    if (productName.includes(searchTerm) || productDesc.includes(searchTerm)) {
                        card.style.display = 'block';
                    } else {
                        card.style.display = 'none';
                    }
                });
            });
        }

        // NÃO bloqueamos o "Enter" nem o clique no botão.
        // O formulário HTML (configurado no index.php/produtos.php) fará o envio GET para o servidor.
    }

    // --- OUTRAS FUNCIONALIDADES (Back to Top) ---
    const backToTopButton = document.getElementById('backToTop');
    if (backToTopButton) {
        window.addEventListener('scroll', () => {
            backToTopButton.classList.toggle('visible', window.scrollY > 300);
        });
        backToTopButton.addEventListener('click', () => {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    }
    
    // Console easter egg
    console.log("Susanoo Site Loaded Successfully!");

    // --- LÓGICA DO MODAL DA TABELA DE TAMANHOS ---
    const openSizeChartButton = document.getElementById('openSizeChart');
    const closeSizeChartButton = document.getElementById('closeSizeChart');
    const sizeChartModal = document.getElementById('sizeChartModal');
    const shirtSizeChart = document.getElementById('shirtSizeChart');
    const pantsSizeChart = document.getElementById('pantsSizeChart');

    if (openSizeChartButton && closeSizeChartButton && sizeChartModal) {
        openSizeChartButton.addEventListener('click', () => {
            // Verifica se existe o input de categoria na página de detalhes
            const categoryInput = document.querySelector('input[name="product_category"]');
            const productCategory = categoryInput ? categoryInput.value : '';

            if (productCategory === 'camisas' || productCategory.includes('camisa')) {
                if(shirtSizeChart) shirtSizeChart.style.display = 'table';
                if(pantsSizeChart) pantsSizeChart.style.display = 'none';
            } else if (productCategory === 'calcas' || productCategory.includes('calca')) {
                if(shirtSizeChart) shirtSizeChart.style.display = 'none';
                if(pantsSizeChart) pantsSizeChart.style.display = 'table';
            } else {
                // Padrão se não identificar
                if(shirtSizeChart) shirtSizeChart.style.display = 'table';
                if(pantsSizeChart) pantsSizeChart.style.display = 'none';
            }
            sizeChartModal.classList.add('visible');
        });

        closeSizeChartButton.addEventListener('click', () => {
            sizeChartModal.classList.remove('visible');
        });

        window.addEventListener('click', (e) => {
            if (e.target === sizeChartModal) {
                sizeChartModal.classList.remove('visible');
            }
        });
    }
});