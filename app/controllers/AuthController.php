<?php
require_once __DIR__ . '/../models/Usuario.php';

class AuthController {
    private $modelo;

    public function __construct() {
        $this->modelo = new Usuario();
    }

    // Mostrar formulario login
    public function login() {
        if (isset($_SESSION['usuario_id'])) {
            header('Location: index.php');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';

            // Validaciones backend
            if (empty($email) || empty($password)) {
                $error = "Todos los campos son obligatorios";
                require_once __DIR__ . '/../views/auth/login.php';
                return;
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error = "Email no válido";
                require_once __DIR__ . '/../views/auth/login.php';
                return;
            }

            $usuario = $this->modelo->login($email, $password);

            if ($usuario) {
                $_SESSION['usuario_id'] = $usuario['id'];
                $_SESSION['nombre'] = $usuario['nombre'];
                $_SESSION['email'] = $usuario['email'];
                $_SESSION['rol'] = $usuario['rol'];

                header('Location: index.php');
                exit;
            } else {
                $error = "Credenciales incorrectas";
                require_once __DIR__ . '/../views/auth/login.php';
                return;
            }
        }

        require_once __DIR__ . '/../views/auth/login.php';
    }

    // Mostrar formulario registro
    public function registro() {
        if (isset($_SESSION['usuario_id'])) {
            header('Location: index.php');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = trim($_POST['nombre'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            $password_confirm = $_POST['password_confirm'] ?? '';

            // Validaciones backend
            if (empty($nombre) || empty($email) || empty($password) || empty($password_confirm)) {
                $error = "Todos los campos son obligatorios";
                require_once __DIR__ . '/../views/auth/registro.php';
                return;
            }

            if (strlen($nombre) < 3) {
                $error = "El nombre debe tener al menos 3 caracteres";
                require_once __DIR__ . '/../views/auth/registro.php';
                return;
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error = "Email no válido";
                require_once __DIR__ . '/../views/auth/registro.php';
                return;
            }

            if (strlen($password) < 6) {
                $error = "La contraseña debe tener al menos 6 caracteres";
                require_once __DIR__ . '/../views/auth/registro.php';
                return;
            }

            if ($password !== $password_confirm) {
                $error = "Las contraseñas no coinciden";
                require_once __DIR__ . '/../views/auth/registro.php';
                return;
            }

            if ($this->modelo->emailExiste($email)) {
                $error = "Este email ya está registrado";
                require_once __DIR__ . '/../views/auth/registro.php';
                return;
            }

            $datos = [
                'nombre' => $nombre,
                'email' => $email,
                'password' => $password,
                'rol' => 'usuario'
            ];

            if ($this->modelo->create($datos)) {
                // Auto-login después de registrarse
                $usuario = $this->modelo->getByEmail($email);
                $_SESSION['usuario_id'] = $usuario['id'];
                $_SESSION['nombre'] = $usuario['nombre'];
                $_SESSION['email'] = $usuario['email'];
                $_SESSION['rol'] = $usuario['rol'];

                header('Location: index.php');
                exit;
            } else {
                $error = "Error al registrar. Intenta de nuevo.";
                require_once __DIR__ . '/../views/auth/registro.php';
            }
        }

        require_once __DIR__ . '/../views/auth/registro.php';
    }

    // Cerrar sesión
    public function logout() {
        session_destroy();
        header('Location: index.php');
        exit;
    }
}
