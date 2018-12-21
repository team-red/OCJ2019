window.addEventListener('load', function(){
  let forms = document.getElementsByClassName('needs-validation');
  for (let form of forms){
    form.addEventListener('submit', function (event) {
      if (form.checkValidity() === false){
        event.preventDefault();
        event.stopPropagation();
      }
      form.classList.add('was-validated');
    }, false);
  }
}, false);
