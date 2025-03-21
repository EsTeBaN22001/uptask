<?php include_once __DIR__ . '/header-dashboard.php'; ?>

  <div class="container-sm">
    <div class="new-task-container">
      <button
        type="button"
        class="add-task"
        id="add-task"
      >&#43; Nueva tarea</button>
    </div>
    <div class="filters" id="filters">
      <div class="input-filters">
        <h2>Filtros:</h2>
        <div class="field">
          <label for="all">Todas</label>
          <input 
          type="radio"
          id="all"
          name="filter"
          value=""
          checked
          >
        </div>
        <div class="field">
          <label for="completed">Completas</label>
          <input 
          type="radio"
          id="completed"
          name="filter"
          value="1"
          >
        </div>
        <div class="field">
          <label for="pending">Pendientes</label>
          <input 
          type="radio"
          id="pending"
          name="filter"
          value="0"
          >
        </div>
      </div>
    </div>
    <ul class="list-tasks" id="list-tasks"></ul>
  </div>

<?php include_once __DIR__ . '/footer-dashboard.php'; ?>