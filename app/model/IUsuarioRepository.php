<?php

interface IUsuarioRepository
{
    public function save(array $dados): bool;
    public function find(int $id): ?array;
    public function findByEmail(string $email): ?array;
    public function delete(int $id): bool;
}