// Sidenav JavaScript code
function openNav(){
  sidebar_size = window.getComputedStyle(document.body).getPropertyValue('--sidebar_size');
  document.getElementById("side-bar").style.width = sidebar_size;
  document.getElementById("dark").style.display = "block";
  }
function closeNav(){
  document.getElementById("side-bar").style.width = "0";
  document.getElementById("dark").style.display = "none";
}
