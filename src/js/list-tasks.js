if(document.querySelector('.new-task-container')){

  getTasks()

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
    
    const listTasks = document.querySelector('#list-tasks')

    if(tasks.length === 0){

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

    tasks.forEach(task=>{

      const taskContainer = document.createElement('li')
      taskContainer.dataset.id = task.id
      taskContainer.classList.add('task')
      
      const nameTask = document.createElement('p')
      nameTask.textContent = task.name

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
      
      // if(result.type === 'success'){
      //   showAlert(result.message, result.type, document.querySelector('.new-task-container'))
      // }

      // Actualizar el virtual DOM
      tasks = tasks.map(memoryTask => {

        if(memoryTask.id === id){
          memoryTask.state = state
        }

        return memoryTask

      })

      showTasks()

    }catch(error){
      console.log(error)
    }

  }

}