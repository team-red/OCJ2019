'use strict';

function isValidEmail(email) {
  return /\S+@\S+/.test(email.toLowerCase());
}

let email = document.getElementById("inputEmail");
let emailNotFound = email.value;

email.setCustomValidity("Invalid email.");
function verifyEmailNew(event){
    console.log("ewfr");
  if (!isValidEmail(email.value)){
    email.setCustomValidity("Invalid email adress.");
  } else if (email.value === emailNotFound ){
    email.setCustomValidity("Email not found.");
  } else {
    email.setCustomValidity("");
  }
}

email.autofocus = true;
verifyEmailNew(null);
email.addEventListener('input', verifyEmailNew);