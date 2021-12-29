<div class="container createAccount">

  <?php include_once(__DIR__ . './../templates/siteName.php'); ?>

  <div class="container-sm">
    <p class="page-description">Crea tu cuenta en upTask</p>

    <form action="/create-account" class="form">
      <div class="field">
        <label for="name">Nombre</label>
        <input 
          type="text"
          id="name"
          name="name"
          placeholder="Ingresa tu nombre"
        >
      </div>
      <div class="field">
        <label for="email">Correo electrónico</label>
        <input 
          type="email"
          id="email"
          name="email"
          placeholder="Ingresa tu correo electrónico"
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
      <div class="field">
        <label for="password2">Repetir contraseña</label>
        <input 
          type="password"
          id="password2"
          name="password2"
          placeholder="Repetir contraseña"
        >
      </div>
      <input type="submit" value="Crear cuenta" class="button">
    </form>
    <div class="actions">
      <a href="/">Ya tienes una cuenta? Inicia sesión</a>
      <a href="/forgot-password">¿Olvidaste tu contraseña?</a>
    </div>
  </div>
</div>