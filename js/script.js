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
            // Lógica para o menu mobile. Você precisará de CSS para a classe 'active'
            hamburger.classList.toggle('active');
            navMenuContainer.classList.toggle('active'); 
        });
    }

    // --- LÓGICA DOS FILTROS (PÁGINA DE PRODUTOS) ---
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

    // --- FUNCIONALIDADE DA BARRA DE PESQUISA (VERSÃO FINAL E CORRIGIDA) ---
    const searchInput = document.querySelector('.nav-search input');
    const productsGrid = document.querySelector('.products-grid');
    
    if (searchInput) {
        const isIndexPage = document.body.classList.contains('home');
    
        // Se estamos na página de produtos (e não na home que também tem products-grid)
        if (productsGrid && !isIndexPage) {
            const allProductCards = Array.from(productsGrid.querySelectorAll('.product-card'));
            searchInput.addEventListener('input', () => {
                const searchTerm = searchInput.value.toLowerCase().trim();
                allProductCards.forEach(card => {
                    const productName = card.querySelector('h3').textContent.toLowerCase();
                    card.style.display = productName.includes(searchTerm) ? 'block' : 'none';
                });
            });
        } 
        // Se estamos em QUALQUER outra página (incluindo a home), usamos o dropdown
        else {
            const dropdown = document.createElement('div');
            dropdown.className = 'search-results-dropdown';
            searchInput.parentElement.appendChild(dropdown);
    
            // A base de dados agora tem caminhos RELATIVOS À RAIZ
            const allProducts = [
                { name: 'Camisa Susanoo - Branca', img: 'assets/img/costafoto.png', url: 'php/produto_detalhes.php?name=Camisa+Susanoo+-+Branca' },
                { name: 'Calça Baggy Susanoo Cinza', img: 'assets/img/calca.png', url: 'php/produto_detalhes.php?name=Calça+Baggy+Susanoo+Cinza' },
                { name: 'Acessórios', img: 'assets/img/bone.png', url: 'php/produto_detalhes.php?name=Acessórios' },
                { name: 'Camisa Brazil', img: 'assets/img/camisabr.png', url: 'php/produto_detalhes.php?name=Camisa+Brazil' },
                { name: 'Camisa Sopro', img: 'assets/img/sopro.png', url: 'php/produto_detalhes.php?name=Camisa+Sopro' },
                { name: 'Moletom Sakura', img: 'assets/img/moletommarrom.png', url: 'php/produto_detalhes.php?name=Moletom+Sakura' },
                { name: 'Boné AMATERASU', img: 'assets/img/bonebarra.png', url: 'php/produto_detalhes.php?name=Boné+AMATERASU' },
                // ADICIONE TODOS OS SEUS PRODUTOS AQUI
            ];
    
            searchInput.addEventListener('input', () => {
                const searchTerm = searchInput.value.toLowerCase().trim();
                dropdown.innerHTML = '';
                if (searchTerm.length < 2) {
                    dropdown.classList.remove('visible');
                    return;
                }
                const results = allProducts.filter(p => p.name.toLowerCase().includes(searchTerm));
                if (results.length > 0) {
                    const list = document.createElement('ul');
                    list.className = 'search-results-list';
                    results.forEach(item => {
                        const prefix = isIndexPage ? '' : '../';
                        list.innerHTML += `
                            <li class="search-result-item">
                                <a href="${prefix}${item.url}">
                                    <img src="${prefix}${item.img}" alt="${item.name}" class="search-result-img">
                                    <span class="search-result-name">${item.name}</span>
                                </a>
                            </li>
                        `;
                    });
                    dropdown.appendChild(list);
                } else {
                    dropdown.innerHTML = '<p class="no-results-message">Nenhum produto encontrado.</p>';
                }
                dropdown.classList.add('visible');
            });
    
            document.addEventListener('click', (e) => {
                if (!searchInput.parentElement.contains(e.target)) {
                    dropdown.classList.remove('visible');
                }
            });
        }
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
});