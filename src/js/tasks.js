if(document.querySelector('.new-task-container')){
  
  // Botón para agregar una nueva tarea
  const newTaskBtn = document.querySelector('#add-task');
  newTaskBtn.addEventListener('click', showForm);

  function showForm(){
    const modal = document.createElement('div');
    modal.classList.add('modal');
    modal.innerHTML = `
    <form class="form new-task">
      <legend>Añade una nueva tarea</legend>
      <div class="field">
        <label for="task">Tarea</label>
        <input 
          type="text"
          name="task"
          placeholder="Añadir tarea al proyecto actual"
          id="task"
        >
      </div>
      <div class="options">
        <input type="submit" value="Añadir tarea" class="new-task-submit">
        <button type="button" class="close-modal">Cancelar</button>
      </div>
    </form>
    `;

    setTimeout(() => {
      const form = document.querySelector('.form');
      form.classList.add('animate');
    }, 0);

    modal.addEventListener('click', function(e){
      e.preventDefault();

      if(e.target.classList.contains('close-modal')){
        const form = document.querySelector('.form');
        form.classList.add('close');
        setTimeout(() => {
          modal.remove();
        }, 500);
      }
      
    })

    document.querySelector('body').appendChild(modal);
  }

}