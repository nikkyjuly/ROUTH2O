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