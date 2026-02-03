<?php
require_once __DIR__ . '/../app/config/database.php';

try {
    $database = new Database();
    $pdo = $database->getConnection();

    $sql = "CREATE TABLE IF NOT EXISTS puntuaciones (
        id INT AUTO_INCREMENT PRIMARY KEY,
        libro_id INT NOT NULL,
        usuario_id INT NOT NULL,
        puntuacion TINYINT NOT NULL,
        fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (libro_id) REFERENCES libros(id) ON DELETE CASCADE,
        FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE,
        UNIQUE KEY unique_voto (libro_id, usuario_id)
    )";

    $pdo->exec($sql);
    echo "<h1 style='color: green;'>Tabla 'puntuaciones' creada correctamente!</h1>";
    echo "<p><a href='index.php'>Volver al inicio</a></p>";
    echo "<p style='color: red;'><strong>IMPORTANTE:</strong> Elimina este archivo despues de usarlo.</p>";

} catch (PDOException $e) {
    echo "<h1 style='color: red;'>Error:</h1>";
    echo "<p>" . htmlspecialchars($e->getMessage()) . "</p>";
}
