<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<section class="catalogo">
    <h1>Catálogo de Libros</h1>

    <!-- Buscador -->
    <form class="buscador" method="GET" action="index.php">
        <input type="hidden" name="controller" value="libro">
        <input type="hidden" name="action" value="buscar">
        <input type="text" name="q" placeholder="Buscar por título o autor..." value="<?php echo isset($_GET['q']) ? htmlspecialchars($_GET['q']) : ''; ?>">
        <button type="submit">Buscar</button>
    </form>

    <!-- Grid de libros -->
    <div class="libros-grid">
        <?php if (!empty($libros)): ?>
            <?php foreach ($libros as $libro): ?>
                <article class="libro-card">
                    <div class="libro-imagen">
                        <img src="uploads/<?php echo htmlspecialchars($libro['imagen']); ?>" alt="<?php echo htmlspecialchars($libro['titulo']); ?>">
                    </div>
                    <div class="libro-info">
                        <h3><?php echo htmlspecialchars($libro['titulo']); ?></h3>
                        <p class="autor"><?php echo htmlspecialchars($libro['autor']); ?></p>
                        <span class="genero"><?php echo htmlspecialchars($libro['genero']); ?></span>
                        <a href="index.php?controller=libro&action=show&id=<?php echo $libro['id']; ?>" class="btn-ver">Ver más</a>
                    </div>
                </article>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="no-resultados">No se encontraron libros.</p>
        <?php endif; ?>
    </div>
</section>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
