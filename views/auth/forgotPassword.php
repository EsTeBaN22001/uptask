<div class="container forgotPassword">

  <?php include_once(__DIR__ . './../templates/siteName.php'); ?>

  <div class="container-sm">
    <p class="page-description">Recupera tu acceso a UpTask</p>
    <form action="/forgot-password" class="form">
      <div class="field">
        <label for="email">Correo electrónico</label>
        <input 
          type="email"
          id="email"
          name="email"
          placeholder="Ingresa tu correo electrónico"
        >
      </div>
      <input type="submit" value="Recuperar" class="button">
    </form>
    <div class="actions">
      <a href="/">Ya tienes una cuenta? Inicia sesión</a>
      <a href="/create-account">Aún no tienes una cuenta? Crea una</a>
    </div>
  </div>
</div>