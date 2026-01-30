<?php
session_start();

// Cargar configuración
require_once __DIR__ . '/../app/config/database.php';

// Obtener la acción de la URL
$controller = isset($_GET['controller']) ? $_GET['controller'] : 'libro';
$action = isset($_GET['action']) ? $_GET['action'] : 'index';

// Cargar el controlador correspondiente
switch ($controller) {
    case 'libro':
        require_once __DIR__ . '/../app/controllers/LibroController.php';
        $ctrl = new LibroController();
        break;
    case 'auth':
        require_once __DIR__ . '/../app/controllers/AuthController.php';
        $ctrl = new AuthController();
        break;
    case 'comentario':
        require_once __DIR__ . '/../app/controllers/ComentarioController.php';
        $ctrl = new ComentarioController();
        break;
    default:
        require_once __DIR__ . '/../app/controllers/LibroController.php';
        $ctrl = new LibroController();
        $action = 'index';
}

// Ejecutar la acción
if (method_exists($ctrl, $action)) {
    $ctrl->$action();
} else {
    echo "Acción no encontrada";
}
