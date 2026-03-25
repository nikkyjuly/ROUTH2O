5. Interatividade com JavaScript (Lógica e Eventos)
Nesta etapa, implementamos a "camada de comportamento" do projeto ROUTH2O, transformando elementos estáticos em componentes interativos.

5.1. O Papel do JavaScript no Front-end
Diferente do HTML (estrutura) e do CSS (estética), o JavaScript atuou como o sistema nervoso da aplicação. Ele foi responsável por:

Monitorar as ações do usuário (cliques).

Alterar o estado visual do site dinamicamente sem recarregar a página.

5.2. Manipulação do DOM (Document Object Model)
Para que o código pudesse interagir com o site, utilizei o conceito de DOM, que é a representação do HTML como uma árvore de objetos.

Seleção de Elementos: Utilizeis o método document.getElementById('id-do-elemento') para criar uma ponte entre o arquivo .js e as tags do projeto (Botão de Menu e Lista de Navegação).

Modificação de Classes: Através da propriedade classList.toggle('menu-ativo'), o JavaScript adiciona ou remove classes CSS em tempo real, permitindo que as regras de display: none ou display: flex sejam alternadas conforme a necessidade.

5.3. Lógica Orientada a Eventos
A interatividade do menu hambúrguer foi construída sobre o método addEventListener.

Ouvinte de Eventos: O script fica "escutando" o evento de click no botão identificado.

Função de Callback: Assim que o clique ocorre, uma função é disparada para executar a lógica de abertura do menu. Esse processo foi validado através do console.log() no painel de desenvolvedor (F12) para garantir que a comunicação entre o clique e o código estava ativa.

5.4. Refatoração e Solução de Problemas (Debugging)
Durante o desenvolvimento, identifiquei dois pontos críticos corrigidos via código:

Responsividade do Menu: Implementei a lógica para que o menu de navegação comece oculto em dispositivos móveis, economizando espaço vertical e melhorando a experiência do usuário.

Bug de Overflow no Input de Foto: Corrigi o erro de renderização onde a legenda "Nenhum arquivo escolhido" aparecia cortada. A solução envolveu o ajuste da propriedade white-space: nowrap e min-height no CSS, garantindo que o texto nativo do navegador tenha espaço suficiente para exibição total.