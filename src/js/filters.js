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