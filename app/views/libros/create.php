<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<section class="form-section">
    <h1>Agregar Nuevo Libro</h1>

    <?php if (isset($error)): ?>
        <div class="alerta error"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <form method="POST" action="index.php?controller=libro&action=store" enctype="multipart/form-data" id="form-libro">
        <div class="form-grupo">
            <label for="titulo">Título</label>
            <input type="text" id="titulo" name="titulo" required>
        </div>

        <div class="form-grupo">
            <label for="autor">Autor</label>
            <input type="text" id="autor" name="autor" required>
        </div>

        <div class="form-grupo">
            <label for="descripcion">Descripción</label>
            <textarea id="descripcion" name="descripcion" rows="5" required></textarea>
        </div>

        <div class="form-row">
            <div class="form-grupo">
                <label for="genero">Género</label>
                <select id="genero" name="genero" required>
                    <option value="">Seleccionar...</option>
                    <option value="Novela">Novela</option>
                    <option value="Ciencia ficción">Ciencia ficción</option>
                    <option value="Fantasía">Fantasía</option>
                    <option value="Terror">Terror</option>
                    <option value="Romance">Romance</option>
                    <option value="Historia">Historia</option>
                    <option value="Biografía">Biografía</option>
                    <option value="Poesía">Poesía</option>
                    <option value="Realismo mágico">Realismo mágico</option>
                    <option value="Otro">Otro</option>
                </select>
            </div>

            <div class="form-grupo">
                <label for="anio">Año de publicación</label>
                <input type="number" id="anio" name="anio" min="1000" max="<?php echo date('Y'); ?>" required>
            </div>
        </div>

        <div class="form-grupo">
            <label for="imagen">Imagen de portada</label>
            <input type="file" id="imagen" name="imagen" accept="image/*">
        </div>

        <div class="form-acciones">
            <a href="index.php" class="btn-cancelar">Cancelar</a>
            <button type="submit" class="btn-submit">Guardar Libro</button>
        </div>
    </form>
</section>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
