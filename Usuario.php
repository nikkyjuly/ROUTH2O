<?php

class Usuario
{
    private ?int    $id     = null;
    private string  $nome   = '';
    private string  $email  = '';
    private string  $senha  = '';
    private string  $perfil = 'usuario'; // 'usuario' | 'admin'

    // ── Getters ──
    public function getId():     ?int   { return $this->id;     }
    public function getNome():   string { return $this->nome;   }
    public function getEmail():  string { return $this->email;  }
    public function getSenha():  string { return $this->senha;  }
    public function getPerfil(): string { return $this->perfil; }

    // ── Setters ──
    public function setId(?int $id):       void { $this->id     = $id;     }
    public function setNome(string $nome): void { $this->nome   = $nome;   }
    public function setEmail(string $email): void { $this->email = $email; }
    public function setSenha(string $senha): void { $this->senha = $senha; }
    public function setPerfil(string $perfil): void { $this->perfil = $perfil; }

    // ── Método mágico para debug ──
    public function __toString(): string
    {
        return "Usuario[id={$this->id}, nome={$this->nome}, email={$this->email}, perfil={$this->perfil}]";
    }
}
