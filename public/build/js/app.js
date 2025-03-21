
// Ruta para las peticiones fetch hacia la api
const domain = 'http://uptask.infinityfreeapp.com'

// Objeto global de las tareas
let tasks = []
// Objeto global para las tareas filtradas
let filtered = []

if (document.querySelector('.new-task-container')) {
  // Botón para agregar una nueva tarea
  const newTaskBtn = document.querySelector('#add-task')
  newTaskBtn.addEventListener('click', function () {
    showForm(false)
  })
}

function showForm(edit = false, task) {
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

  modal.addEventListener('click', function (e) {
    e.preventDefault()

    if (e.target.classList.contains('close-modal')) {
      const form = document.querySelector('.form')
      form.classList.add('close')
      setTimeout(() => {
        modal.remove()
      }, 500)
    }

    if (e.target.classList.contains('new-task-submit')) {
      const nameTask = document.querySelector('#task').value.trim()

      if (nameTask == '') {
        // Mostrar una alerta de error
        showAlert('El nombre de la tarea es obligatorio', 'error', document.querySelector('legend'))

        return
      }

      if (edit) {
        task.name = nameTask
        updateTask(task)
      } else {
        addTask(nameTask)
      }
    }
  })

  document.querySelector('.dashboard').appendChild(modal)
}

// Muestra un mensaje en la interfaz
function showAlert(message, type, reference) {
  // Prevenir multiples alertas
  const previousAlert = document.querySelector('.alert')
  if (previousAlert) {
    previousAlert.remove()
  }

  const alert = document.createElement('div')
  alert.classList.add('alert', type)
  alert.textContent = message

  reference.parentElement.insertBefore(alert, reference.nextElementSibling)

  // Eliminar la alerta después de 5 segundos
  setTimeout(() => {
    alert.remove()
  }, 5000)
}

