<div class="container login">

  <?php include_once(__DIR__ . './../templates/siteName.php'); ?>

  <div class="container-sm">
    <p class="page-description">Iniciar sesión</p>

    <?php include_once(__DIR__ . './../templates/alerts.php'); ?>

    <form action="/" class="form" method="POST">
      <div class="field">
        <label for="email">Correo electrónico</label>
        <input 
          type="email"
          id="email"
          name="email"
          placeholder="Ingresa tu correo electrónico"
          value="<?= $user->email; ?>"
        >
      </div>
      <div class="field">
        <label for="password">Contraseña</label>
        <input 
          type="password"
          id="password"
          name="password"
          placeholder="Ingresa tu contraseña"
        >
      </div>
      <input type="submit" value="Iniciar sesión" class="button">
    </form>
    <div class="actions">
      <a href="/create-account">Aún no tienes cuenta? Crear una</a>
      <a href="/forgot-password">¿Olvidaste tu contraseña?</a>
    </div>
  </div>
</div>