<?php

/**
 * service.php
 * Responsabilidade: Regras de negócio de performance e hidratação.
 */

/**
 * Exceção customizada para regras de negócio.
 */
class BusinessRuleException extends Exception {}

class Routh2oService
{
    private IUsuarioRepository $repository;

    public function __construct(IUsuarioRepository $repository)
    {
        $this->repository = $repository;
    }

    public function validarNovoUsuario(array $dados): void
    {
        $usuarioExistente = $this->repository->findByEmail($dados['email']);

        if ($usuarioExistente !== null) {
            throw new BusinessRuleException("O e-mail '{$dados['email']}' já está cadastrado.");
        }

        if (strlen($dados['senha']) < 8) {
            throw new BusinessRuleException('A senha deve ter no mínimo 8 caracteres.');
        }
    }

    public function podeExcluir(array $usuario): void
    {
        if ($usuario['perfil'] === 'admin') {
            throw new BusinessRuleException('Não é permitido excluir um administrador.');
        }
    }

    // Baseado na aba Laboratório: Cálculo de meta hídrica por esforço
    public function calcularMetaHidratacao(float $km): int 
    {
        // Regra fictícia: 35ml por kg base + 100ml por cada km percorrido
        $base = 2000; // 2 litros base
        $adicional = (int)($km * 100);
        return $base + $adicional;
    }

    public function verificarSenha(string $senhaDigitada, string $senhaHash): bool 
    {
        return password_verify($senhaDigitada, $senhaHash);
    }
}
