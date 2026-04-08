// ==========================================
// controller.js - Regra de Negócio e Tela
// ==========================================

// Seleciona o formulário da página de Perfil
const formPerfil = document.querySelector('.formulario-avancado');

// Só executa se o formulário existir na página atual
if (formPerfil) {
    formPerfil.addEventListener('submit', async (event) => {
        event.preventDefault(); // Impede a página de recarregar

        // 1. Captura os dados da tela
        const nascimento = document.getElementById('nascimento').value;
        const objetivoElemento = document.querySelector('input[name="obj"]:checked');
        const objetivo = objetivoElemento ? objetivoElemento.parentNode.textContent.trim() : 'Não informado';
        const bio = document.getElementById('bio').value;

        // 2. Monta o objeto
        const dadosPerfil = {
            dataNascimento: nascimento,
            objetivo: objetivo,
            biografia: bio,
            dataRegistro: new Date().toLocaleDateString()
        };

        try {
            // 3. Salva no IndexedDB usando a função global do db.js
            const mensagem = await adicionarItem(dadosPerfil);
            console.log(mensagem);
            alert("Dados biométricos salvos com sucesso no navegador!");

            // Limpa o formulário
            formPerfil.reset();

            // 4. Lista os dados no console para confirmar
            listarDados();

        } catch (erro) {
            console.error("Falha ao salvar dados:", erro);
        }
    });
}

// Função para buscar e exibir os dados no Console
async function listarDados() {
    try {
        const dados = await buscarItens();
        console.log("=== DADOS SALVOS NO INDEXEDDB ===");
        console.table(dados); // Mostra os dados em formato de tabela no console
    } catch (erro) {
        console.error("Erro ao listar dados:", erro);
    }
}

// Inicializa o banco e lista os dados automaticamente ao carregar a página
document.addEventListener('DOMContentLoaded', async () => {
    await initDB();
    if (formPerfil) {
        listarDados();
    }
});

// ============================================================
// SISTEMA DE LOGIN E CADASTRO CAÓTICO (login.html)
// ============================================================

const sessaoLogin = document.getElementById('sessao-login');
const sessaoCadastro = document.getElementById('sessao-cadastro');

if (sessaoLogin && sessaoCadastro) {
    const btnAbaLogin = document.getElementById('aba-login');
    const btnAbaCadastro = document.getElementById('aba-cadastro');

    // 1. Controle das Abas
    btnAbaLogin.addEventListener('click', () => {
        sessaoLogin.style.display = 'block';
        sessaoCadastro.style.display = 'none';
        btnAbaLogin.style.backgroundColor = '#0077be';
        btnAbaCadastro.style.backgroundColor = '#555';
    });

    btnAbaCadastro.addEventListener('click', () => {
        sessaoLogin.style.display = 'none';
        sessaoCadastro.style.display = 'block';
        btnAbaLogin.style.backgroundColor = '#555';
        btnAbaCadastro.style.backgroundColor = '#28a745';
    });

    // 2. CAOS: Nome com "mEmE CaSe" automático
    const inputNomeCaos = document.getElementById('caos-nome');
    inputNomeCaos.addEventListener('input', (e) => {
        let texto = e.target.value.toLowerCase().split('');
        for (let i = 0; i < texto.length; i += 2) {
            texto[i] = texto[i].toUpperCase(); // Alterna as letras
        }
        e.target.value = texto.join('');
    });

    // 3. CAOS: Senha tremida visualmente
    const inputSenhaCaos = document.getElementById('caos-senha');
    inputSenhaCaos.addEventListener('input', (e) => {
        const margens = ['2px', '-2px', '4px', '-4px', '0px'];
        e.target.style.letterSpacing = margens[Math.floor(Math.random() * margens.length)];
    });

    // 4. CAOS: Botão Fujão (10 desvios)
    const btnSalvarCaos = document.getElementById('btn-salvar-caos');
    let fugas = 0;
    const provocacoes = ["Errou!", "Quase!", "Lento demais!", "Tenta aqui!", "Falta pouco!", "Ops!", "Zzz...", "Acorda!", "Mais uma!", "Parei!"];

    btnSalvarCaos.addEventListener('mouseover', function() {
        if (fugas < 10) {
            // Pula de forma aleatória no eixo X e Y
            const randomX = (Math.random() - 0.5) * 200; 
            const randomY = (Math.random() - 0.5) * 150 - 50; 
            
            this.style.transform = `translate(${randomX}px, ${randomY}px)`;
            this.textContent = provocacoes[fugas];
            fugas++;
        } else {
            // Fica bonzinho depois de 10 vezes
            this.style.transform = `translate(0px, 0px)`;
            this.style.backgroundColor = "#28a745";
            this.textContent = "Ufa! Pode clicar para salvar.";
        }
    });

    // 5. REGISTRAR CONTA (Salvar no DB)
    btnSalvarCaos.addEventListener('click', async () => {
        if (fugas < 10) return; // Evita que o usuário clique com o teclado antes da hora

        const nome = inputNomeCaos.value;
        const emailUser = document.getElementById('caos-email-user').value;
        const emailDominio = document.getElementById('caos-email-dominio').value;
        const senha = inputSenhaCaos.value;

        if (!nome || !emailUser || !senha) {
            alert("Preencha tudo se quiser sobreviver!");
            return;
        }

        if (!senha.toLowerCase().includes("agua")) {
            alert('REGRA VIOLADA: A senha precisa conter a palavra "agua" (ex: 123agua456)!');
            return;
        }

        const emailCompleto = `${emailUser}@${emailDominio}`;

        // Objeto que vai para o IndexedDB
        const novaConta = {
            tipo: "Conta_Autenticacao",
            nome: nome,
            email: emailCompleto,
            senha: senha,
            dataCriacao: new Date().toLocaleDateString()
        };

        try {
            await adicionarItem(novaConta);
            alert(`Sobrevivente registrado com sucesso!\nConta criada para: ${emailCompleto}\n\nVocê será levado ao Login.`);
            
            // Reseta a zoeira e o formulário
            document.getElementById('form-cadastro').reset();
            fugas = 0;
            btnSalvarCaos.style.backgroundColor = "#dc3545";
            btnSalvarCaos.textContent = "Tentar Criar Conta";
            
            // Volta para a aba de Login
            btnAbaLogin.click(); 
        } catch (erro) {
            console.error("Erro ao criar conta:", erro);
        }
    });

    // 6. LOGIN REAL (Verificar no DB)
    const formLogin = document.getElementById('form-login');
    formLogin.addEventListener('submit', async (event) => {
        event.preventDefault(); // Impede a página de recarregar
        
        const emailDigitado = document.getElementById('login-email').value;
        const senhaDigitada = document.getElementById('login-senha').value;

        try {
            // Puxa TODOS os dados do banco
            const dadosBanco = await buscarItens();
            
            // Filtra apenas os registros que são Contas de Usuário
            const contas = dadosBanco.filter(item => item.tipo === "Conta_Autenticacao");
            
            // Procura se existe algum usuário com o e-mail E senha idênticos
            const usuarioValido = contas.find(conta => conta.email === emailDigitado && conta.senha === senhaDigitada);

            if (usuarioValido) {
                alert(`Acesso Liberado! Bem-vindo(a), ${usuarioValido.nome}!`);
                window.location.href = "treino.html"; // Redireciona para o painel principal
            } else {
                alert("Acesso Negado! E-mail ou senha incorretos.\nSerá que você não precisa criar uma conta primeiro?");
            }

        } catch (erro) {
            console.error("Erro ao verificar credenciais:", erro);
        }
    });
}