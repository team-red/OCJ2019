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

login.pwd.addEventListener('input', (event) => {
  if (login.pwd === ""){
    login.pwd.setCustomValidity("Empty field.");
  }
  else{
    login.pwd.setCustomValidity("");
  }
});

function isValidEmail(email) {
  return /\S+@\S+/.test(email.toLowerCase());
}

login.email.addEventListener('input', (event) => {
  let email = login.email;
  if (!isValidEmail(email.value)){
    email.setCustomValidity("Invalid email adress.");
  } else {
    email.setCustomValidity("");
  }
});