
// Ruta para las peticiones fetch hacia la api
const domain = 'http://localhost:3000';

// Objeto global de las tareas
let tasks = [];

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

        // Agregar el objeto de tarea al global de tareas
        const taskObj = {
          id: String(result.id),
          name: task,
          state: '0',
          proyectId: result.proyectId
        }

        tasks = [...tasks, taskObj];
        showTasks();

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
if(document.querySelector('.new-task-container')){

  getTasks();

  async function getTasks(){

    try{

      const urlProyect = getProyect();
      const url = `${domain}/api/tasks?url=${urlProyect}`;
      
      const response = await fetch(url);
      const result = await response.json();

      tasks = result.tasks;

      showTasks();

    }catch(error){
      console.log(error)
    }

  }

  function showTasks(){

    // Eliminar las tareas anteriores para volver a generar el html con las mismas
    cleanTasks();
    
    const listTasks = document.querySelector('#list-tasks');

    if(tasks.length === 0){

      const noTasksText = document.createElement('li');
      noTasksText.classList.add('no-tasks');
      noTasksText.textContent = 'No hay tareas';

      listTasks.appendChild(noTasksText);

      return;

    }

    const state = {
      0: 'Pendiente',
      1: 'Completa'
    }

    tasks.forEach(task=>{

      const taskContainer = document.createElement('li');
      taskContainer.dataset.id = task.id;
      taskContainer.classList.add('task');
      
      const nameTask = document.createElement('p');
      nameTask.textContent = task.name;

      const optionsDiv = document.createElement('div');
      optionsDiv.classList.add('options');

      // Buttons
      const btnTaskStatus = document.createElement('button');
      btnTaskStatus.classList.add('task-status');
      btnTaskStatus.classList.add(`${state[task.state].toLowerCase()}`);
      btnTaskStatus.textContent = state[task.state];
      btnTaskStatus.dataset.taskState = task.state;

      const btnTaskDelete = document.createElement('button')
      btnTaskDelete.classList.add('delete-task');
      btnTaskDelete.dataset.idTask = task.id;
      btnTaskDelete.textContent = 'Eliminar';

      optionsDiv.appendChild(btnTaskStatus);
      optionsDiv.appendChild(btnTaskDelete);
      taskContainer.appendChild(nameTask);
      taskContainer.appendChild(optionsDiv);

      listTasks.appendChild(taskContainer);

    })

  }

  function cleanTasks(){

    const listTasks = document.querySelector('#list-tasks');

    while(listTasks.firstChild){
      listTasks.removeChild(listTasks.firstChild);
    }

  }

}