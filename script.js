// Seleciona o botão e a lista de links
const botao = document.getElementById('btn-menu');
const lista = document.getElementById('menu-lista');

// Adiciona o evento de clique
botao.addEventListener('click', function() {
    lista.classList.toggle('menu-ativo');
    console.log("Interação de menu executada com sucesso!");
});