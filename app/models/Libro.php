<?php
require_once __DIR__ . '/../config/database.php';

class Libro {
    private $conn;
    private $table = 'libros';

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    // Obtener todos los libros
    public function getAll() {
        $query = "SELECT * FROM " . $this->table . " ORDER BY fecha_creacion DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener libro por ID
    public function getById($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Buscar libros
    public function buscar($termino) {
        $query = "SELECT * FROM " . $this->table . "
                  WHERE titulo LIKE :termino OR autor LIKE :termino
                  ORDER BY fecha_creacion DESC";
        $stmt = $this->conn->prepare($query);
        $termino = "%$termino%";
        $stmt->bindParam(':termino', $termino);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Crear libro
    public function create($datos) {
        $query = "INSERT INTO " . $this->table . "
                  (titulo, autor, descripcion, imagen, genero, anio)
                  VALUES (:titulo, :autor, :descripcion, :imagen, :genero, :anio)";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':titulo', $datos['titulo']);
        $stmt->bindParam(':autor', $datos['autor']);
        $stmt->bindParam(':descripcion', $datos['descripcion']);
        $stmt->bindParam(':imagen', $datos['imagen']);
        $stmt->bindParam(':genero', $datos['genero']);
        $stmt->bindParam(':anio', $datos['anio'], PDO::PARAM_INT);

        return $stmt->execute();
    }

    // Actualizar libro
    public function update($id, $datos) {
        $query = "UPDATE " . $this->table . " SET
                  titulo = :titulo,
                  autor = :autor,
                  descripcion = :descripcion,
                  imagen = :imagen,
                  genero = :genero,
                  anio = :anio
                  WHERE id = :id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':titulo', $datos['titulo']);
        $stmt->bindParam(':autor', $datos['autor']);
        $stmt->bindParam(':descripcion', $datos['descripcion']);
        $stmt->bindParam(':imagen', $datos['imagen']);
        $stmt->bindParam(':genero', $datos['genero']);
        $stmt->bindParam(':anio', $datos['anio'], PDO::PARAM_INT);

        return $stmt->execute();
    }

    // Eliminar libro
    public function delete($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
