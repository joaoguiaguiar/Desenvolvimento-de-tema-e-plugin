function toggleMenu() {
    const lista = document.querySelector('.container__lista');
    lista.classList.toggle('active'); // Alterna a classe 'active'
}

// Seleciona o botão (ajuste o seletor conforme o seu HTML)
const menuButton = document.querySelector('#menu-toggle'); // Exemplo de seletor para o botão

// Adiciona o evento de clique ao botão
menuButton.addEventListener('click', toggleMenu);
