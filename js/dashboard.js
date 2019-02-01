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

// chat

function getSeeMore(type){
    $("#chat_body_container").css("width","55%");
    $(".chat_link").css("background-color","");
    $(".chat_link").css("color","");
    $("#chat_seemore_container").css("display","");
    $.ajax({
        url: "utils/ajax/get_seemore.php", // URL de la page
        type: "POST", // GET ou POST
        data: {type: type}, // Paramètres envoyés à php
        dataType: "html", // Données en retour
        success: function (response) {
            switch (type){
              case 1:
                $("#msg_from_admin_web").css("background-color","rgb(79, 85, 102)");
                $("#msg_from_admin_web").css("color","white");
                break;
              case 2:
                $("#msg_in_web").css("background-color","rgb(79, 85, 102)");
                $("#msg_in_web").css("color","white");
                break;
              case 3:
                $("#msg_out_web").css("background-color","rgb(79, 85, 102)");
                $("#msg_out_web").css("color","white");
                break;
            }
            if(response === ""){
              $("#chat_seemore").html("Pas de messages pour le moment!");
              $("#chat_body").html("");
            }else{
            $("#chat_seemore").html(response);
            $(".msg_min").first().click();
          }
        }
    });
}


function getMessage(id, type){
    $.ajax({
        url: "utils/ajax/get_message.php", // URL de la page
        type: "POST", // GET ou POST
        data: {id: id, type: type}, // Paramètres envoyés à php
        dataType: "html", // Données en retour
        success: function (response) {
            $("#chat_body").html(response);
            $(".msg_min").css("font-weight","");
            $("#msg_"+id).css("font-weight","bold");
        }
    });
}

function writeMsg(){
    $("#chat_body_container").css("width","80%");
    $("#chat_seemore_container").css("display","none");
    $(".chat_link").css("background-color","");
    $(".chat_link").css("color","");
    $("#msg_new_web").css("background-color","rgb(79, 85, 102)");
    $("#msg_new_web").css("color","white");
    $("#chat_body").html("<form action='dashboard.php?page=chat' method='post' class='send_form'><input type='hidden' name='check'><span><br>À : </span><input type='text' name='to' value=' To' onfocus='delete_default_value(this, 1)'><span>Objet : </span><input type='text' name='title' value=' Objet'  onfocus='delete_default_value(this, 2)'><span>Message : </span><textarea rows='10' name='core' onfocus='delete_default_value(this, 3)'> Message ...</textarea><input id='send_button' type='submit' value='Envoyer'></form>");
}

function delete_default_value(object, value){
  switch (value) {
    case 1:
      if(object.value === ' To') object.value = '';
      break;
    case 2:
      if(object.value === ' Objet') object.value = '';
      break;
    case 3:
      if(object.value === ' Message ...') object.value = '';
      break;
  }

}

function default_chat(){
  getSeeMore(1);
  $(".msg_min").first().click();
}
