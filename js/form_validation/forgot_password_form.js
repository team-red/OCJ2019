'use strict';

let forgot = document.getElementById("forgot-form");

for (let element of forgot.elements){
  element.onfocus = (event) => {
    if (!forgot.classList.contains("was-validated")){
      forgot.classList.add("was-validated");
    }
    element.onfocus = null;
  };
}
