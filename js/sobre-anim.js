document.addEventListener("DOMContentLoaded", function() {

    // --- Animação geral de elementos ao rolar ---
    const animatedElements = document.querySelectorAll('.animate-on-scroll');

    if (animatedElements.length > 0) {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                    // Não vamos parar de observar para caso a animação precise ser reativada
                }
            });
        }, {
            threshold: 0.2 // Ativa a animação quando 20% do elemento estiver visível
        });

        animatedElements.forEach(el => {
            observer.observe(el);
        });
    }

    // --- Animação específica para a linha do tempo ---
    const timeline = document.querySelector('.history-timeline');

    if (timeline) {
        const timelineObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    // Adiciona a classe que dispara a animação CSS de "desenho" da linha
                    entry.target.classList.add('draw');
                    // Para de observar depois que a animação foi ativada uma vez
                    timelineObserver.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.25 // Começa a desenhar quando 25% da seção da linha do tempo estiver visível
        });

        timelineObserver.observe(timeline);
    }
});