// Ruta para las peticiones fetch hacia la api
const domain = 'http://localhost:3000'

// Objeto global de las tareas
let tasks = []
// Objeto global para las tareas filtradas
let filtered = []

if(document.querySelector('.new-task-container')){

  
  // Botón para agregar una nueva tarea
  const newTaskBtn = document.querySelector('#add-task')
  newTaskBtn.addEventListener('click', function(){
    showForm(false)
  })

}

function showForm(edit = false, task){
  const modal = document.createElement('div')
  modal.classList.add('modal')
  modal.innerHTML = `
  <form class="form new-task">
    <legend>${edit ? 'Editar tarea' : 'Añade una nueva tarea'}</legend>
    <div class="field">
      <label for="task">Tarea</label>
      <input 
        type="text"
        name="task"
        placeholder="${edit ? 'Editar nombre de la tarea' : 'Añadir tarea al proyecto actual'}"
        id="task"
        value="${edit ? task.name : ''}"
        focus
      >
    </div>
    <div class="options">
      <input 
      type="submit" 
      value="${edit ? 'Guardar cambios' : 'Añadir tarea'}" 
      class="new-task-submit"
      >
      <button type="button" class="close-modal">Cancelar</button>
    </div>
  </form>
  `

  setTimeout(() => {
    const form = document.querySelector('.form')
    form.classList.add('animate')
  }, 0)

  modal.addEventListener('click', function(e){
    e.preventDefault()

    if(e.target.classList.contains('close-modal')){
      const form = document.querySelector('.form')
      form.classList.add('close')
      setTimeout(() => {
        modal.remove()
      }, 500)
    }

    if(e.target.classList.contains('new-task-submit')){

      const nameTask = document.querySelector('#task').value.trim()
  
      if(nameTask == ''){
        // Mostrar una alerta de error
        showAlert('El nombre de la tarea es obligatorio', 'error', document.querySelector('legend'))
  
        return
      }

      if(edit){
        task.name = nameTask
        updateTask(task)
      }else{
        addTask(nameTask)
      }

    }
    
  })

  document.querySelector('.dashboard').appendChild(modal)
}

// Muestra un mensaje en la interfaz
function showAlert(message, type, reference){

  // Prevenir multiples alertas
  const previousAlert = document.querySelector('.alert')
  if(previousAlert){
    previousAlert.remove()
  }
  
  const alert = document.createElement('div')
  alert.classList.add('alert', type)
  alert.textContent = message

  reference.parentElement.insertBefore(alert, reference.nextElementSibling)

  // Eliminar la alerta después de 5 segundos
  setTimeout(()=>{
    alert.remove()
  }, 5000)

}

// Consultar al servidor para añadir una nueva tarea al proyecto actual
async function addTask(task){
  
  const data = new FormData()
  data.append('proyectId', getProyect())
  data.append('name', task)

  try {

    const url = `${domain}/api/task/create`
    const response = await fetch(url, {
      method: 'POST',
      body: data
    })
    
    const result = await response.json()

    // Mostrar el mensaje de la respuesta
    showAlert(result.message, result.type, document.querySelector('legend'))

    // Si se agregó correctamente cerrar el modal
    if(result.type === 'success'){
      const modal = document.querySelector('.modal')
      setTimeout(() => {
        modal.remove()
      }, 3000)

      // Agregar el objeto de tarea al global de tareas
      const taskObj = {
        id: String(result.id),
        name: task,
        state: '0',
        proyectId: result.proyectId
      }

      tasks = [...tasks, taskObj]
      showTasks()

    }

  } catch (error) {
    console.log(error)
  }

}

function getProyect(){
  const proyectParams = new URLSearchParams(window.location.search)
  const proyect = Object.fromEntries(proyectParams.entries())
  return proyect.url
}