<?php include_once __DIR__ . '/header-dashboard.php'; ?>

<div class="container-sm">
<a href="/profile" class="link">Volver al perfíl</a>
  
  <?php include_once __DIR__ . '/../templates/alerts.php'; ?>

  <form action="/change-keyword" class="form" method="POST">
    <div class="field">
      <label for="keyword">Palabra clave</label>
      <input 
        type="password"
        name="keyword"
        placeholder="Escribe tu nueva palabra clave"
        id="keyword"
      >
    </div>
    <input type="submit" value="Guardar">
  </form>
</div>

<?php include_once __DIR__ . '/footer-dashboard.php'; ?>