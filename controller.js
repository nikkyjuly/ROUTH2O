// ============================================================
// SISTEMA DO PERFIL (perfil.html)
// ============================================================
const formPerfil = document.querySelector('.formulario-avancado');

if (formPerfil) {
    formPerfil.addEventListener('submit', async (event) => {
        event.preventDefault(); // Impede a página de recarregar

        const nascimento = document.getElementById('nascimento').value;
        const objetivoRadio = document.querySelector('input[name="obj"]:checked');
        
        // Pega o texto do objetivo com base no value do radio
        let objetivoTexto = 'Não informado';
        if (objetivoRadio) {
            objetivoTexto = objetivoRadio.value === '1' ? 'Emagrecer' : 'Ganho Muscular';
        }
        
        const bio = document.getElementById('bio').value;

        const registroPerfil = {
            tipo: "Perfil",
            dataNascimento: nascimento,
            objetivo: objetivoTexto,
            biografia: bio,
            dataRegistro: new Date().toLocaleDateString()
        };

        try {
            await adicionarItem(registroPerfil);
            alert("Alterações salvas com sucesso no banco de dados!");
            listarDados(); // Mostra no console
        } catch (erro) {
            console.error("Erro ao salvar perfil:", erro);
        }
    });
}

// Função utilitária para ver no console (Inspecionar Elemento)
async function listarDados() {
    try {
        const dados = await buscarItens();
        console.log("Dados atuais no IndexedDB:");
        console.table(dados);
    } catch (erro) {
        console.error("Erro ao listar dados:", erro);
    }
}

// ============================================================
// DESAFIO 3: UI/UX DO CAOS - DATA DE NASCIMENTO (atividade_dom.html)
// ============================================================
const sliderDia = document.getElementById('caos-dia');
const displayDia = document.getElementById('display-dia');
const selectMes = document.getElementById('caos-mes');
const inputAno = document.getElementById('caos-ano');
const btnAnoFujao = document.getElementById('btn-ano-fujao');
const btnSalvarDataCaos = document.getElementById('btn-salvar-caos');

// 1. Slider que não mostra o número em tempo real
if (sliderDia) {
    sliderDia.addEventListener('input', () => {
        displayDia.textContent = "Sorteando...";
    });
    sliderDia.addEventListener('change', (e) => {
        displayDia.textContent = e.target.value;
    });
}

// 2. Botão que foge do mouse (Event Listener: mouseover)
if (btnAnoFujao) {
    let fugasData = 0;
    btnAnoFujao.addEventListener('mouseover', function() {
        if (fugasData < 5) { // Foge 5 vezes
            const container = this.parentElement.parentElement;
            const maxX = container.clientWidth - this.clientWidth - 20;
            const maxY = container.clientHeight - this.clientHeight - 80;
            
            this.style.left = `${Math.random() * maxX}px`;
            this.style.top = `${Math.random() * maxY + 50}px`;
            fugasData++;
        } else {
            this.textContent = "Ok, desisto. Pode clicar.";
            this.style.backgroundColor = "#ff9800";
        }
    });

    btnAnoFujao.addEventListener('click', function() {
        inputAno.removeAttribute('readonly'); // Libera o campo
        inputAno.placeholder = "Digite o ano";
        inputAno.focus();
        this.style.display = 'none'; // Esconde o botão
    });
}

// 3. Salvar no IndexedDB (Persistência de Dados)
if (btnSalvarDataCaos) {
    // Verificamos se estamos na tela de atividade pelo botão de ano fujão
    if (btnAnoFujao) { 
        btnSalvarDataCaos.addEventListener('click', async () => {
            const dia = sliderDia.value;
            const mes = selectMes.value;
            const ano = inputAno.value;

            if (!ano || inputAno.hasAttribute('readonly')) {
                alert("Ei! Você precisa capturar o botão do ano primeiro!");
                return;
            }

            const dataCaotica = `${dia.padStart(2, '0')}/${mes}/${ano}`;
            
            const registroCaos = {
                tipo: "Atividade Caos",
                dataNascimento: dataCaotica,
                dataRegistro: new Date().toLocaleDateString()
            };

            try {
                const mensagem = await adicionarItem(registroCaos);
                console.log(mensagem);
                alert(`Sucesso! A data [ ${dataCaotica} ] foi salva no IndexedDB!`);
                listarDados(); 
            } catch (erro) {
                console.error("Erro ao salvar data caótica:", erro);
            }
        });
    }
}

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

    const btnSalvarContaCaos = document.getElementById('btn-salvar-caos');

    // 5. REGISTRAR CONTA (Salvar no DB)
    btnSalvarContaCaos.addEventListener('click', async () => {
        const nome = document.getElementById('caos-nome').value;
        const emailCompleto = document.getElementById('caos-email').value;
        const senha = document.getElementById('caos-senha').value;

        if (!nome || !emailCompleto || !senha) {
            alert("Por favor, preencha todos os campos.");
            return;
        }

        const novaConta = {
            tipo: "Conta_Autenticacao",
            nome: nome,
            email: emailCompleto,
            senha: senha,
            dataCriacao: new Date().toLocaleDateString()
        };

        try {
            await adicionarItem(novaConta);
            alert(`Conta criada com sucesso para: ${emailCompleto}`);
            
            document.getElementById('form-cadastro').reset();
            
            btnAbaLogin.click(); 
            listarDados(); // Mostra no console
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