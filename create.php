<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Cadastrar Usuário</title>
    <style>
        body { font-family: sans-serif; max-width: 480px; margin: 60px auto; padding: 0 1rem; }
        h1   { margin-bottom: 1.5rem; }
        label { display: block; margin-bottom: .25rem; font-weight: bold; font-size: .9rem; }
        input, select { width: 100%; padding: .6rem; margin-bottom: 1rem; border: 1px solid #ccc; border-radius: 6px; font-size: 1rem; }
        button { width: 100%; padding: .75rem; background: #00C9A7; color: #fff; border: none; border-radius: 6px; font-size: 1rem; cursor: pointer; }
        button:hover { background: #00877A; }
        .erro { background: #fff0f0; color: #c0392b; border: 1px solid #e74c3c; border-radius: 6px; padding: .75rem 1rem; margin-bottom: 1rem; }
        .sucesso { background: #f0fff4; color: #27ae60; border: 1px solid #2ecc71; border-radius: 6px; padding: .75rem 1rem; margin-bottom: 1rem; }
    </style>
</head>
<body>

<h1>Cadastrar Usuário</h1>

<?php if (!empty($erro)): ?>
    <div class="erro">⚠ <?= htmlspecialchars($erro) ?></div>
<?php endif; ?>

<?php if (isset($_GET['sucesso'])): ?>
    <div class="sucesso">✓ Usuário cadastrado com sucesso!</div>
<?php endif; ?>

<form method="POST" action="/usuarios">
    <label for="nome">Nome</label>
    <input type="text" id="nome" name="nome" placeholder="Nome completo" required>

    <label for="email">E-mail</label>
    <input type="email" id="email" name="email" placeholder="email@exemplo.com" required>

    <label for="senha">Senha</label>
    <input type="password" id="senha" name="senha" placeholder="Mínimo 8 caracteres" required>

    <label for="perfil">Perfil</label>
    <select id="perfil" name="perfil">
        <option value="usuario">Usuário</option>
        <option value="admin">Admin</option>
    </select>

    <button type="submit">Cadastrar</button>
</form>

</body>
</html>
