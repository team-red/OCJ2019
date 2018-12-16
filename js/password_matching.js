'use strict';

let pwd = document.getElementById("inputPassword");
let cnf = document.getElementById("inputPasswordConfirmation");

function validatePassword(){
  if(pwd.value != cnf.value) {
    cnf.setCustomValidity("Passwords Don't Match");
  } else {
    cnf.setCustomValidity('');
  }
}

pwd.onchange = validatePassword;
cnf.onkeyup = validatePassword;
