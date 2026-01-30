<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<section class="auth-section">
    <div class="auth-card">
        <h1>Iniciar Sesión</h1>

        <?php if (isset($error)): ?>
            <div class="alerta error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <form method="POST" action="index.php?controller=auth&action=login" id="form-login">
            <div class="form-grupo">
                <label for="email">Correo electrónico</label>
                <input type="email" id="email" name="email" required>
            </div>

            <div class="form-grupo">
                <label for="password">Contraseña</label>
                <input type="password" id="password" name="password" required>
            </div>

            <button type="submit" class="btn-submit">Entrar</button>
        </form>

        <p class="auth-link">
            ¿No tienes cuenta? <a href="index.php?controller=auth&action=registro">Regístrate aquí</a>
        </p>
    </div>
</section>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
