<?php
require_once __DIR__ . '/../config/database.php';

class Comentario {
    private $conn;
    private $table = 'comentarios';

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    // Obtener comentarios de un libro
    public function getByLibro($libro_id) {
        $query = "SELECT c.*, u.nombre
                  FROM " . $this->table . " c
                  INNER JOIN usuarios u ON c.usuario_id = u.id
                  WHERE c.libro_id = :libro_id
                  ORDER BY c.fecha DESC";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':libro_id', $libro_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Crear comentario
    public function create($datos) {
        $query = "INSERT INTO " . $this->table . "
                  (libro_id, usuario_id, contenido)
                  VALUES (:libro_id, :usuario_id, :contenido)";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':libro_id', $datos['libro_id'], PDO::PARAM_INT);
        $stmt->bindParam(':usuario_id', $datos['usuario_id'], PDO::PARAM_INT);
        $stmt->bindParam(':contenido', $datos['contenido']);

        return $stmt->execute();
    }

    // Eliminar comentario
    public function delete($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
