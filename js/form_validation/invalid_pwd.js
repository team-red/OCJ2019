'use strict';

let pwd = document.getElementById("inputPassword");

pwd.setCustomValidity("Wrong Password.");

pwd.autofocus = true;

let cnf = document.getElementById("inputPasswordConfirmation");

if (cnf !== null){
  cnf.setCustomValidity("Wrong Password.");
}
