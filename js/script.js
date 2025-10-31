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
    let searchButton = document.querySelector('.nav-search .nav-search-btn');
    const productsGrid = document.querySelector('.products-grid');

    if (searchInput) {
        const isIndexPage = document.body.classList.contains('home');

        // Garante que exista um botão de lupa ao lado do input (cria se não houver)
        if (!searchButton) {
            const btn = document.createElement('button');
            btn.type = 'button';
            btn.className = 'nav-search-btn';
            btn.setAttribute('aria-label', 'Pesquisar');
            btn.innerHTML = '<i class="fas fa-search"></i>';
            searchInput.parentElement.appendChild(btn);
            searchButton = btn;
        }

        // Função de normalização para comparações (remove acentos)
        function normalizeString(str) {
            return str.normalize('NFD').replace(/[\u0300-\u036f]/g, '').toLowerCase();
        }

        // Base de produtos usada pela busca (expanda conforme necessário)
        const allProducts = [
            // index.php / featured
            { name: 'Camisa Susanoo - Branca', price: '299.90', img: 'assets/img/costafoto.png', imgs: 'assets/img/costafoto.png', sizes: 'P|M|G|GG', longdesc: 'Uma camisa branca elegante com detalhes da cultura japonesa, perfeita para qualquer ocasião.', category: 'camisas' },
            { name: 'Calça Baggy Susanoo Cinza', price: '199.90', img: 'assets/img/calca.png', imgs: 'assets/img/calca.png', sizes: '38|40|42|44', longdesc: 'Calça baggy confortável e estilosa.', category: 'calcas' },
            { name: 'Acessórios', price: '39.90', img: 'assets/img/bone.png', imgs: 'assets/img/bone.png', sizes: 'Único', longdesc: 'Coleção de acessórios inspirados na cerimônia tradicional japonesa.', category: 'acessorios' },

            // colecao_sublime
            { name: 'Camisa Polo - COLLECTION SUBLIME', price: '149.90', img: 'assets/img/Camisa Polo Susanoo (1).png', imgs: 'assets/img/Camisa Polo Susanoo (1).png', sizes: 'P|M|G|GG', longdesc: 'Minimalista e refinada.', category: 'sublime' },
            { name: 'Camisa Polo Preta - COLLECTION SUBLIME', price: '159.90', img: 'assets/img/Camisa Polo Susanoo(Preta).png', imgs: 'assets/img/Camisa Polo Susanoo(Preta).png', sizes: 'P|M|G|GG', longdesc: 'Minimalista e refinada.', category: 'sublime' },
            { name: 'Camisa Polo Off-White - COLLECTION SUBLIME', price: '149.90', img: 'assets/img/Camisa Off-White SUBLIME.png', imgs: 'assets/img/Camisa Off-White SUBLIME.png', sizes: 'P|M|G|GG', longdesc: 'Minimalista e refinada.', category: 'sublime' },
            { name: 'Camisa Polo Branca - COLLECTION SUBLIME', price: '129.90', img: 'assets/img/Camisa Branca SUBLIME.png', imgs: 'assets/img/Camisa Branca SUBLIME.png', sizes: 'P|M|G|GG', longdesc: 'Minimalista e refinada.', category: 'sublime' },
            { name: 'Camisa Polo Marrom - COLLECTION SUBLIME', price: '149.90', img: 'assets/img/Camisa Marrom SUBLIME.png', imgs: 'assets/img/Camisa Marrom SUBLIME.png', sizes: 'P|M|G|GG', longdesc: 'Minimalista e refinada.', category: 'sublime' },
            { name: 'Camisa Polo Rosa - COLLECTION SUBLIME', price: '129.90', img: 'assets/img/Camisa Rosa SUBLIME.png', imgs: 'assets/img/Camisa Rosa SUBLIME.png', sizes: 'P|M|G|GG', longdesc: 'Minimalista e refinada.', category: 'sublime' },

            // colecao_essencial
            { name: 'Camiseta Essentials Susanoo Preta', price: '109.90', img: 'assets/img/Camisapreta_essentials (1).png', imgs: 'assets/img/Camisapreta_essentials (1).png', sizes: 'P|M|G|GG', longdesc: 'Camiseta da coleção Essentials.', category: 'essencial' },
            { name: 'Camiseta Essentials Susanoo Branca', price: '109.90', img: 'assets/img/Camisapreta_essentials (2).png', imgs: 'assets/img/Camisapreta_essentials (2).png', sizes: 'P|M|G|GG', longdesc: 'Camiseta da coleção Essentials.', category: 'essencial' },
            { name: 'Camiseta Essentials Susanoo Roxa Escura', price: '109.90', img: 'assets/img/Camisapreta_essentials (3).png', imgs: 'assets/img/Camisapreta_essentials (3).png', sizes: 'P|M|G|GG', longdesc: 'Camiseta da coleção Essentials.', category: 'essencial' },
            { name: 'Moletom Essentials Susanoo Preto', price: '149.90', img: 'assets/img/Moletom_preto.jpeg', imgs: 'assets/img/Moletom_preto.jpeg', sizes: 'P|M|G|GG', longdesc: 'Moletom Essentials preto.', category: 'essencial' },
            { name: 'Moletom Essentials Susanoo Branco', price: '149.90', img: 'assets/img/Moletom_branco.jpeg', imgs: 'assets/img/Moletom_branco.jpeg', sizes: 'P|M|G|GG', longdesc: 'Moletom Essentials branco.', category: 'essencial' },
            { name: 'Moletom Essentials Susanoo Roxa Escura', price: '150.90', img: 'assets/img/Moletom_roxa.jpeg', imgs: 'assets/img/Moletom_roxa.jpeg', sizes: 'P|M|G|GG', longdesc: 'Moletom Essentials roxa escura.', category: 'essencial' },

            // outros exemplos observados
            { name: 'Camisa Brazil', price: '129.90', img: 'assets/img/camisabr.png', imgs: 'assets/img/camisabr.png', sizes: 'P|M|G|GG', longdesc: 'Camisa Brazil.', category: 'camisas' },
            { name: 'Camisa Sopro', price: '119.90', img: 'assets/img/sopro.png', imgs: 'assets/img/sopro.png', sizes: 'P|M|G|GG', longdesc: 'Camisa Sopro.', category: 'camisas' },
            { name: 'Moletom Sakura', price: '199.90', img: 'assets/img/moletommarrom.png', imgs: 'assets/img/moletommarrom.png', sizes: 'P|M|G|GG', longdesc: 'Moletom Sakura.', category: 'moletom' },
            { name: 'Boné AMATERASU', price: '59.90', img: 'assets/img/bonebarra.png', imgs: 'assets/img/bonebarra.png', sizes: 'Único', longdesc: 'Boné AMATERASU.', category: 'acessorios' },
            // ADICIONE mais produtos aqui conforme necessário
        ];

        function buildProductUrl(product, isIndex) {
            const params = new URLSearchParams();

            // name e price no mesmo formato textual que aparecem nos cards (ex: "R$ 99,90")
            params.set('name', product.name);
            // se product.price já vier como string formatada (com "R$") evita duplicar
            const priceText = String(product.price).includes('R$') ? String(product.price) : ('R$ ' + String(product.price).replace('.', ','));
            params.set('price', priceText);

            // produto_detalhes.php fica dentro da pasta php,
            // então os parâmetros de imagem devem apontar para ../assets/...
            const toParamPath = (p) => {
                if (!p) return '';
                const cleaned = String(p).replace(/^(\.\/|\/)/, '').replace(/^\.\.\//, '');
                return '../' + cleaned; // sempre relativo ao arquivo php/produto_detalhes.php
            };

            // img principal
            if (product.img) params.set('img', toParamPath(product.img));

            // imgs (lista) -> manter mesmo separador '|' usado nos data-attributes
            if (product.imgs) {
                const imgsArr = String(product.imgs).split('|').map(i => toParamPath(i));
                params.set('imgs', imgsArr.join('|'));
            }

            // tamanhos
            if (product.sizes) params.set('sizes', product.sizes);

            // desc (curta) deve existir — quickView usa .product-desc do card
            // permitimos product.desc (curta) ou geramos a partir de longdesc (primeira linha)
            if (product.desc) {
                params.set('desc', product.desc);
            } else if (product.longdesc) {
                // usa primeira frase/linha como resumo curto
                const short = String(product.longdesc).split(/[\.\n]/).filter(Boolean)[0] || product.longdesc;
                params.set('desc', short);
            }

            // longdesc (completa) — quickView não passa longdesc, mas incluir não remove compatibilidade
            if (product.longdesc) params.set('longdesc', product.longdesc);

            if (product.category) params.set('category', product.category);

            const target = isIndex ? 'php/produto_detalhes.php' : 'produto_detalhes.php';
            return target + '?' + params.toString();
        }

        // dropdown para resultados
        const dropdown = document.createElement('div');
        dropdown.className = 'search-results-dropdown';
        searchInput.parentElement.appendChild(dropdown);

        function renderDropdown(results) {
            dropdown.innerHTML = '';
            if (!results || results.length === 0) {
                dropdown.innerHTML = '<p class="no-results-message">Nenhum produto encontrado.</p>';
                dropdown.classList.add('visible');
                return;
            }
            const list = document.createElement('ul');
            list.className = 'search-results-list';
            results.forEach(p => {
                const href = buildProductUrl(p, isIndexPage);
                // thumbnail src deve ser relativo à página atual:
                const thumbSrc = isIndexPage ? p.img : ('../' + p.img.replace(/^(\.\/|\/)/, ''));
                list.innerHTML += `
                    <li class="search-result-item">
                        <a href="${href}">
                            <img src="${thumbSrc}" alt="${p.name}" class="search-result-img">
                            <span class="search-result-name">${p.name}</span>
                        </a>
                    </li>
                `;
            });
            dropdown.appendChild(list);
            dropdown.classList.add('visible');
        }

        // Pesquisa conforme digitação — usa allProducts global
        searchInput.addEventListener('input', () => {
            const term = normalizeString(searchInput.value.trim());
            dropdown.innerHTML = '';
            if (term.length < 2) {
                dropdown.classList.remove('visible');
                return;
            }
            // Prioriza correspondências que começam com o termo, depois que contêm
            const starts = allProducts.filter(p => normalizeString(p.name).startsWith(term));
            const contains = allProducts.filter(p => normalizeString(p.name).includes(term) && !normalizeString(p.name).startsWith(term));
            const results = starts.concat(contains);
            renderDropdown(results);
        });

        // Fecha dropdown ao clicar fora
        document.addEventListener('click', (e) => {
            if (!searchInput.parentElement.contains(e.target)) {
                dropdown.classList.remove('visible');
            }
        });

        // Função que busca melhor produto e redireciona
        function searchAndRedirect() {
            const term = normalizeString(searchInput.value.trim());
            if (!term) return;
            // Se dropdown visível e tiver link, segue o primeiro
            const firstLink = dropdown.querySelector('a');
            if (dropdown.classList.contains('visible') && firstLink) {
                window.location.href = firstLink.href;
                return;
            }
            // Procura correspondência exata
            let found = allProducts.find(p => normalizeString(p.name) === term);
            if (!found) found = allProducts.find(p => normalizeString(p.name).includes(term));
            if (found) {
                window.location.href = buildProductUrl(found, isIndexPage);
            } else {
                alert('Produto não encontrado.');
            }
        }

        // Clique no botão da lupa
        searchButton.addEventListener('click', (e) => {
            e.preventDefault();
            searchAndRedirect();
        });

        // Enter no input também executa a pesquisa
        searchInput.addEventListener('keydown', (e) => {
            if (e.key === 'Enter') {
                e.preventDefault();
                searchAndRedirect();
            }
        });

        // Se estivermos na página de produtos com grid, mantemos o filtro visual local
        if (productsGrid && !isIndexPage) {
            const allProductCards = Array.from(productsGrid.querySelectorAll('.product-card'));
            searchInput.addEventListener('input', () => {
                const searchTerm = normalizeString(searchInput.value.toLowerCase().trim());
                allProductCards.forEach(card => {
                    const productName = normalizeString(card.querySelector('h3')?.textContent || '');
                    card.style.display = productName.includes(searchTerm) ? 'block' : 'none';
                });
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