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