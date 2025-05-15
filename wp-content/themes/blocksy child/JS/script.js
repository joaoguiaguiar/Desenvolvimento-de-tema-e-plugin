function toggleMenu() {
    const lista = document.querySelector('.container__lista');
    lista.classList.toggle('active'); // Alterna a classe 'active'
}

// Seleciona o botão 
const menuButton = document.querySelector('#menu-toggle');

// Adiciona o evento de clique ao botão
menuButton.addEventListener('click', toggleMenu);
