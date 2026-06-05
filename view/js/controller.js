// ============================================================
// SISTEMA DO PERFIL (perfil.html)
// ============================================================
const formPerfil = document.querySelector('.formulario-avancado');

if (formPerfil) {
    formPerfil.addEventListener('submit', async (event) => {
        event.preventDefault(); // Impede a página de recarregar

        const formData = new FormData(formPerfil);

        try {
            // O campo 'bio' agora é enviado separadamente e tratado no backend
            const response = await fetch('/perfil', {
                method: 'POST',
                body: formData
            });
            const resultado = await response.json();
            if (resultado.sucesso) {
                alert(resultado.mensagem);
            } else {
                alert("Erro: " + resultado.erro);
            }
        } catch (erro) {
            console.error("Erro ao salvar perfil:", erro);
        }
    });
}

// ============================================================
// CÁLCULO DE HIDRATAÇÃO (atividade_dom.html)
// ============================================================
const btnCalcular = document.getElementById('btn-calcular-hidratacao');
const inputKm = document.getElementById('km-input');
const displayResultado = document.getElementById('resultado-hidratacao');

if (btnCalcular) {
    btnCalcular.addEventListener('click', async () => {
        const km = inputKm.value;
        const response = await fetch(`/calcular?km=${km}`);
        const dados = await response.json();
        displayResultado.textContent = `Meta Sugerida: ${dados.meta}ml`;
    });
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
                // Sincronizando com o endpoint de perfil do PHP
                const formData = new FormData();
                formData.append('nascimento', `${ano}-${mes.padStart(2, '0')}-${dia.padStart(2, '0')}`);
                // Se houver outros campos de perfil que possam ser afetados, adicione-os aqui

                const response = await fetch('/perfil', {
                    method: 'POST',
                    body: formData
                });
                const res = await response.json();
                alert(`Sucesso! A data [ ${dataCaotica} ] foi sincronizada com seu perfil.`);
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

    const formCadastro = document.getElementById('form-cadastro');
    
    formCadastro.addEventListener('submit', async (e) => {
        e.preventDefault();
        const formData = new FormData(formCadastro);

        try {
            const response = await fetch('/registrar', {
                method: 'POST',
                body: formData
            });

            const res = await response.json();
            if (res.sucesso) {
                alert(res.mensagem);
                btnAbaLogin.click(); // Volta para a aba de login
            } else {
                alert("Erro: " + res.erro);
            }
        } catch (erro) {
            console.error("Erro ao criar conta:", erro);
        }
    });

    const formLogin = document.getElementById('form-login');
    if (formLogin) {
        formLogin.addEventListener('submit', async (e) => {
            e.preventDefault();
            const formData = new FormData(formLogin);
            try {
                const response = await fetch('/login', {
                    method: 'POST',
                    body: formData
                });
                const res = await response.json();
                if (res.sucesso) window.location.href = res.redirecionar;
                else alert(res.erro);
            } catch (erro) {
                console.error("Erro no login:", erro);
            }
        });
    }
}