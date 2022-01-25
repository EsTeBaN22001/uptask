<div class="container createAccount">

  <?php include_once __DIR__ . './../templates/siteName.php'; ?>

  <div class="container-sm">
    <p class="page-description">Crea tu cuenta en upTask</p>

    <?php include_once __DIR__ . './../templates/alerts.php'; ?>

    <form action="/create-account" class="form" method="POST">
      <div class="field">
        <label for="name">Nombre</label>
        <input 
          type="text"
          id="name"
          name="name"
          placeholder="Ingresa tu nombre"
          value="<?= $user->name; ?>"
        >
      </div>
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
      <div class="field">
        <label for="password2">Repetir contraseña</label>
        <input 
          type="password"
          id="password2"
          name="password2"
          placeholder="Repetir contraseña"
        >
      </div>
      <div class="field">
        <label for="keyword">Palabra clave</label>
        <input 
          type="password"
          id="keyword"
          name="keyword"
          placeholder="Palabra clave"
        >
      </div>
      <span>*Palabra clave en caso de olvidar la contraseña</span>
      <input type="submit" value="Crear cuenta" class="button">
    </form>
    <div class="actions">
      <a href="/">Ya tienes una cuenta? Inicia sesión</a>
      <a href="/forgot-password">¿Olvidaste tu contraseña?</a>
    </div>
  </div>
</div>