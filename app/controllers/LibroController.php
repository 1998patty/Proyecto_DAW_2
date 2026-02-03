<?php
require_once __DIR__ . '/../models/Libro.php';
require_once __DIR__ . '/../models/Comentario.php';
require_once __DIR__ . '/../models/Puntuacion.php';

class LibroController {
    private $modelo;
    private $puntuacionModelo;

    public function __construct() {
        $this->modelo = new Libro();
        $this->puntuacionModelo = new Puntuacion();
    }

    // Mostrar catálogo
    public function index() {
        $libros = $this->modelo->getAll();
        $puntuaciones = $this->puntuacionModelo->getPromediosTodos();
        require_once __DIR__ . '/../views/libros/index.php';
    }

    // Buscar libros
    public function buscar() {
        $termino = isset($_GET['q']) ? trim($_GET['q']) : '';
        if (!empty($termino)) {
            $libros = $this->modelo->buscar($termino);
        } else {
            $libros = $this->modelo->getAll();
        }
        $puntuaciones = $this->puntuacionModelo->getPromediosTodos();
        require_once __DIR__ . '/../views/libros/index.php';
    }

    // Mostrar detalle de libro
    public function show() {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $libro = $this->modelo->getById($id);

        if (!$libro) {
            header('Location: index.php');
            exit;
        }

        $comentarioModelo = new Comentario();
        $comentarios = $comentarioModelo->getByLibro($id);

        // Obtener puntuacion
        $puntuacionInfo = $this->puntuacionModelo->getPromedio($id);
        $puntuacionUsuario = 0;
        if (isset($_SESSION['usuario_id'])) {
            $puntuacionUsuario = $this->puntuacionModelo->getPuntuacionUsuario($id, $_SESSION['usuario_id']);
        }

        require_once __DIR__ . '/../views/libros/show.php';
    }

    // Puntuar libro
    public function puntuar() {
        if (!isset($_SESSION['usuario_id'])) {
            header('Location: index.php?controller=auth&action=login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $libro_id = isset($_POST['libro_id']) ? (int)$_POST['libro_id'] : 0;
            $puntuacion = isset($_POST['puntuacion']) ? (int)$_POST['puntuacion'] : 0;

            if ($libro_id > 0 && $puntuacion >= 1 && $puntuacion <= 5) {
                $this->puntuacionModelo->puntuar($libro_id, $_SESSION['usuario_id'], $puntuacion);
            }

            header('Location: index.php?controller=libro&action=show&id=' . $libro_id);
            exit;
        }
    }

    // Formulario crear libro (solo admin)
    public function create() {
        if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
            header('Location: index.php');
            exit;
        }
        require_once __DIR__ . '/../views/libros/create.php';
    }

    // Guardar nuevo libro
    public function store() {
        if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
            header('Location: index.php');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validaciones backend
            $titulo = trim($_POST['titulo'] ?? '');
            $autor = trim($_POST['autor'] ?? '');
            $descripcion = trim($_POST['descripcion'] ?? '');
            $genero = trim($_POST['genero'] ?? '');
            $anio = (int)($_POST['anio'] ?? 0);

            if (empty($titulo) || empty($autor) || empty($descripcion) || empty($genero) || $anio <= 0) {
                $error = "Todos los campos son obligatorios";
                require_once __DIR__ . '/../views/libros/create.php';
                return;
            }

            // Procesar imagen
            $imagen = 'default.jpg';
            if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
                $ext = pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION);
                $imagen = uniqid() . '.' . $ext;
                move_uploaded_file($_FILES['imagen']['tmp_name'], __DIR__ . '/../../public/uploads/' . $imagen);
            }

            $datos = [
                'titulo' => $titulo,
                'autor' => $autor,
                'descripcion' => $descripcion,
                'imagen' => $imagen,
                'genero' => $genero,
                'anio' => $anio
            ];

            if ($this->modelo->create($datos)) {
                header('Location: index.php');
                exit;
            } else {
                $error = "Error al guardar el libro";
                require_once __DIR__ . '/../views/libros/create.php';
            }
        }
    }

    // Formulario editar libro (solo admin)
    public function edit() {
        if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
            header('Location: index.php');
            exit;
        }

        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $libro = $this->modelo->getById($id);

        if (!$libro) {
            header('Location: index.php');
            exit;
        }

        require_once __DIR__ . '/../views/libros/edit.php';
    }

    // Actualizar libro
    public function update() {
        if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
            header('Location: index.php');
            exit;
        }

        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $libro = $this->modelo->getById($id);

        if (!$libro) {
            header('Location: index.php');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $titulo = trim($_POST['titulo'] ?? '');
            $autor = trim($_POST['autor'] ?? '');
            $descripcion = trim($_POST['descripcion'] ?? '');
            $genero = trim($_POST['genero'] ?? '');
            $anio = (int)($_POST['anio'] ?? 0);

            if (empty($titulo) || empty($autor) || empty($descripcion) || empty($genero) || $anio <= 0) {
                $error = "Todos los campos son obligatorios";
                require_once __DIR__ . '/../views/libros/edit.php';
                return;
            }

            // Procesar imagen
            $imagen = $libro['imagen'];
            if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
                $ext = pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION);
                $imagen = uniqid() . '.' . $ext;
                move_uploaded_file($_FILES['imagen']['tmp_name'], __DIR__ . '/../../public/uploads/' . $imagen);
            }

            $datos = [
                'titulo' => $titulo,
                'autor' => $autor,
                'descripcion' => $descripcion,
                'imagen' => $imagen,
                'genero' => $genero,
                'anio' => $anio
            ];

            if ($this->modelo->update($id, $datos)) {
                header('Location: index.php?controller=libro&action=show&id=' . $id);
                exit;
            } else {
                $error = "Error al actualizar el libro";
                require_once __DIR__ . '/../views/libros/edit.php';
            }
        }
    }

    // Eliminar libro (solo admin)
    public function delete() {
        if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
            header('Location: index.php');
            exit;
        }

        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

        if ($this->modelo->delete($id)) {
            header('Location: index.php');
            exit;
        }
    }
}
