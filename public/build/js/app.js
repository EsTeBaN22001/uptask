
if(document.querySelector('.new-task-container')){

  // Ruta para las peticiones fetch hacia la api
  const domain = 'http://localhost:3000';
  
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

      if(e.target.classList.contains('new-task-submit')){
        newTaskSubmitForm();
      }
      
    })

    document.querySelector('.dashboard').appendChild(modal);
  }

  function newTaskSubmitForm(){
    const task = document.querySelector('#task').value.trim();
    
    if(task == ''){
      // Mostrar una alerta de error
      showAlert('El nombre de la tarea es obligatorio', 'error', document.querySelector('legend'));

      return;
    }

    addTask(task);
  }

  // Muestra un mensaje en la interfaz
  function showAlert(message, type, reference){

    // Prevenir multiples alertas
    const previousAlert = document.querySelector('.alert');
    if(previousAlert){
      previousAlert.remove();
    }
    
    const alert = document.createElement('div');
    alert.classList.add('alert', type);
    alert.textContent = message;

    reference.parentElement.insertBefore(alert, reference.nextElementSibling);

    // Eliminar la alerta después de 5 segundos
    setTimeout(()=>{
      alert.remove();
    }, 5000);

  }

  // Consultar al servidor para añadir una nueva tarea al proyecto actual
  async function addTask(task){
    
    const data = new FormData();
    data.append('proyectId', getProyect());
    data.append('name', task);

    try {

      const url = `${domain}/api/task/create`;
      const response = await fetch(url, {
        method: 'POST',
        body: data
      });
      
      const result = await response.json();

      // Mostrar el mensaje de la respuesta
      showAlert(result.message, result.type, document.querySelector('legend'));

      // Si se agregó correctamente cerrar el modal
      if(result.type === 'success'){
        const modal = document.querySelector('.modal');
        setTimeout(() => {
          modal.remove();
        }, 3000);
      }

    } catch (error) {
      console.log(error);
    }

  }

  function getProyect(){
    const proyectParams = new URLSearchParams(window.location.search);
    const proyect = Object.fromEntries(proyectParams.entries());
    return proyect.url;
  }

}