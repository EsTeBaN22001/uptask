<?php include_once __DIR__ . '/header-dashboard.php'; ?>

<div class="container-sm">
<a href="/profile" class="link">Volver al perfíl</a>
  
  <?php include_once __DIR__ . '/../templates/alerts.php'; ?>

  <form action="/change-password" class="form" method="POST">
    <div class="field">
      <label for="actualPassword">Contraseña actual</label>
      <input 
        type="password"
        name="actualPassword"
        placeholder="Escribe tu contraseña actual"
        id="actualPassword"
      >
    </div>
    <div class="field">
      <label for="newPassword">Nueva contraseña</label>
      <input 
        type="password"
        name="newPassword"
        placeholder="Escribe tu nueva contraseña"
        id="newPassword"
      >
    </div>
    <input type="submit" value="Guardar contraseña">
  </form>
</div>

<?php include_once __DIR__ . '/footer-dashboard.php'; ?>