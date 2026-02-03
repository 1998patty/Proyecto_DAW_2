<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<section class="libro-detalle">
    <a href="index.php" class="btn-volver">← Volver al catálogo</a>

    <div class="libro-contenido">
        <div class="libro-imagen-grande">
            <img src="uploads/<?php echo htmlspecialchars($libro['imagen']); ?>" alt="<?php echo htmlspecialchars($libro['titulo']); ?>">
        </div>

        <div class="libro-info-detalle">
            <h1><?php echo htmlspecialchars($libro['titulo']); ?></h1>
            <p class="autor">Por: <strong><?php echo htmlspecialchars($libro['autor']); ?></strong></p>

            <!-- Seccion de puntuacion -->
            <div class="puntuacion-seccion">
                <div class="puntuacion-promedio">
                    <div class="estrellas-display grande">
                        <?php for ($i = 1; $i <= 5; $i++): ?>
                            <?php if ($i <= floor($puntuacionInfo['promedio'])): ?>
                                <span class="estrella llena">&#9733;</span>
                            <?php elseif ($i - 0.5 <= $puntuacionInfo['promedio']): ?>
                                <span class="estrella media">&#9733;</span>
                            <?php else: ?>
                                <span class="estrella vacia">&#9733;</span>
                            <?php endif; ?>
                        <?php endfor; ?>
                    </div>
                    <span class="promedio-numero"><?php echo $puntuacionInfo['promedio'] > 0 ? $puntuacionInfo['promedio'] : '-'; ?>/5</span>
                    <span class="total-votos">(<?php echo $puntuacionInfo['total']; ?> <?php echo $puntuacionInfo['total'] == 1 ? 'voto' : 'votos'; ?>)</span>
                </div>

                <?php if (isset($_SESSION['usuario_id'])): ?>
                    <div class="tu-puntuacion">
                        <span class="tu-voto-label">Tu puntuacion:</span>
                        <form method="POST" action="index.php?controller=libro&action=puntuar" class="form-estrellas">
                            <input type="hidden" name="libro_id" value="<?php echo $libro['id']; ?>">
                            <div class="estrellas-input">
                                <?php for ($i = 5; $i >= 1; $i--): ?>
                                    <input type="radio" name="puntuacion" value="<?php echo $i; ?>" id="star<?php echo $i; ?>" <?php echo $puntuacionUsuario == $i ? 'checked' : ''; ?>>
                                    <label for="star<?php echo $i; ?>" title="<?php echo $i; ?> estrellas">&#9733;</label>
                                <?php endfor; ?>
                            </div>
                            <button type="submit" class="btn-votar">Votar</button>
                        </form>
                    </div>
                <?php else: ?>
                    <p class="login-puntuar">
                        <a href="index.php?controller=auth&action=login">Inicia sesion</a> para puntuar este libro.
                    </p>
                <?php endif; ?>
            </div>

            <p class="meta">
                <span class="genero"><?php echo htmlspecialchars($libro['genero']); ?></span>
                <span class="anio">Ano: <?php echo htmlspecialchars($libro['anio']); ?></span>
            </p>
            <div class="descripcion">
                <h3>Descripcion</h3>
                <p><?php echo nl2br(htmlspecialchars($libro['descripcion'])); ?></p>
            </div>

            <?php if (isset($_SESSION['rol']) && $_SESSION['rol'] === 'admin'): ?>
                <div class="acciones-admin">
                    <a href="index.php?controller=libro&action=edit&id=<?php echo $libro['id']; ?>" class="btn-editar">Editar</a>
                    <a href="index.php?controller=libro&action=delete&id=<?php echo $libro['id']; ?>" class="btn-eliminar" onclick="return confirm('¿Estás seguro de eliminar este libro?')">Eliminar</a>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Sección de comentarios -->
    <div class="comentarios-seccion">
        <h2>Comentarios</h2>

        <?php if (isset($_SESSION['usuario_id'])): ?>
            <form class="form-comentario" method="POST" action="index.php?controller=comentario&action=store">
                <input type="hidden" name="libro_id" value="<?php echo $libro['id']; ?>">
                <textarea name="contenido" placeholder="Escribe tu comentario..." required></textarea>
                <button type="submit">Comentar</button>
            </form>
        <?php else: ?>
            <p class="login-mensaje">
                <a href="index.php?controller=auth&action=login">Inicia sesión</a> para dejar un comentario.
            </p>
        <?php endif; ?>

        <div class="lista-comentarios">
            <?php if (!empty($comentarios)): ?>
                <?php foreach ($comentarios as $comentario): ?>
                    <div class="comentario">
                        <div class="comentario-header">
                            <strong><?php echo htmlspecialchars($comentario['nombre']); ?></strong>
                            <span class="fecha"><?php echo date('d/m/Y H:i', strtotime($comentario['fecha'])); ?></span>
                        </div>
                        <p><?php echo nl2br(htmlspecialchars($comentario['contenido'])); ?></p>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="sin-comentarios">Aún no hay comentarios. ¡Sé el primero!</p>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
