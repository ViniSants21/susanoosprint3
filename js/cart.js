// ================================================= //
//        LÓGICA DO CARRINHO DE COMPRAS - SUSANOO     //
// ================================================= //

// Função para pegar o carrinho do localStorage
function getCart() {
    return JSON.parse(localStorage.getItem('susanooCart')) || [];
}

// Função para salvar o carrinho no localStorage
function saveCart(cart) {
    localStorage.setItem('susanooCart', JSON.stringify(cart));
}

// Função para adicionar um produto ao carrinho
function addToCart(productData) {
    const cart = getCart();
    
    // Criamos um ID único para o item (produto + tamanho)
    const itemId = productData.id + '-' + productData.size;

    // Verificamos se o item já existe no carrinho
    const existingItem = cart.find(item => item.id === itemId);

    if (existingItem) {
        // Se existe, apenas aumenta a quantidade
        existingItem.quantity += 1;
    } else {
        // Se não existe, adiciona o novo item
        cart.push({
            id: itemId,
            name: productData.name,
            price: productData.price,
            image: productData.image,
            size: productData.size,
            category: productData.category,
            quantity: 1
        });
    }

    saveCart(cart);
    updateCartIcon(); // Atualiza o contador no ícone da navbar
}

// Função para atualizar o contador de itens no ícone do carrinho
function updateCartIcon() {
    const cart = getCart();
    const totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);
    
    // Procuramos por um contador. Se não existir, criamos um.
    const iconLink = document.querySelector('a[href*="carrinho.php"]');
    if (!iconLink) return;

    let countElement = iconLink.querySelector('.cart-item-count');
    if (!countElement) {
        countElement = document.createElement('span');
        countElement.className = 'cart-item-count';
        iconLink.appendChild(countElement);
        iconLink.style.position = 'relative'; // Necessário para o posicionamento do contador
    }

    if (totalItems > 0) {
        countElement.textContent = totalItems;
        countElement.style.display = 'flex';
    } else {
        countElement.style.display = 'none';
    }
}

// Adiciona o CSS para o contador do ícone
document.addEventListener('DOMContentLoaded', () => {
    const style = document.createElement('style');
    style.textContent = `
        .cart-item-count {
            position: absolute;
            top: -5px;
            right: -10px;
            background-color: var(--primary-purple, #8B5CF6);
            color: white;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            font-size: 12px;
            font-weight: bold;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid var(--dark-bg, #000);
        }
    `;
    document.head.appendChild(style);
    updateCartIcon(); // Chama a função assim que a página carrega
});