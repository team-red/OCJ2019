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


// Myinfo tabs JavaScript code   !!!!! Add if exists !!!!!
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
$(function(){
  if(document.getElementById("table_quiz") != null){
    rank_tab();
    unShowQuiz(10);
  }
}); //on document ready

// show/unShows quizes on quiz tabs
function showQuiz(numQuiz){
  var quizId = "quiz_" + numQuiz;
  document.getElementById("table_quiz").style.display = "none";
  document.getElementById(quizId).style.display = "block";
}
function unShowQuiz(num){
  document.getElementById("table_quiz").style.display = "table";
  for(var i = 1 ; i < num+1 ; i++){
    var quizId = "quiz_" + i;
    document.getElementById(quizId).style.display = "none";
  }
}
