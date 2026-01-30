<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<section class="form-section">
    <h1>Editar Libro</h1>

    <?php if (isset($error)): ?>
        <div class="alerta error"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <form method="POST" action="index.php?controller=libro&action=update&id=<?php echo $libro['id']; ?>" enctype="multipart/form-data" id="form-libro">
        <div class="form-grupo">
            <label for="titulo">Título</label>
            <input type="text" id="titulo" name="titulo" value="<?php echo htmlspecialchars($libro['titulo']); ?>" required>
        </div>

        <div class="form-grupo">
            <label for="autor">Autor</label>
            <input type="text" id="autor" name="autor" value="<?php echo htmlspecialchars($libro['autor']); ?>" required>
        </div>

        <div class="form-grupo">
            <label for="descripcion">Descripción</label>
            <textarea id="descripcion" name="descripcion" rows="5" required><?php echo htmlspecialchars($libro['descripcion']); ?></textarea>
        </div>

        <div class="form-row">
            <div class="form-grupo">
                <label for="genero">Género</label>
                <select id="genero" name="genero" required>
                    <option value="">Seleccionar...</option>
                    <?php
                    $generos = ['Novela', 'Ciencia ficción', 'Fantasía', 'Terror', 'Romance', 'Historia', 'Biografía', 'Poesía', 'Realismo mágico', 'Otro'];
                    foreach ($generos as $g): ?>
                        <option value="<?php echo $g; ?>" <?php echo ($libro['genero'] === $g) ? 'selected' : ''; ?>><?php echo $g; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-grupo">
                <label for="anio">Año de publicación</label>
                <input type="number" id="anio" name="anio" min="1000" max="<?php echo date('Y'); ?>" value="<?php echo htmlspecialchars($libro['anio']); ?>" required>
            </div>
        </div>

        <div class="form-grupo">
            <label for="imagen">Imagen de portada</label>
            <div class="imagen-actual">
                <img src="uploads/<?php echo htmlspecialchars($libro['imagen']); ?>" alt="Portada actual" width="100">
                <span>Imagen actual</span>
            </div>
            <input type="file" id="imagen" name="imagen" accept="image/*">
            <small>Deja vacío para mantener la imagen actual</small>
        </div>

        <div class="form-acciones">
            <a href="index.php?controller=libro&action=show&id=<?php echo $libro['id']; ?>" class="btn-cancelar">Cancelar</a>
            <button type="submit" class="btn-submit">Actualizar Libro</button>
        </div>
    </form>
</section>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
