<?php include_once __DIR__ . './header-dashboard.php'; ?>

<div class="container-sm">
  <a href="/change-password" class="link">Cambiar contraseña</a>

  <?php include_once __DIR__ . './../templates/alerts.php'; ?>

  <form action="/profile" class="form" method="POST">
    <div class="field">
      <label for="name">Nombre</label>
      <input 
        type="text"
        value="<?= $user->name !== '' ? $user->name : ''; ?>"
        name="name"
        placeholder="Escribe tu nombre"
        id="name"
      >
    </div>
    <div class="field">
      <label for="email">Correo electrónico</label>
      <input 
        type="email"
        value="<?= $user->email !== '' ? $user->email : ''; ?>"
        name="email"
        placeholder="Escribe tu correo"
        id="email"
      >
    </div>
    <input type="submit" value="Guardar cambios">
  </form>
</div>

<?php include_once __DIR__ . './footer-dashboard.php'; ?>