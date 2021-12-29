<div class="container resetPassword">

  <?php include_once(__DIR__ . './../templates/siteName.php'); ?>

  <div class="container-sm">
    <p class="page-description">Coloca tu nueva contraseña</p>

    <?php include_once(__DIR__ . './../templates/alerts.php'); ?>

    <?php if($showInputPassword): ?>
      <form method="POST" class="form">
        <div class="field">
          <label for="password">Contraseña</label>
          <input 
            type="password"
            id="password"
            name="password"
            placeholder="Ingresa tu contraseña"
          >
        </div>
        <input type="submit" value="Reestablecer" class="button">
      </form>
    <?php endif; ?>
    <div class="actions">
      <a href="/create-account">Aún no tienes cuenta? Crear una</a>
      <a href="/forgot-password">¿Olvidaste tu contraseña?</a>
    </div>
  </div>
</div>