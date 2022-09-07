import './bootstrap';

import Alpine from 'alpinejs';

// window.Alpine = Alpine;

Alpine.start();

// change type input 
Array.from(document.querySelectorAll('.eye-input')).forEach(parentInput => {
  parentInput.querySelector('i').addEventListener('click',e => {
    if(parentInput.querySelector('input').type === 'text'){
      parentInput.querySelector('input').type = 'password'
      e.target.classList.replace('fa-eye-slash','fa-eye')
    }else{
      parentInput.querySelector('input').type = 'text'
      e.target.classList.replace('fa-eye','fa-eye-slash')
    }
  })
})
