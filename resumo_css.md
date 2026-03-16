# Resumo de Aprendizado: CSS (Teoria e Prática)

## 1. A Utilidade do CSS e o Uso de Arquivos Externos
O **CSS (Cascading Style Sheets)** é a linguagem responsável por definir a camada de design e estilo de uma página web. Enquanto o HTML estrutura o conteúdo, o CSS cuida da estética (cores, fontes, espaçamentos e layouts).

O uso de um arquivo externo (ex: `style.css`) conectado via tag `<link>` é o mais recomendado porque:
- **Manutenibilidade**: Permite alterar o visual de várias páginas simultaneamente editando apenas um arquivo.
- **Performance**: O navegador armazena o arquivo CSS em cache, carregando o site mais rápido nas próximas visitas.
- **Separação de Preocupações**: Mantém o código HTML limpo, focado apenas na estrutura dos dados.

## 2. O Conceito de Classes na Estilização
O uso de **classes** (`.nome-da-classe`) é fundamental para criar um código profissional. Diferente dos seletores de tag (que afetam todos os elementos iguais) ou IDs (que devem ser únicos), as classes permitem:
- Aplicar o mesmo estilo a elementos diferentes de forma seletiva.
- Evitar conflitos de estilo conforme o projeto cresce.
- Criar componentes reutilizáveis, como botões (`.botao-padrao`) ou cards (`.card-informativo`).

## 3. Glossário de Propriedades Fundamentais
Abaixo estão as principais propriedades manipuladas durante o desenvolvimento do projeto ROUTH2O:

| Propriedade | Descrição |
| :--- | :--- |
| `color` | Define a cor do texto do elemento. |
| `background-color` | Define a cor de fundo do elemento. |
| `margin` | Espaçamento externo (fora da borda), usado para afastar elementos entre si. |
| `padding` | Espaçamento interno (entre o conteúdo e a borda), usado para dar "respiro" ao conteúdo. |
| `display: flex` | Ativa o **Flexbox**, permitindo alinhar e distribuir elementos de forma dinâmica e responsiva. |
| `flex-direction` | Define a direção dos itens dentro de um container flexível (ex: `row` para linha ou `column` para coluna). |
| `gap` | Define o espaçamento entre os itens de um container que utiliza Flexbox ou Grid. |
| `box-sizing: border-box` | Altera o **Box Model** padrão, garantindo que o `padding` e a `border` não aumentem a largura total definida para o elemento. |

## 4. Box Model (Modelo de Caixa)
Entender o Box Model é crucial para o layout. Todo elemento HTML é visto como uma caixa composta por: **Conteúdo** (Content), **Preenchimento** (Padding), **Borda** (Border) e **Margem** (Margin). O ajuste independente dessas camadas permite o controle total sobre o posicionamento e o tamanho dos elementos na tela.

-----------------------------------------------------------------------

Aprendizado e Validação: Responsividade no Projeto ROUTH2O
1. A Tag Meta Viewport
Durante a preparação do ambiente, verifiquei a presença da tag <meta name="viewport" content="width=device-width, initial-scale=1.0"> no <head> de todos os arquivos HTML. Conforme a teoria, essa tag é vital porque:

Informa ao navegador que a largura do conteúdo deve seguir a largura real da tela do dispositivo (device-width).

Define o nível de zoom inicial como 1.0, impedindo que o navegador renderize o site em uma escala reduzida e ilegível.

2. Media Queries: min-width vs max-width
Com base na consulta ao MDN Web Docs, apliquei a regra @media para criar estilos condicionais.

max-width: Utilizado para definir estilos que se aplicam até um limite máximo (ex: estilos específicos para mobile até 767px).

min-width: Utilizado para definir estilos que começam a valer a partir de uma largura mínima (ex: expandir o layout para desktop a partir de 1024px).

Adotamos a estratégia Mobile-First, onde o CSS base é focado em telas menores e as Media Queries expandem o design para telas maiores.

3. Definição de Breakpoints
O projeto foi adaptado utilizando três pontos de quebra principais para garantir uma boa experiência de navegação:

Mobile (Até 767px): Menu em coluna e tabelas com rolagem lateral para evitar quebras de layout.

Tablet (768px a 1023px): Uso de Grid Layout para organizar formulários em duas colunas.

Desktop (1024px ou mais): Layout centralizado com max-width e elementos distribuídos horizontalmente com Flexbox.

4. Ferramentas de Desenvolvedor e Validação
Para validar as soluções, utilizei o Inspecionar Elemento do navegador (DevTools):

Ativei a Barra de Ferramentas de Dispositivo para simular diferentes resoluções em tempo real.

Identifiquei e corrigi um bug de estouro na tabela de relatórios através do comando overflow-x: auto e um bug de corte no input de fotos através da propriedade min-height.