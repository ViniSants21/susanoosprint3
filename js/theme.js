// =================================== //
//    LÓGICA DO TEMA CLARO/ESCURO      //
// =================================== //

document.addEventListener('DOMContentLoaded', () => {
    const themeToggle = document.querySelector('.theme-switch input[type="checkbox"]');

    // Se o toggle não estiver na página, não faz nada
    if (!themeToggle) {
        return;
    }

    // Função que aplica o tema no HTML e salva no localStorage
    function applyTheme(isLight) {
        document.documentElement.classList.toggle('light-mode', isLight);
        localStorage.setItem('theme', isLight ? 'light' : 'dark');
    }

    // Verifica o tema salvo e ajusta o toggle
    const savedTheme = localStorage.getItem('theme');
    if (savedTheme === 'light') {
        themeToggle.checked = true;
    }

    // Adiciona o evento de clique no toggle
    themeToggle.addEventListener('change', () => {
        applyTheme(themeToggle.checked);
    });
});