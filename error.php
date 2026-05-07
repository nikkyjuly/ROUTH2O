<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Erro</title>
    <style>
        body { font-family: sans-serif; max-width: 480px; margin: 60px auto; padding: 0 1rem; }
        .erro { background: #fff0f0; color: #c0392b; border: 1px solid #e74c3c; border-radius: 6px; padding: 1rem; }
        a { color: #00877A; }
    </style>
</head>
<body>
    <h1>Ops!</h1>
    <div class="erro">⚠ <?= htmlspecialchars($erro ?? 'Erro desconhecido.') ?></div>
    <p><a href="/">← Voltar ao início</a></p>
</body>
</html>
