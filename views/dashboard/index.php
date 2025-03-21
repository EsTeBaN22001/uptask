<?php include_once __DIR__ . '/header-dashboard.php'; ?>

<?php if(count($proyects) === 0): ?>
  <p class="no-proyects">No hay proyectos aún <a href="/create-proyect">Crear un proyecto.</a></p>
<?php else: ?>
  <ul class="list-proyects">
    <?php foreach($proyects as $proyect): ?>
      <li class="proyect">
        <a href="/proyect?url=<?= $proyect->url; ?>"><?= $proyect->proyect; ?></a>
      </li>
    <?php endforeach; ?>
  </ul>
<?php endif; ?>

<?php include_once __DIR__ . '/footer-dashboard.php'; ?>