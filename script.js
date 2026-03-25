// Seleciona o botão e a lista de links
const botao = document.getElementById('btn-menu');
const lista = document.getElementById('menu-lista');

// Adiciona o evento de clique
botao.addEventListener('click', function() {
    lista.classList.toggle('menu-ativo');
    console.log("Interação de menu executada com sucesso!");
});

// ============================================================
// ATIVIDADE DOM - CÁLCULO E INTERATIVIDADE
// ============================================================

// 1. Cálculo de Hidratação
const inputKm = document.querySelector('#km-input');
const btnCalcular = document.querySelector('#btn-calcular-hidratacao');
const outputResultado = document.querySelector('#resultado-hidratacao');

if (btnCalcular) {
    btnCalcular.addEventListener('click', function() {
        const km = parseFloat(inputKm.value);
        // Regra simples: 50ml por km (exemplo didático)
        const mlNecessarios = km * 100; 
        
        const mensagem = `Para ${km} km, sugerimos ingerir ${mlNecessarios} ml de água.`;
        
        // Exibe no console
        console.log(mensagem);
        // Exibe na tela
        outputResultado.textContent = mensagem;
    });
}

// 2. Dica Secreta
const btnDica = document.querySelector('#btn-dica');
const paragrafoDica = document.querySelector('#texto-dica');

if (btnDica) {
    btnDica.addEventListener('click', function() {
        // Altera o estilo diretamente via JS
        paragrafoDica.style.display = 'block';
    });
}

// 3. Controle de Treino (Página treino.html)
const btnIniciar = document.querySelector('#btn-iniciar');
const btnEncerrar = document.querySelector('#btn-encerrar');

if (btnIniciar) {
    btnIniciar.addEventListener('click', function() {
        alert("Treino INICIADO! O monitoramento de GPS foi ativado.");
        console.log("Status: Treino em andamento...");
    });
}

if (btnEncerrar) {
    btnEncerrar.addEventListener('click', function() {
        if(confirm("Deseja realmente encerrar o treino e salvar os dados?")) {
            alert("Treino finalizado com sucesso!");
            console.log("Status: Treino finalizado.");
        }
    });
}