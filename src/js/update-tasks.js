
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