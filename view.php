<?php
class View {
    public function renderJson(array $dados): void {
        header('Content-Type: application/json');
        echo json_encode($dados);
    }
}
