<?php

interface IUsuarioRepository
{
    public function save(Usuario $usuario): bool;
    public function find(int $id): ?Usuario;
    public function findByEmail(string $email): ?Usuario;
    public function delete(int $id): bool;
}
