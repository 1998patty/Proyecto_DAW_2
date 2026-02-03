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
                        <?php
                        $promedio = isset($puntuaciones[$libro['id']]) ? $puntuaciones[$libro['id']]['promedio'] : 0;
                        $total = isset($puntuaciones[$libro['id']]) ? $puntuaciones[$libro['id']]['total'] : 0;
                        ?>
                        <div class="estrellas-display">
                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                <?php if ($i <= floor($promedio)): ?>
                                    <span class="estrella llena">&#9733;</span>
                                <?php elseif ($i - 0.5 <= $promedio): ?>
                                    <span class="estrella media">&#9733;</span>
                                <?php else: ?>
                                    <span class="estrella vacia">&#9733;</span>
                                <?php endif; ?>
                            <?php endfor; ?>
                            <span class="puntuacion-texto"><?php echo $promedio > 0 ? $promedio : '-'; ?></span>
                            <span class="votos-texto">(<?php echo $total; ?>)</span>
                        </div>
                        <span class="genero"><?php echo htmlspecialchars($libro['genero']); ?></span>
                        <a href="index.php?controller=libro&action=show&id=<?php echo $libro['id']; ?>" class="btn-ver">Ver mas</a>
                    </div>
                </article>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="no-resultados">No se encontraron libros.</p>
        <?php endif; ?>
    </div>
</section>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
