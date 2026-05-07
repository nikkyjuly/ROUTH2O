<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Matrícula</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div class="card">
        <h1>📋 Formulário de Matrícula</h1>
        <p class="subtitulo">Preencha todos os campos para solicitar sua matrícula.</p>

        <form action="/" method="POST">

            <div class="campo">
                <label for="nome">Nome completo</label>
                <input
                    type="text"
                    id="nome"
                    name="nome"
                    placeholder="Ex.: Maria Oliveira"
                    required
                >
            </div>

            <div class="campo">
                <label for="idade">Idade</label>
                <input
                    type="number"
                    id="idade"
                    name="idade"
                    placeholder="Ex.: 19"
                    min="1"
                    max="120"
                    required
                >
            </div>

            <div class="campo">
                <label for="curso">Curso</label>
                <select id="curso" name="curso" required>
                    <option value="" disabled selected>Selecione um curso…</option>
                    <option value="Engenharia de Software">Engenharia de Software (mín. 17 anos)</option>
                    <option value="Medicina">Medicina (mín. 18 anos)</option>
                    <option value="Design Gráfico">Design Gráfico (mín. 16 anos)</option>
                    <option value="Pedagogia">Pedagogia (mín. 17 anos)</option>
                    <option value="Direito">Direito (mín. 18 anos)</option>
                </select>
            </div>

            <button type="submit" class="btn-submit">Enviar matrícula →</button>
        </form>
    </div>

</body>
</html>
