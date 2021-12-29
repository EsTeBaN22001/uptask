<div class="container forgotPassword">

  <?php include_once(__DIR__ . './../templates/siteName.php'); ?>

  <div class="container-sm">
    <p class="page-description">Recupera tu acceso a UpTask</p>
    <?php include_once(__DIR__ . './../templates/alerts.php'); ?>
    <form action="/forgot-password" class="form" method="POST">
      <div class="field">
        <label for="email">Correo electrónico</label>
        <input 
          type="email"
          id="email"
          name="email"
          placeholder="Ingresa tu correo electrónico"
        >
      </div>
      <input type="submit" value="Enviar instrucciones" class="button">
    </form>
    <div class="actions">
      <a href="/">Ya tienes una cuenta? Inicia sesión</a>
      <a href="/create-account">Aún no tienes una cuenta? Crea una</a>
    </div>
  </div>
</div>