<div class="container resetPassword">

  <?php include_once(__DIR__ . './../templates/siteName.php'); ?>

  <div class="container-sm">
    <p class="page-description">Coloca tu nueva contraseña</p>

    <form action="/reset-password" class="form">
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
    <div class="actions">
      <a href="/create-account">Aún no tienes cuenta? Crear una</a>
      <a href="/forgot-password">¿Olvidaste tu contraseña?</a>
    </div>
  </div>
</div>