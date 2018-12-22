'use strict';

let registration = document.getElementById("registration-form");

for (let element of registration.elements) {
  element.onfocus = (event) => {
    if (!registration.classList.contains("was-validated")) {
      registration.classList.add("was-validated");
    }
    element.onfocus = null;
  };
}

registration.addEventListener('input', (event) => {
  if (registration.pwd.value !== registration.conf.value) {
    registration.pwd.setCustomValidity("Passwords do not match.");
    registration.conf.setCustomValidity("Passwords do not match.");
  } else {
    registration.pwd.setCustomValidity("");
    registration.conf.setCustomValidity("");
  }
});

registration.birthday.oninput = (event) => {
  if (registration.birthday.value === ""){
    registration.birthday.setCustomValidity("Empty Birthday.");
  }
  else {
    let bdYear = parseInt(registration.birthday.value.match(/^\d{4}/)[0]);
    let currentYear = (new Date()).getFullYear();
    if (currentYear - bdYear <= 10){
      registration.birthday.setCustomValidity("Too young.")
    }
    else{
      registration.birthday.setCustomValidity("");
    }
  }
};



function isValidEmail(email){
  return /\S+@\S+/.test(email.toLowerCase());
}

function isValidLogin(login){
  return true;
}

function emailExists(email){
  let xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function (){
    if (this.readyState == 4 && this.status == 200){
      if (this.responseText == "Not Found"){
        return false;
      } else if (this.responseText == "Found"){
        return true;
      } else{
        throw new Exception("Ajax call returning with invalid response text.");
      }
    }
  };
  xhttp.open("POST", "ajax/user_exists.php", true);
  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhttp.send("auth=email&value" + email);
}

function loginExists(login){
  let xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function (){
    if (this.readyState == 4 && this.status == 200){
      if (this.responseText == "Not Found"){
        return false;
      } else if (this.responseText == "Found"){
        return true;
      } else{
        throw new Exception("Ajax call returning with invalid response text.");
      }
    }
  };
  xhttp.open("POST", "ajax/user_exists.php", true);
  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhttp.send("auth=login&value" + login);
}

registration.login.onkeyup = (event) => {
  login.
};


registration.email.onkeyup = (event) => {
  email = registration.email;
  if (!isValidEmail(email.value)){
    email.setCustomValidity("Invalid Email adress.");
  } else{
    if (emailExists(email.value)){
      email.setCustomValidity("Email already used.");
    } else{
      email.setCustomValidity("");
    }
  }
};
