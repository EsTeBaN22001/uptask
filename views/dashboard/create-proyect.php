<?php include_once __DIR__ . '/header-dashboard.php'; ?>

  <div class="container-sm">
    <?php include_once __DIR__ . '/../templates/alerts.php'; ?>

    <form class="form" method="POST">
      <?php include_once __DIR__ . '/form-proyect.php'; ?>
      <input type="submit" value="Crear proyecto" class="button">
    </form>
  </div>

<?php include_once __DIR__ . '/footer-dashboard.php'; ?>