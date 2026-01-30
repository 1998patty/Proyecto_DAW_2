<?php
// Cargar variables de entorno desde .env (para desarrollo local)
$envFile = __DIR__ . '/../../.env';
if (file_exists($envFile)) {
    $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos($line, '=') !== false && strpos($line, '#') !== 0) {
            list($key, $value) = explode('=', $line, 2);
            $_ENV[trim($key)] = trim($value);
        }
    }
}

class Database {
    private $host;
    private $port;
    private $db_name;
    private $username;
    private $password;
    private $conn;

    public function __construct() {
        // Intentar obtener URL completa de MySQL primero
        $mysqlUrl = getenv('MYSQL_URL') ?: getenv('DATABASE_URL') ?: null;

        if ($mysqlUrl) {
            // Parsear URL: mysql://user:pass@host:port/database
            $parsed = parse_url($mysqlUrl);
            $this->host = $parsed['host'] ?? 'localhost';
            $this->port = $parsed['port'] ?? '3306';
            $this->db_name = ltrim($parsed['path'] ?? '/railway', '/');
            $this->username = $parsed['user'] ?? 'root';
            $this->password = $parsed['pass'] ?? '';
        } else {
            // Compatible con Railway (MYSQLHOST) y local (MYSQL_HOST)
            $this->host = getenv('MYSQLHOST') ?: ($_ENV['MYSQL_HOST'] ?? 'localhost');
            $this->port = getenv('MYSQLPORT') ?: ($_ENV['MYSQL_PORT'] ?? '3306');
            $this->db_name = getenv('MYSQLDATABASE') ?: ($_ENV['MYSQL_DATABASE'] ?? 'railway');
            $this->username = getenv('MYSQLUSER') ?: ($_ENV['MYSQL_USER'] ?? 'root');
            $this->password = getenv('MYSQLPASSWORD') ?: ($_ENV['MYSQL_PASSWORD'] ?? '');
        }
    }

    public function getConnection() {
        $this->conn = null;

        try {
            $dsn = "mysql:host=" . $this->host . ";port=" . $this->port . ";dbname=" . $this->db_name;
            $this->conn = new PDO($dsn, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->exec("set names utf8");
        } catch(PDOException $e) {
            die("Error de conexión: " . $e->getMessage());
        }

        return $this->conn;
    }
}
