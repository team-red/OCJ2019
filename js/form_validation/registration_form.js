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

registration.email.onkeyup = (event) => {
  let xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      if (/\S+@\S+/.test(registration.email.value.toLowerCase()) && this.responseText == "Not Found") {
        registration.email.setCustomValidity("");
      } else {
        registration.email.setCustomValidity("Invalid Email.");
      }
    }
  };
  xhttp.open("POST", "utils/ajax/user_exists.php", true);
  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhttp.send("auth=email&value=" + registration.email.value);
};

registration.login.onkeyup = (event) => {
  let xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      if (registration.login.value !== "" && this.responseText == "Not Found") {
        registration.login.setCustomValidity("");
      } else {
        registration.login.setCustomValidity("Invalid Login.");
      }
    }
  };
  xhttp.open("POST", "utils/ajax/user_exists.php", true);
  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhttp.send("auth=login&value=" + registration.login.value);
};
