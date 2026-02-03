<?php
require_once __DIR__ . '/../config/database.php';

class Puntuacion {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    // Agregar o actualizar puntuacion
    public function puntuar($libro_id, $usuario_id, $puntuacion) {
        // Verificar si ya existe una puntuacion
        $sql = "SELECT id FROM puntuaciones WHERE libro_id = ? AND usuario_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$libro_id, $usuario_id]);

        if ($stmt->fetch()) {
            // Actualizar puntuacion existente
            $sql = "UPDATE puntuaciones SET puntuacion = ?, fecha = NOW() WHERE libro_id = ? AND usuario_id = ?";
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute([$puntuacion, $libro_id, $usuario_id]);
        } else {
            // Crear nueva puntuacion
            $sql = "INSERT INTO puntuaciones (libro_id, usuario_id, puntuacion) VALUES (?, ?, ?)";
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute([$libro_id, $usuario_id, $puntuacion]);
        }
    }

    // Obtener promedio de puntuacion de un libro
    public function getPromedio($libro_id) {
        $sql = "SELECT AVG(puntuacion) as promedio, COUNT(*) as total FROM puntuaciones WHERE libro_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$libro_id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return [
            'promedio' => $result['promedio'] ? round($result['promedio'], 1) : 0,
            'total' => (int)$result['total']
        ];
    }

    // Obtener puntuacion de un usuario para un libro
    public function getPuntuacionUsuario($libro_id, $usuario_id) {
        $sql = "SELECT puntuacion FROM puntuaciones WHERE libro_id = ? AND usuario_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$libro_id, $usuario_id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result ? (int)$result['puntuacion'] : 0;
    }

    // Obtener promedios de todos los libros
    public function getPromediosTodos() {
        $sql = "SELECT libro_id, AVG(puntuacion) as promedio, COUNT(*) as total
                FROM puntuaciones
                GROUP BY libro_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        $promedios = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $promedios[$row['libro_id']] = [
                'promedio' => round($row['promedio'], 1),
                'total' => (int)$row['total']
            ];
        }

        return $promedios;
    }
}
