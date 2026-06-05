<?php

/**
 * controller.php
 * Responsabilidade: Orquestrar ações de Usuário e Treino.
 */
class Routh2oController
{
    private $repository;
    private $service;
    private $view;

    public function __construct(IUsuarioRepository $repository, Routh2oService $service) 
    {
        $this->repository = $repository;
        $this->service = $service;
        $this->view = new View();
    }

    public function login(array $dados): void 
    {
        $usuario = $this->repository->findByEmail($dados['email']);
        if ($usuario && $this->service->verificarSenha($dados['senha'], $usuario['senha'])) {
            session_start();
            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['nome'] = $usuario['nome'];
            $this->view->renderJson(['sucesso' => true, 'redirecionar' => 'treino.html']);
        } else {
            http_response_code(401);
            $this->view->renderJson(['erro' => 'E-mail ou senha incorretos.']);
        }
    }

    public function registrar(array $dados): void 
    {
        try {
            $this->service->validarNovoUsuario($dados);
            
            if ($this->repository->save($dados)) {
                $this->view->renderJson(['sucesso' => true, 'mensagem' => 'Conta criada com sucesso!']);
            }
        } catch (BusinessRuleException $e) {
            http_response_code(400);
            $this->view->renderJson(['erro' => $e->getMessage()]);
        }
    }

    public function salvarPerfil(int $id, array $dados): void 
    {
        $usuarioAtual = $this->repository->find($id);
        $perfilParaSalvar = [
            'id'              => $id,
            'nome'            => $usuarioAtual['nome'],
            'email'           => $usuarioAtual['email'],
            'data_nascimento' => $dados['nascimento'] ?? null,
            'objetivos'       => $dados['objetivo'] ?? $dados['obj'] ?? null,
            'bio'             => $dados['bio'] ?? null // Mapeando o campo bio
        ];
        $this->repository->save($perfilParaSalvar);
        $this->view->renderJson(['sucesso' => true, 'mensagem' => 'Perfil atualizado!']);
    }

    public function excluir(int $id): void
    {
        $usuario = $this->repository->find($id);
        if ($usuario) {
            try {
                $this->service->podeExcluir($usuario);
                $this->repository->delete($id);
                $this->view->renderJson(['sucesso' => true, 'mensagem' => 'Usuário excluído com sucesso!']);
            } catch (BusinessRuleException $e) {
                $this->view->renderJson(['erro' => $e->getMessage()]);
            }
        }
    }

    public function calcularHidratacao(float $km): void 
    {
        $meta = $this->service->calcularMetaHidratacao($km);
        // Retorna via View para exibição
        (new View())->renderJson(['meta' => $meta]);
    }
}
