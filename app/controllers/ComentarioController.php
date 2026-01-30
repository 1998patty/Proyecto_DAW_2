<?php
require_once __DIR__ . '/../models/Comentario.php';

class ComentarioController {
    private $modelo;

    public function __construct() {
        $this->modelo = new Comentario();
    }

    // Guardar comentario
    public function store() {
        // Solo usuarios logueados pueden comentar
        if (!isset($_SESSION['usuario_id'])) {
            header('Location: index.php?controller=auth&action=login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $libro_id = (int)($_POST['libro_id'] ?? 0);
            $contenido = trim($_POST['contenido'] ?? '');

            // Validaciones backend
            if (empty($contenido)) {
                header('Location: index.php?controller=libro&action=show&id=' . $libro_id);
                exit;
            }

            if ($libro_id <= 0) {
                header('Location: index.php');
                exit;
            }

            $datos = [
                'libro_id' => $libro_id,
                'usuario_id' => $_SESSION['usuario_id'],
                'contenido' => $contenido
            ];

            $this->modelo->create($datos);

            header('Location: index.php?controller=libro&action=show&id=' . $libro_id);
            exit;
        }

        header('Location: index.php');
    }

    // Eliminar comentario (solo admin)
    public function delete() {
        if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
            header('Location: index.php');
            exit;
        }

        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $libro_id = isset($_GET['libro_id']) ? (int)$_GET['libro_id'] : 0;

        if ($id > 0) {
            $this->modelo->delete($id);
        }

        header('Location: index.php?controller=libro&action=show&id=' . $libro_id);
        exit;
    }
}
