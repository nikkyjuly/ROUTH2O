<?php

/**
 * service.php
 * Responsabilidade: regras de negócio APENAS.
 * Não acessa banco, não lida com HTTP.
 */

class MatriculaService
{
    // ── Configuração das regras por curso ──────────────────────────────────
    private array $idadeMinima = [
        'Engenharia de Software' => 17,
        'Medicina'               => 18,
        'Design Gráfico'         => 16,
        'Pedagogia'              => 17,
        'Direito'                => 18,
    ];

    // Alunos com 60+ anos ou renda declarada baixa recebem bolsa (simulação)
    private int $idadeBolsa = 60;

    // ── Método principal ───────────────────────────────────────────────────
    /**
     * Valida e enriquece os dados do aluno conforme regras de negócio.
     *
     * @param  array $dados  ['nome' => ..., 'idade' => ..., 'curso' => ...]
     * @return array         Dados processados, incluindo chave 'bolsa' (bool)
     * @throws Exception     Se alguma regra for violada
     */
    public function processar(array $dados): array
    {
        $nome  = $dados['nome'];
        $idade = (int) $dados['idade'];
        $curso = $dados['curso'];

        // ── Regra 1: curso deve ser válido ────────────────────────────────
        if (!array_key_exists($curso, $this->idadeMinima)) {
            throw new Exception(
                "Curso \"$curso\" não reconhecido. " .
                "Opções: " . implode(', ', array_keys($this->idadeMinima)) . "."
            );
        }

        // ── Regra 2: idade mínima por curso ───────────────────────────────
        $minima = $this->idadeMinima[$curso];
        if ($idade < $minima) {
            throw new Exception(
                "Matrícula recusada: o curso \"$curso\" exige idade mínima de " .
                "$minima anos. $nome tem $idade anos."
            );
        }

        // ── Regra 3: bolsa de estudos (simulação) ─────────────────────────
        $temBolsa = $idade >= $this->idadeBolsa;

        return [
            'nome'   => $nome,
            'idade'  => $idade,
            'curso'  => $curso,
            'bolsa'  => $temBolsa,
        ];
    }
}
