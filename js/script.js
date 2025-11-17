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

        // Base de produtos usada pela busca (padronizada conforme produtos.php)
        const allProducts = [
            // Produtos do index.php
            {
                name: "Camisa Susanoo - Preta",
                price: "109.99",
                img: "assets/img/costafoto.png",
                imgs: "../assets/img/camisajpnsred.png|../assets/img/camisajpnsredback.png|../assets/img/camisajpnsreddetailbeside.png|../assets/img/camisajpnsreddetail.png",
                sizes: "P|M|G|GG|XG",
                longdesc: "Camisa Susanoo Preta: Estilo e cultura japonesa, algodão premium, modelagem confortável.",
                category: "camisas"
            },
            {
                name: "Calça Baggy Susanoo Cinza",
                price: "67.99",
                img: "assets/img/calca.png",
                imgs: "../assets/img/calca.png|../assets/img/calcadetail.png|../assets/img/calcadetail2.png",
                sizes: "P|M|G|GG|XG",
                longdesc: "Calça Baggy Susanoo Cinza: Cor discreta, estilo que destaca, tecido leve e resistente.",
                category: "calcas"
            },
            {
                name: "Boné Amaterasu",
                price: "39.90",
                img: "assets/img/bone.png",
                imgs: "../assets/img/boneoldschool.png|../assets/img/boneoldschool2.png|../assets/img/boneoldschool3.png",
                sizes: "Único",
                longdesc: "Boné Amaterasu: Aba curva, bordado exclusivo, ajuste confortável, inspiração japonesa.",
                category: "acessorios"
            },
            // Produtos do produtos.php
            {
                name: "Camisa Brazil",
                price: "99.90",
                img: "assets/img/camisabr.png",
                imgs: "assets/img/camisabrazil.png|assets/img/camisabrazilback.png",
                sizes: "P|M|G|GG|XG",
                longdesc: "Camisa Brazil: Confeccionada em algodão premium, acabamento reforçado nas costuras, modelagem regular que se adapta ao corpo. Ideal para uso diário, possui estampas inspiradas na cultura oriental e tratamento anti-pilling.",
                category: "camisas"
            },
            {
                name: "Camisa Sopro",
                price: "99.90",
                img: "assets/img/sopro.png",
                imgs: "assets/img/sopros.png|assets/img/sopro2.png",
                sizes: "P|M|G|GG|XG",
                longdesc: "Camisa Sopro: Tecido leve com toque seco, estampa serigráfica resistente, gola reforçada. Inspirada no vento, design minimalista com caimento fluido.",
                category: "camisas"
            },
            {
                name: "Moletom Sakura",
                price: "249.90",
                img: "assets/img/moletommarrom.png",
                imgs: "assets/img/moletommarrom.png|assets/img/moletommarrom_2.png",
                sizes: "P|M|G|GG|XG",
                longdesc: "Moletom Sakura: Interior felpado, capuz com ajuste, bolsos canguru. Estampa temática de cerejeira com tintas ecológicas, ideal para baixas temperaturas.",
                category: "moletons"
            },
            {
                name: "Moletom Susanoo",
                price: "279.90",
                img: "assets/img/moletombege.png",
                imgs: "assets/img/moletombege1.png|assets/img/moletombege2.png",
                sizes: "P|M|G|GG|XG",
                longdesc: "Moletom Susanoo: Corte urbano, logo bordado, material durável e resistente a lavagens. Perfeito para compor looks casuais.",
                category: "moletons"
            },
            {
                name: "Jorts Hakama",
                price: "199.90",
                img: "assets/img/jortscinza.png",
                imgs: "assets/img/jortscinza.png|assets/img/jortscinza_back.png",
                sizes: "P|M|G|GG|XG",
                longdesc: "Jorts Hakama: Calça com corte inspirado em hakama, bolsos reforçados, tecido com elasticidade leve para conforto. Ideal para looks modernos.",
                category: "calcas"
            },
            {
                name: "Calça Cargo",
                price: "169.90",
                img: "assets/img/calcamodelofem.png",
                imgs: "assets/img/calcamodelofem.png|assets/img/calcamodelofem_2.png",
                sizes: "P|M|G|GG|XG",
                longdesc: "Calça Cargo: Vários bolsos utilitários, cordão interno na cintura, acabamento resistente. Perfeita para uso urbano e funcional.",
                category: "calcas"
            },
            {
                name: "Boné AMATERASU",
                price: "69.90",
                img: "assets/img/bonebarra.png",
                imgs: "assets/img/bonebarra.png|assets/img/bone.png",
                sizes: "Único",
                longdesc: "Boné AMATERASU: Tecido respirável com aba estruturada e bordado exclusivo. Ajuste traseiro e detalhe interno antissuor.",
                category: "acessorios"
            },
            {
                name: "Bandana Oriental",
                price: "39.90",
                img: "assets/img/chaveiro.png",
                imgs: "assets/img/chaveiro.png|assets/img/yeah.png",
                sizes: "Único",
                longdesc: "Chaveiro/Acc: Material metálico com banho resistente, detalhe temático e embalagem presenteável.",
                category: "acessorios"
            }
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

    // --- LÓGICA DO MODAL DA TABELA DE TAMANHOS ---
    const openSizeChartButton = document.getElementById('openSizeChart');
    const closeSizeChartButton = document.getElementById('closeSizeChart');
    const sizeChartModal = document.getElementById('sizeChartModal');
    const shirtSizeChart = document.getElementById('shirtSizeChart');
    const pantsSizeChart = document.getElementById('pantsSizeChart');

    if (openSizeChartButton && closeSizeChartButton && sizeChartModal) {
        openSizeChartButton.addEventListener('click', () => {
            const productCategory = document.querySelector('input[name="product_category"]').value;
            if (productCategory === 'camisas') {
                shirtSizeChart.style.display = 'table';
                pantsSizeChart.style.display = 'none';
            } else if (productCategory === 'calcas') {
                shirtSizeChart.style.display = 'none';
                pantsSizeChart.style.display = 'table';
            } else {
                shirtSizeChart.style.display = 'none';
                pantsSizeChart.style.display = 'none';
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