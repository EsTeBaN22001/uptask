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

        // showAlert(
        //   result.message, 
        //   result.type, 
        //   document.querySelector('.new-task-container')
        // )

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