// Consultar al servidor para añadir una nueva tarea al proyecto actual
async function addTask(task) {
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
    if (result.type === 'success') {
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

function getProyect() {
  const proyectParams = new URLSearchParams(window.location.search)
  const proyect = Object.fromEntries(proyectParams.entries())
  return proyect.url
}

if(document.querySelector('.new-task-container')){

  function confirmDeleteTask(task){
    Swal.fire({
      title: '¿Eliminar tarea?',
      showCancelButton: true,
      confirmButtonText: 'Si',
      cancelButtonText: 'No'
    }).then((result) => {
      /* Read more about isConfirmed, isDenied below */
      if (result.isConfirmed) {
        deleteTask(task)
      }
    })
  }

  async function deleteTask(task){

    const {state, id, name} = task
    
    const data = new FormData()
    data.append('id', id)
    data.append('name', name)
    data.append('state', state)
    data.append('proyectId', getProyect())

    try {
      
      const url = `${domain}/api/task/delete`
      const response = await fetch(url, {
        method: 'post',
        body: data
      })
      const result = await response.json()
      
      if(result.result){

        Swal.fire('Eliminado!', result.message, 'success')
          .then(()=>{
            tasks = tasks.filter( memoryTask => memoryTask.id !== task.id)
            showTasks()
          })


      }

    } catch (error) {
      console.log(error)
    }

  }

}
if(document.querySelector('.filters')){

  const filters = document.querySelectorAll('#filters input[type="radio"]')

  filters.forEach( radio => {
    radio.addEventListener('input', taskFilter)
  })

}

function taskFilter(e){
  
  const filter = e.target.value

  if(filter !== ''){

    filtered = tasks.filter( task => task.state === filter)
    
    showTasks()

  }else{

    filtered = []

  }

}
if(document.querySelector('.new-task-container')){

  getTasks()

}

async function getTasks(){

  try{

    const urlProyect = getProyect()
    const url = `${domain}/api/tasks?url=${urlProyect}`
    
    const response = await fetch(url)
    const result = await response.json()

    tasks = result.tasks

    showTasks()

  }catch(error){
    console.log(error)
  }

}

function showTasks(){

  // Eliminar las tareas anteriores para volver a generar el html con las mismas
  cleanTasks()

  // Calcular el total de las tareas pendientes
  pendingTotal()

  // Calcular el total de las tareas completas
  completedTotal()

  const tasksArray = filtered.length ? filtered : tasks;  
  
  const listTasks = document.querySelector('#list-tasks')

  if(tasksArray.length === 0){

    const noTasksText = document.createElement('li')
    noTasksText.classList.add('no-tasks')
    noTasksText.textContent = 'No hay tareas'

    listTasks.appendChild(noTasksText)

    return

  }

  const state = {
    0: 'Pendiente',
    1: 'Completa'
  }

  tasksArray.forEach(task=>{

    const taskContainer = document.createElement('li')
    taskContainer.dataset.id = task.id
    taskContainer.classList.add('task')
    
    const nameTask = document.createElement('p')
    nameTask.textContent = task.name
    nameTask.onclick = function(){
      showForm(true, {...task})
    }

    const optionsDiv = document.createElement('div')
    optionsDiv.classList.add('options')

    // Buttons
    const btnTaskStatus = document.createElement('button')
    btnTaskStatus.classList.add('task-status')
    btnTaskStatus.classList.add(`${state[task.state].toLowerCase()}`)
    btnTaskStatus.textContent = state[task.state]
    btnTaskStatus.dataset.taskState = task.state
    btnTaskStatus.onclick = function(){
      changeState({...task})
    }

    const btnTaskDelete = document.createElement('button')
    btnTaskDelete.classList.add('delete-task')
    btnTaskDelete.dataset.idTask = task.id
    btnTaskDelete.textContent = 'Eliminar'
    btnTaskDelete.onclick = function(){
      confirmDeleteTask({...task})
    }

    optionsDiv.appendChild(btnTaskStatus)
    optionsDiv.appendChild(btnTaskDelete)
    taskContainer.appendChild(nameTask)
    taskContainer.appendChild(optionsDiv)

    listTasks.appendChild(taskContainer)

  })

}

function cleanTasks(){

  const listTasks = document.querySelector('#list-tasks')

  while(listTasks.firstChild){
    listTasks.removeChild(listTasks.firstChild)
  }

}

function pendingTotal(){

  const pendingTotal = tasks.filter( task => task.state === "0")

  const pendingRadioButton = document.querySelector('#pending')

  if(pendingTotal.length === 0){
    pendingRadioButton.disabled = true;
  }else{
    pendingRadioButton.disabled = false;
  }

}

function completedTotal(){

  const completedTotal = tasks.filter( task => task.state === "1")

  const completedRadioButton = document.querySelector('#completed')

  if(completedTotal.length === 0){
    completedRadioButton.disabled = true;
  }else{
    completedRadioButton.disabled = false;
  }

}
if(document.querySelector('.mobile-bar')){

  const mobileMenuButton = document.querySelector('#menu')
  const sidebar = document.querySelector('.sidebar')
  
  if(mobileMenuButton){
    mobileMenuButton.addEventListener('click', function(){
      sidebar.classList.toggle('show')
    })
  }
  
}

function changeState(task){
  const newState = task.state === '1' ? '0' : '1'
  task.state = newState
  updateTask(task)
}

async function updateTask(task){
  
  const {id, name, state, proyectId} = task
  
  const data = new FormData()
  data.append('id', id)
  data.append('name', name)
  data.append('state', state)
  data.append('proyectId', getProyect())

  try{

    const url = `${domain}/api/task/update`
    const response = await fetch(url, {
      method: 'POST',
      body: data
    })
    const result = await response.json()
    
    if(result.type === 'success'){

      Swal.fire(
        result.message,
        '',
        'success'
      )

      const modal = document.querySelector('.modal')
      
      if(modal){
        modal.remove()
      }

      // Actualizar el virtual DOM
      tasks = tasks.map(memoryTask => {

        if(memoryTask.id === id){
          memoryTask.state = state
          memoryTask.name = name
        }

        return memoryTask

      })

      showTasks()

    }

  }catch(error){
    console.log(error)
  }

}