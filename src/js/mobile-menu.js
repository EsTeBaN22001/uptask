if(document.querySelector('.mobile-bar')){

  const mobileMenuButton = document.querySelector('#menu')
  const sidebar = document.querySelector('.sidebar')
  
  if(mobileMenuButton){
    mobileMenuButton.addEventListener('click', function(){
      sidebar.classList.toggle('show')
    })
  }
  
}