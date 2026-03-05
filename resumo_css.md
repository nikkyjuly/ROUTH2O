# Resumo de Aprendizado: CSS

## A Utilidade do CSS e Arquivos Externos
O CSS (Cascading Style Sheets) é responsável pela camada de apresentação visual do site. O uso de um arquivo externo (`style.css`) é o mais recomendado por:
- **Organização**: Separa a estrutura (HTML) do design (CSS).
- **Manutenibilidade**: Permite alterar o visual de todo o site editando um único arquivo.
- **Performance**: O navegador carrega o arquivo de estilo uma vez e o mantém em cache.

## Glossário de Propriedades
- **color**: Define a cor do texto.
- **background-color**: Define a cor de fundo de um elemento.
- **margin**: Espaço externo ao redor do elemento (fora da borda). [00:18:48]
- **padding**: Espaço interno entre o conteúdo e a borda. [00:18:28]
- **display: flex**: Transforma o elemento em um container flexível, facilitando o alinhamento de itens filhos. [00:32:22]
- **box-sizing: border-box**: Faz com que o padding e a borda sejam incluídos no cálculo da largura total do elemento. [00:20:18]

## O Poder das Classes
As **classes** (`.nome-da-classe`) permitem selecionar múltiplos elementos específicos para aplicar o mesmo estilo, sem a rigidez dos IDs ou a generalidade das tags. Isso ajuda a evitar que um estilo aplicado a um parágrafo do rodapé afete acidentalmente os parágrafos do conteúdo principal. [01:03:00]