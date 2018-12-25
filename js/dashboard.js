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

//Automaticly lighter or darken the color of the pages in the sidebar starting from the color set on css : no need to put any rgbs on javascript

function LightenDarkenColor(r,g,b,ratio){
    return "rgb("+ parseInt(r*ratio) +", "+ parseInt(g*ratio) +", "+ parseInt(b*ratio) +")";
}

function page_hovered(element){
  style = window.getComputedStyle(element),
  color = style.getPropertyValue('color');
  var rgb = color.slice(4,-1).split(", ");
  var newColor = LightenDarkenColor(parseInt(rgb[0]),parseInt(rgb[1]),parseInt(rgb[2]),0.8);
  element.style.color = newColor;
}

function page_mouseout(element){
  style = window.getComputedStyle(element),
  color = style.getPropertyValue('color');
  var rgb = color.slice(4,-1).split(", ");
  var newColor = LightenDarkenColor(parseInt(rgb[0]),parseInt(rgb[1]),parseInt(rgb[2]),1.25);
  element.style.color = newColor;
}
