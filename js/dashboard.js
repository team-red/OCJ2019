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
    unShowQuiz(); // nombre de quiz faits à obtenir de la bd
    //todo
  }
}); //on document ready

// show/unShows quizes on quiz tabs
function showQuiz(numQuiz){
  var quizId = "quiz_" + numQuiz;
  document.getElementById("table_quiz").style.display = "none";
  document.getElementById(quizId).style.display = "block";
}
function unShowQuiz(){
  document.getElementById("table_quiz").style.display = "table";
  var quizId = 1;
  while(document.getElementById("quiz_" + quizId) !== null){
    document.getElementById("quiz_" + quizId).style.display = "none";
    quizId++;
  }
}

function contact(email){
  window.location = 'dashboard.php?page=chat&sendTo=' + email;
}

// chat

function getSeeMore(type){
  onNewMessage = false;
  var mobile = false;
  $(".chat_main_main").css("background-color","");
  if (window.matchMedia("(max-width: 767.9px)").matches) {
    $("#chat_body_container").css("display","none");
    $("#chat_seemore_container").css("display","table-cell");
    $("#chat_body_container").css("width","");
    mobile = true;
  } else {
    $("#chat_body_container").css("display","table-cell");
    $("#chat_seemore_container").css("display","table-cell");
    $("#chat_body_container").css("width","55%");
    mobile = false;
  }
  $(".chat_link").css("background-color","");
  $(".chat_link").css("color","");
  $("#chat_seemore_container").css("display","table-cell");
  $("#chat_seemore").html("");
    $.ajax({
        url: "utils/ajax/get_seemore.php", // URL de la page
        type: "POST", // GET ou POST
        data: {type: type}, // Paramètres envoyés à php
        dataType: "html", // Données en retour
        success: function (response) {
            switch (type){
              case 1:
                $(".msg_from_admin").css("background-color","rgb(79, 85, 102)");
                $(".msg_from_admin").css("color","white");
                break;
              case 2:
                $(".msg_in").css("background-color","rgb(79, 85, 102)");
                $(".msg_in").css("color","white");
                break;
              case 3:
                $(".msg_out").css("background-color","rgb(79, 85, 102)");
                $(".msg_out").css("color","white");
                break;
            }
            if(response === ""){
              $("#chat_seemore").html("<span class='msg_min'>Pas de messages pour le moment!</span>");
              $("#chat_body").html("");
            }else{
            $("#chat_seemore").html(response);
            if(!mobile) $(".msg_min").first().click();
          }
        }
    });
}


function getMessage(id, type){
  onNewMessage = false;
  var mobile = false;
  if (window.matchMedia("(max-width: 767.9px)").matches) {
    $("#chat_body_container").css("display","table-cell");
    $("#chat_seemore_container").css("display","none");
    $("#chat_body_container").css("width","100%");
    $(".chat_main_main").css("background-color","#f8f9fa");
    mobile = true;
  } else {
    $("#chat_body_container").css("display","table-cell");
    $("#chat_seemore_container").css("display","table-cell");
    $("#chat_body_container").css("width","55%");
    $(".chat_main_main").css("background-color","");
    mobile = false;
  }
  $("#chat_body").html("");
    $.ajax({
        url: "utils/ajax/get_message.php", // URL de la page
        type: "POST", // GET ou POST
        data: {id: id, type: type}, // Paramètres envoyés à php
        dataType: "html", // Données en retour
        success: function (response) {
            $("#chat_body").html(response);
            $(".msg_min").css("border-left","");
            $("#msg_"+id).css("border-left","5px solid rgb(79, 86, 101)");
        }
    });
}

var onNewMessage = false;

function writeMsg(){
  onNewMessage = true;
  var mobile = false;
  if (window.matchMedia("(max-width: 767.9px)").matches) {
    $("#chat_body_container").css("display","table-cell");
    $("#chat_body_container").css("width","100%");
    $(".chat_main_main").css("background-color","#f8f9fa");
    mobile = true;
  } else {
    $("#chat_body_container").css("display","table-cell");
    $("#chat_body_container").css("width","80%");
    $(".chat_main_main").css("background-color","");
    mobile = false;
  }
    $("#chat_seemore_container").css("display","none");
    $(".chat_link").css("background-color","");
    $(".chat_link").css("color","");
    $(".msg_new").css("background-color","rgb(79, 85, 102)");
    $(".msg_new").css("color","white");
    $("#chat_body").html("<form action='dashboard.php?page=chat' method='post' class='send_form'><input type='hidden' name='check'><span><br>À : </span><input id='send_to' type='text' name='to' value=' Email du destinataire' onfocus='delete_default_value(this, 1)'><span>Objet : </span><input type='text' name='title' value=' Objet'  onfocus='delete_default_value(this, 2)'><span>Message : </span><textarea rows='10' name='core' onfocus='delete_default_value(this, 3)'> Message ...</textarea><input id='send_button' type='submit' value='Envoyer'></form>");
}

function delete_default_value(object, value){
  switch (value) {
    case 1:
      if(object.value === ' Email du destinataire') object.value = '';
      break;
    case 2:
      if(object.value === ' Objet') object.value = '';
      break;
    case 3:
      if(object.value === ' Message ...') object.value = '';
      break;
  }

}

$( window ).resize(function(){
  $(".chat_main_main").css("background-color","");
  if(onNewMessage){
    $("#chat_seemore_container").css("display","none");
    $("#chat_body_container").css("display","table-cell");
  }else {
    if (window.matchMedia("(max-width: 767.9px)").matches) {
      $("#chat_body_container").css("display","none");
      $("#chat_seemore_container").css("display","table-cell");
    }else{
      $("#chat_body_container").css("display","table-cell");
      $("#chat_seemore_container").css("display","table-cell");
      $("#chat_body_container").css("width","55%");
    }
  }
})

function default_chat(commingFromInfo){
  if(commingFromInfo !== null){
    $(".msg_new").click();
    $("#send_to").val(commingFromInfo);
  }else{
    getSeeMore(1);
  }
}
