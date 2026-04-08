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
    const btnSalvarContaCaos = document.getElementById('btn-salvar-caos');
    let fugasConta = 0;
    const provocacoes = ["Errou!", "Quase!", "Lento demais!", "Tenta aqui!", "Falta pouco!", "Ops!", "Zzz...", "Acorda!", "Mais uma!", "Parei!"];

    btnSalvarContaCaos.addEventListener('mouseover', function() {
        if (fugasConta < 10) {
            // Pula de forma aleatória no eixo X e Y
            const randomX = (Math.random() - 0.5) * 200; 
            const randomY = (Math.random() - 0.5) * 150 - 50; 
            
            this.style.transform = `translate(${randomX}px, ${randomY}px)`;
            this.textContent = provocacoes[fugasConta];
            fugasConta++;
        } else {
            // Fica bonzinho depois de 10 vezes
            this.style.transform = `translate(0px, 0px)`;
            this.style.backgroundColor = "#28a745";
            this.textContent = "Ufa! Pode clicar para salvar.";
        }
    });

    // 5. REGISTRAR CONTA (Salvar no DB)
    btnSalvarContaCaos.addEventListener('click', async () => {
        if (fugasConta < 10) return; // Evita que o usuário clique com o teclado antes da hora

        const nome = inputNomeCaos.value;
        const emailUser