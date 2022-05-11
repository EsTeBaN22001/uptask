<div class="mobile-bar">
  <a href="/dashboard">
    <h1>UpTask</h1>
  </a>
  <div class="menu" id="menu">
    <img id="mobile-menu" src="/build/img/menu.svg" alt="Ícono del menú mobil">
  </div>
</div>

<div class="bar">
  <p>Hola: <a href="/profile"><span><?= $_SESSION['name']; ?></span></a></p>
  <a href="/logout" class="logout">Cerrar sesión</a>
</div>