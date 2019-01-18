'use strict';

let registration = document.getElementById("registration-form");

/*
  Only start continuously provide real-time feedback when the form gets
  focus for the first time.
*/

for (let element of registration.elements) {
  element.onfocus = (event) => {
    if (!registration.classList.contains("was-validated")) {
      registration.classList.add("was-validated");
    }
    element.onfocus = null;
  };
}

/*
  Email validation, we use a simple regex for email validation and an AJAX call
  to verify the adress is available.
*/

function isValidEmail(email) {
  return /\S+@\S+/.test(email.toLowerCase());
}


function emailCheck(event) {
  let email = registration.email;
  if (email.value === "") {
    document.getElementById("email-invalid-feedback").textContent = "";
  } else if (!isValidEmail(email.value)) {
    email.setCustomValidity("Invalid Email adress.");
    document.getElementById("email-invalid-feedback").textContent = "Adresse email invalide.";
  } else {
    let xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        if (this.responseText == "Not Found") {
          email.setCustomValidity("");
          document.getElementById("email-invalid-feedback").textContent = "";
        } else if (this.responseText == "Found") {
          email.setCustomValidity("Email already used.");
          document.getElementById("email-invalid-feedback").textContent = "Adresse déjà utilisée.";
        } else {
          throw new Error("Ajax call returning with invalid response text.");
        }
      }
    };
    xhttp.open("POST", "utils/ajax/user_exists.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("auth=email&value=" + email.value);
  }
}

registration.email.addEventListener("input", emailCheck);

/*
  password validation: provie feedback to user and invalidate the form when
                      - password and confirmation don't match
                      - password is too weak (we use the zxcvbn open source library by dropbox with a minimal
                        strength level of 2 (levels go from 0 to 4)
                        you can modify this setting with the variable minimalStrength)
*/

function validatePasswords(pwd, conf) {
  const minimalStrength = 1;
  if (pwd.value !== conf.value) {
    pwd.setCustomValidity("Passwords do not match");
    conf.setCustomValidity("Passwords do not match");
    document.getElementById("conf-invalid-feedback").textContent = "Les mots de passes ne correspondent pas.";
  } else if (pwd.value === "" ) {
    document.getElementById("conf-invalid-feedback").textContent = "";
  } else if (zxcvbn(pwd.value).score < minimalStrength) {
    pwd.setCustomValidity("Weak password");
    conf.setCustomValidity("Weak password");
    document.getElementById("conf-invalid-feedback").textContent = "Mot de passe faible.";
  } else {
    registration.pwd.setCustomValidity("");
    registration.conf.setCustomValidity("");
    document.getElementById("conf-invalid-feedback").textContent = "";
  }
}

registration.pwd.addEventListener("input", function (event) {
  let pwd = registration.pwd;
  let conf = registration.conf;
  validatePasswords(pwd, conf);
});

registration.conf.addEventListener("input", function (event) {
  let pwd = registration.pwd;
  let conf = registration.conf;
  validatePasswords(pwd, conf);
});

/*
  login validation, analoguous to email validation
*/


function isValidLogin(login) {
  // insert any more logic here
  return /^[a-zA-Z0-9_]{4,32}$/.test(login);
}

function loginCheck(event){
  let login = registration.login;
  if (login === ""){
    document.getElementById("login-invalid-feedback").textContent = "";
  } else if (!isValidLogin(login.value)){
    login.setCustomValidity("Invalid login.");
    document.getElementById("login-invalid-feedback").textContent = "4 à 32 caractères: lettres, chiffres et _ uniquement.";
  } else {
    let xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200){
        if (this.responseText == "Not Found"){
          login.setCustomValidity("");
          document.getElementById("login-invalid-feedback").textContent = "";
        } else if (this.responseText == "Found") {
          login.setCustomValidity("Login already used.");
          document.getElementById("login-invalid-feedback").textContent = "Pseudo déjà utilisé.";
        } else {
          throw new Error("Ajax call returning with invalid response text.");
        }
      }
    };
    xhttp.open("POST", "utils/ajax/user_exists.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("auth=login&value=" + login.value);
  }
}

registration.login.addEventListener("input", loginCheck);

/*
  birthday validation
*/

function birthdayCheck(event){
  let birthday = registration.birthday;
  if (birthday.value === "") {
    birthday.setCustomValidity("Empty Birthday.");
    document.getElementById("birthday-invalid-feedback").textContent = "";
  } else {
    let bdYear = parseInt(birthday.value.match(/^\d{4}/)[0]);
    let currentYear = (new Date()).getFullYear();
    if (currentYear <= bdYear) {
      birthday.setCustomValidity("Too young.");
      document.getElementById("birthday-invalid-feedback").textContent = "Date de naissance invalide";
    } else {
      birthday.setCustomValidity("");
      document.getElementById("birthday-invalid-feedback").textContent = "";
    }
  }
}

registration.birthday.addEventListener("input", birthdayCheck);