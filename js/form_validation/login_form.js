'use strict';

let login = document.getElementById("login-form");

for (let element of login.elements){
  element.onfocus = (event) => {
    if (!login.classList.contains("was-validated")){
      login.classList.add("was-validated");
    }
    element.onfocus = null;
  };
}

login.addEventListener('input', (event) => {
  if (login.pwd === ""){
    login.pwd.setCustomValidity("Empty field.");
  }
  else{
    login.pwd.setCustomValidity("");
  }
});
