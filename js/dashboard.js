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


// Myinfo tabs JavaScript code
function rank_tab(){
  document.getElementById("myinfo_quiz_tabs_rank").style.display = "block";
  document.getElementById("myinfo_quiz_tab_rank").className = "selected_tab";
  document.getElementById("myinfo_quiz_tabs_done").style.display = "none";
  document.getElementById("myinfo_quiz_tab_done").className = "";
}
function done_tab(){
  document.getElementById("myinfo_quiz_tabs_done").style.display = "block";
  document.getElementById("myinfo_quiz_tab_done").className = "selected_tab";
  document.getElementById("myinfo_quiz_tabs_rank").style.display = "none";
  document.getElementById("myinfo_quiz_tab_rank").className = "";
}
$(function(){rank_tab()}); //on document ready
