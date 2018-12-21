// Sidenav JavaScript code
function openNav(){
          document.getElementById("side-bar").style.left = "-15rem";
          document.getElementById("side-bar").style.width = "15rem";
          document.getElementById("side-bar").style.left = "0";
          document.getElementById("dark").style.display = "block";
          document.body.style.backgroundColor = "rgba(0,0,0,0.4)";
        }
function closeNav(){
          document.getElementById("side-bar").style.width = "0";
          document.getElementById("dark").style.display = "none";
          document.body.style.backgroundColor = "white";
        }
