<?php

/**
 * model.php
 * Responsabilidade: Entidade simples de Usuário.
 */
class Usuario
{
    public ?int $id = null;
    public string $nome;
    public string $email;
    public string $senha;
    public ?string $data_nascimento = null;
    public ?string $objetivos = null;
    public ?string $bio = null; // Adicionado campo bio
    public string $perfil = 'usuario';
}
