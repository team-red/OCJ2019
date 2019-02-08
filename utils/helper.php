<?php

$index_pages = array(
  array(
    "name"=> "login",
    "title"=> "Connexion"
  ),
  array(
    "name"=> "about",
    "title"=> "Contactez nous"
  )
);

// When adding new page add it with its category and let the main page always in the top of the array
$dashboard_pages = array(
  // Menu principal
  array(
    "name"=> "home_page",
    "title"=> "Acceuil",
    "icon_name" => "uni5A",
    "category" => "Menu principal"
  ),
  array(
    "name"=> "myinfo",
    "title"=> "Mes infos",
    "icon_name" => "uniE011",
    "category" => "Menu principal"
  ),
  array(
    "name"=> "quiz",
    "title"=> "Questionnaires",
    "icon_name" => "uniE049",
    "category" => "Menu principal"
  ),
  array(
    "name"=> "chat",
    "title"=> "Messagerie",
    "icon_name" => "uni2D",
    "category" => "Menu principal"
  ),
  // Admin
  array(
    "name" => "statistics",
    "title" => "Statistiques",
    "icon_name" => "uniE002",
    "category" => "Administrateur"
  ),
  array(
    "name" => "create_quiz",
    "title" => "Creer Questionnaire",
    "icon_name" => "uni2E",
    "category" => "Administrateur"
  ),
  array(
    "name" => "manage_students",
    "title" => "Gestionnaire d'éleves",
    "icon_name" => "uni50",
    "category" => "Administrateur"
  ),
  // User Account
  array(
    "name"=> "settings",
    "title"=> "Paramettres",
    "icon_name" => "uniE005",
    "category" => "Compte d'utilisateur"
  ),
  array(
    "name" => "logout",
    "title" => "Déconnexion",
    "icon_name" => "uniE003",
    "category" => "Compte d'utilisateur"
  )
);

 $personalInfo = array(
   "profilPhoto" => "media/profil.jpg",
   //schoolar information
   "class" => "2eme année",
   "school" => "Ecole Polytechnique",
   "academy" => "NA",
   //postal information
   "email" => "ayoub.foussoul@polytechnique.edu",
   "phone" => "+33671753326",
   "adress" => "72.20.16, Boulevard des marechaux, 91120 Palaiseau, Essone, France",
   //personal information
   "last_name" => "FOUSSOUL",
   "first_name" => "Ayoub",
   "gender" => "M",
   "birthday" => "12 septembre 1997",
   //other
   "account_status" => "Administrateur",
   "description" => "Hi there!",
 );
 $quizInfo = array(
   "champion" => "FOUSSOUL Ayoub",
   "myRank" => 22,
   "afterMe" => "SLIMANI Adam",
   "lastRank" => 203,
   "lastOne" => "BOUTIHAL Achraf",
   "done" => 12,
   "numOfQuizes" => 19,
   "success" => 13,
   "mark" => 15,
 );

// ************* For all *****************
function check_page($page_name, $valid_pages){
    foreach ($valid_pages as $page) {
        if ($page["name"] == $page_name) {
            return true;
        }
    }
    return false;
}

function get_page_title($page_name, $valid_pages){
    // called only if page exists in valid_pages
    foreach ($valid_pages as $current_page) {
        if ($current_page["name"] == $page_name) {
            return $current_page["title"];
        }
    }
}

function generate_header($page_name, $sheet_path, $valid_pages){
    $title = get_page_title($page_name, $valid_pages);
    echo <<<flag
  <head>
      <title>$title</title>
      <meta name="author" content="team-red">
      <meta name="keywords" content="manga">
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <!-- icons stylesheet -->
      <link rel="stylesheet" href="css/icons.css">
      <!-- Bootstrap CSS -->
      <link href="css/bootstrap.min.css" rel="stylesheet">
      <link rel="stylesheet" type="text/css" href="$sheet_path">
      <script src="js/jquery.min.js"></script>
      <script src="js/dashboard.js"></script>
  </head>
flag;
}

// ************* For dashboard *****************

// --------- General ------------
function generate_header_tag($active_page){
  echo <<<flag
  <header class="app-header">
    <span style="font-size:30px;cursor:pointer" class="pointer" onclick="openNav()">  &#9776;</span>
  </header>
flag;
}
function generate_sidebar($active_page, $valid_pages, $admin){
  $adminEmail = "admin@qcm"; // to get from bd

  // Adding first stuff
  $html = "
    <!-- The dark window when the sidebar is open on small devices -->
    <div id='dark' onclick='closeNav()'></div>
    <!-- The actual sidebar -->
    <aside id='side-bar' class='app-aside'>
    <div class='logo_header'>
    <img class='logo' src='media/mathmaroc-dashboard.png' alt='logo'>
    </div>
    <div class='sidebar_main'>
    <ul class='sidebar_pages'>";

    $category = "";
  foreach ($valid_pages as $valid_page){
    // Adding category if a new one is selected in the loop and skiping General
    if($valid_page["category"] != "Administrateur" || ($valid_page["category"] == "Administrateur" && $admin)){
      if($valid_page["category"] != $category){
        $category = $valid_page["category"];
        $html = $html."<li class='sidebar_category'> &nbsp; --- ".$category."</li>";
      }

    // Adding pages and verifying wheter the page is active or not (if so adding it to the class sidebar_page_selected)
    $selected = ($valid_page["name"] == $active_page) ? " sidebar_page_selected" : "";

    $html = $html."
    <li>
      <a class='sidebar_page".$selected." ' id='sidebar_".$valid_page["name"]."' href='dashboard.php?page=".$valid_page["name"]."'>
        <i class='icon-".$valid_page["icon_name"]." sidebar_icon'></i>
        ".$valid_page["title"]."
        <i class='icon-uniE04B sidebar_arrow'></i>
      </a>
    </li>";
    }
  }
  $html = $html."
    </ul>
  </div>
  <footer class='sidebar_help'>
  <div class='need_help'><a href='#' style='text-decoration: none; color:unset;'  onclick=".'"contact('."'$adminEmail'".')"'." ><i class='icon-uni36'></i> Besoin d'aide? </a></div>
  </footer>
  </aside>";
  // printing the html code
  echo $html;
}
function generate_footer(){
  echo <<<flag
  <footer class="dashboard_footer">
  Copyright © 2018. All rights reserved
  </footer>
flag;
}

//---------- Quiz ------------
function generate_quiz(){
  for($i=1 ; $i<10 ;$i++){
  echo <<<flag
  <a href="#" class="row quiz">
    <div class="col-md-2 head">Q
flag;
  echo $i;
  echo <<<flag
    </div>
    <div class="col-md-9 body">Questionnaire sur les combinaisons et le triangle de pascal à faire avant 12 decembre 2018</div>
    <div class="col-md-1 options"><i class="icon-uniE049"></i></br><i class="icon-uniE00B"></i></br><i class="icon-uniE013"></i></div>
  </a>
flag;
}
}

//---------- Home page ----------
function home_page_generate_left($personalInfo){
  //variables !!!!!!!!!! be carefull to always store name in right capitalization !!!!!!!!!!
  $profilPhoto = $personalInfo["profilPhoto"];
  $class = $personalInfo["class"];
  $school = $personalInfo["school"];
  $academy = $personalInfo["academy"];
  $last_name = $personalInfo["last_name"];
  $first_name = $personalInfo["first_name"];
  $email = $personalInfo["email"];
  $birthday = $personalInfo["birthday"];
  $accountStatus = $personalInfo["account_status"];

  // vignettes!?
  echo<<<flag
  <div class="min_box min_box_myinfo">
  <div id="min_box_header_myinfo">
  <span><i class="icon-uniE011 sidebar_icon" style="font-weight: 900;margin-right: 10px;"></i>Infos personelles</span>
  <a href="./dashboard.php?page=myinfo" class="min_see_more">Voir plus de details ></a>
  </div>
  <div class="row min_box_main">
  <div class="col-md-12 min_col">
  <span class="min_cell min_cell_myinfo no_border">Resume</span>
  <div class="min_col_myinfo_content">
  <img src="$profilPhoto" alt="Photo de profil" id="home_page_profil_photo"/>

<div>
  <h1 id="home_page_name">$last_name $first_name</h1>
  <span id="home_page_subject">$accountStatus</span>

</div>
  <hr/>
  <span id="home_page_class" class="home_page_info"><b>Classe</b><br>$class</span>
  <span id="home_page_school" class="home_page_info"><b>Ecole</b><br>$school</span>
  <span id="home_page_academy" class="home_page_info"><b>Academie</b><br>$academy</span>
  <hr/>
  <span id="home_page_email" class="home_page_info"><b>Email</b><br>$email</span>
  <span id="home_page_birthday" class="home_page_info"><b>Date de naissance</b><br>$birthday</span>
  </div>
  </div>
  </div>
  </div>
flag;
}
function home_page_generate_right($quizInfo){
  // things to get from SQL
  $champion = $quizInfo["champion"];
  $myRank = $quizInfo["myRank"];
  $myRankPlusOne = $myRank+1;
  $afterMe = $quizInfo["afterMe"];
  $lastRank = $quizInfo["lastRank"];
  $lastOne = $quizInfo["lastOne"];
  $done = $quizInfo["done"];
  $numOfQuizes = $quizInfo["numOfQuizes"];
  $success = $quizInfo["success"];
  $mark = $quizInfo["mark"];

  $max = 5;
  $_POST["type"] = 1;
  $_POST["min"] = true;
  require_once("utils/ajax/get_seemore.php");
  $minChat = "";
  foreach ($messagesTable as $key => $message){
      $order = $key+1;
      if($order === $max) break;
      $from = $message["from_id"];
      $description = $message["title"];
      $date = $message["date"];
      $minChat = $minChat . "<tr>
      <th scope='row' class='min_chat_num'>$order</th>
      <td class='min_chat_from'>$from</td>
      <td class='min_chat_subject min_chat_hide'>$description</td>
      <td class='min_chat_date'>date</td>
    </tr>";
  }
  if($minChat == ""){
    $minChat = "
    <tr>
      <th scope='row'></th>
      <td class='min_chat_hide'></td>
      <td style='text-align: center; vertical-align: middle;'>Pas de messages reçus pour le moment</td>
      <td></td>
    </tr>
    ";
  }

  $quizStats = "
  <table class='table table_min'>
      <thead class='thead-dark'>
        <tr>
          <th scope='col' class='no_border min_table_cell_quiz'>Classement</th>
          <th scope='col' class='no_border min_table_cell_quiz'>Eleve</th>
        </tr>
      </thead>
      <tbody>";


if($myRank === 1){
  $quizStats = $quizStats . "<tr>
       <th scope='row' class='no_border'>1</th>
       <td class='no_border' id='min_table_cell_your_rank'>Vous</td>
     </tr><tr>
       <th scope='row' class='no_border'>2</th>
       <td class='no_border'>$afterMe</td>
     </tr><tr>
       <th scope='row' class='no_border'>...</th>
       <td class='no_border'>...</td>
     </tr><tr>
       <th scope='row' class='no_border'>...</th>
       <td class='no_border'>...</td>
     </tr>
     <tr>
       <th scope='row' class='no_border'>$lastRank</th>
       <td class='no_border'>$lastOne</td>
     </tr></tbody>
 </table>";
}
elseif ($myRank === 2) {
  $quizStats = $quizStats . "<tr>
       <th scope='row' class='no_border'>1</th>
       <td class='no_border'>$champion</td>
     </tr><tr>
       <th scope='row' class='no_border'>2</th>
       <td class='no_border' id='min_table_cell_your_rank'>Vous</td>
     </tr><tr>
       <th scope='row' class='no_border'>3</th>
       <td class='no_border'>$afterMe</td>
     </tr><tr>
       <th scope='row' class='no_border'>...</th>
       <td class='no_border'>...</td>
     </tr>
     <tr>
       <th scope='row' class='no_border'>$lastRank</th>
       <td class='no_border'>$lastOne</td>
     </tr></tbody>
  </table>";
}
else{
   $quizStats = $quizStats . "<tr>
        <th scope='row' class='no_border'>1</th>
        <td class='no_border'>$champion</td>
      </tr><tr>
        <th scope='row' class='no_border'>...</th>
        <td class='no_border'>...</td>
      </tr><tr>
        <th scope='row' class='no_border'>$myRank</th>
        <td class='no_border' id='min_table_cell_your_rank'>Vous</td>
      </tr><tr>
        <th scope='row' class='no_border'>$myRankPlusOne</th>
        <td class='no_border'>$afterMe</td>
      </tr>
      <tr>
        <th scope='row' class='no_border'>...</th>
        <td class='no_border'>...</td>
      </tr></tbody>
  </table>";
}

  echo<<<flag
  <div class="min_box min_box_quiz">
  <div id="min_box_header_quiz">
  <span><i class="icon-uniE049 sidebar_icon" style="font-weight: 900;margin-right: 10px;"></i>Infos questionnaires</span>
  <a class="min_see_more" href="dashboard.php?page=quiz">Aller sur la partie questionnaires > </a>
  </div>
  <div class="row min_box_main">

  <div class="col-md-6 min_col">
    $quizStats
  </div>
  <div class="col-md-6 min_col">
  <table class="table table_min" id="table_min_stat">
      <thead class="thead-dark">
        <tr>
          <th scope="col" class="no_border min_table_cell_quiz">Fait</th>
          <th scope="col" class="no_border min_table_cell_quiz">Reussit</th>
          <th scope="col" class="no_border min_table_cell_quiz">Note</th>
        </tr>
      </thead>
      <tbody>
        <tr>
        <td class="no_border min_table_cell_quiz_content">
        <span class="min_col_stat_content_main">$done<span class="min_col_stat_content_sub">/$numOfQuizes</span></span>
        </td>
        <td class="no_border min_table_cell_quiz_content">
        <span class="min_col_stat_content_main">$success<span class="min_col_stat_content_sub">/$numOfQuizes</span></span>
        </td>
        <td class="no_border min_table_cell_quiz_content">
        <span class="min_col_stat_content_main">$mark<span class="min_col_stat_content_sub">/20</span></span>
        </td>
        </tr>
      </tbody>
  </table>
  </div>

  </div>
  </div>

  <div class="min_box min_box_chat">
  <div id="min_box_header_messages">
  <span><i class="icon-uni2D sidebar_icon" style="font-weight: 900;margin-right: 10px;"></i>mes messages</span>
  <a href='dashboard.php?page=chat' class="min_see_more">Voir plus de details ></a>
  </div>
  <div class="row min_box_main">
  <div class="col-md-12 min_col">
  <table class="table table_chat table_min">
    <thead class="thead-dark">
      <tr>
        <th scope="col" class="no_border min_table_cell_chat min_chat_num">#</th>
        <th scope="col" class="no_border min_table_cell_chat min_chat_from">De</th>
        <th scope="col" class="no_border min_table_cell_chat min_chat_subject min_chat_hide">Objet</th>
        <th scope="col" class="no_border min_table_cell_chat min_chat_date">Date</th>
      </tr>
    </thead>
    <tbody>
      $minChat
    </tbody>
  </table>
  </div>
  </div>
  </div>

flag;
}

//---------- infos page ----------

function myinfo_generate_pdp_pdp($personalInfo){
  $profilPhoto = $personalInfo["profilPhoto"];
  echo<<<flag
  <img src="$profilPhoto" alt="Photo de profil" id="myinfo_profil_photo"/>
flag;
}

function myinfo_generate_pdp_info($personalInfo){
  $first_name = $personalInfo["first_name"];
  $last_name = $personalInfo["last_name"];
  $school = $personalInfo["school"];
  $accountStatus = $personalInfo["account_status"];

  echo<<<flag
  <h1>$last_name $first_name</h1>
  <h5>$school</h5>
  <h>$accountStatus</h>

flag;
}
function myinfo_generate_options($personalInfo){
  $adminEmail = "admin@qcm"; // to get from bd
  echo "<span class='myinfo_options'><a href='#' OnClick='javascript:window.print()'><i class='icon-uni7D'></i></a><a href='dashboard.php?page=settings'><i class='icon-uni2E'></i></a><a href='#' onclick=".'"contact('."'$adminEmail'".')"'." ><i class='icon-uni36'></i></a></span> ";
}

function myinfo_generate_personal_academic($personalInfo){
  $academy = $personalInfo["academy"];
  $class = $personalInfo["class"];
  $school = $personalInfo["school"];

  echo<<<flag
  <br><br><br>
  <span class="row"><span class="col-md-3"><b>Ecole :</b></span><span class="col-md-9">$school</span></span><br>
  <span class="row"><span class="col-md-3"><b>Academie :</b></span><span class="col-md-9">$academy</span></span><br>
  <span class="row"><span class="col-md-3"><b>Classe :</b></span><span class="col-md-9">$class</span></span><br>
  <br>
flag;
}

function myinfo_generate_personal_postal($personalInfo){
  $email = $personalInfo["email"];
  $phone = $personalInfo["phone"];
  $adress = $personalInfo["adress"];

  echo<<<flag
  <br>
  <span class="row"><span class="col-md-3"><b>Email :</b></span><span class="col-md-9">$email</span></span><br>
  <span class="row"><span class="col-md-3"><b>Telephone :</b></span><span class="col-md-9">$phone</span></span><br>
  <span class="row"><span class="col-md-3"><b>Adresse Postale :</b></span><span class="col-md-9">$adress</span></span><br>
  <br>
flag;
}

function myinfo_generate_personal_personal($personalInfo){
  $gender = $personalInfo["gender"];
  $birthday = $personalInfo["birthday"];
  $description = $personalInfo["description"];

  echo<<<flag
  <br>
  <span class="row"><span class="col-md-3"><b>Gendre :</b></span><span class="col-md-9">$gender</span></span><br>
  <span class="row"><span class="col-md-3"><b>Date de naissance :</b></span><span class="col-md-9">$birthday</span></span><br>
  <span class="row"><span class="col-md-3"><b>Signature :</b></span><span class="col-md-9">$description</span></span><br>
  <br>
flag;
}

function myinfo_generate_rank_tab($quizInfo){
  $rankData = "";
  $sendToEmail = ""; // to get from bd when getting student don't change the format of the variable!
  for($i=0; $i < 500; $i++){
    $sendToEmail = "email$i@gmail.com";
    $rankData = $rankData . "  <tr>
      <td class=' table_cell_rank_content'>
      ".($i+1)."
      </td>
      <td class=' table_cell_rank_content'>
      test
      </td>
      <td class=' table_cell_rank_content table_cell_rank_content_contact' onclick=".'"contact('."'$sendToEmail'".')"'." >
      <span class='icon-uni3E table_cell_rank_contact'></span>
      </td>
      </tr>";
  }

    echo<<<flag
    <div class="row" id="myinfo_champions">
      <div class="col-md-4 myinfo_champions_cell">
      <img src="media/rank2.png" alt="classment 2" id="myinfo_rank2_photo"/>
      <h>BELOUAFI Kamal</h>
      </div>
      <div class="col-md-4 myinfo_champions_cell_first">
      <img src="media/rank1.png" alt="classement 1" id="myinfo_rank1_photo"/>
      <h>FOUSSOUL Ayoub</h>
      </div>
      <div class="col-md-4 myinfo_champions_cell">
      <img src="media/rank3.png" alt="classement 3" id="myinfo_rank3_photo"/>
      <h>ZHIRO Salma</h>
      </div>
    </div>
    <diV class="row" id="myinfo_rank">
    <table class="table" id="table_rank">
        <thead class="thead-dark">
          <tr>
            <th scope="col" class="table_cell_rank">Classement</th>
            <th scope="col" class="table_cell_rank">Eleve</th>
            <th scope="col" class="table_cell_rank">Contacter...</th>
          </tr>
        </thead>
        <tbody>
          <div class="test">
          $rankData
          </div>
        </tbody>
    </table>

    </div>
flag;
}

function myinfo_generate_done_tab($quizInfo){
  $quizData = "";
  $showQuizes = "";
  $numQuizes = 27;

  for($i=0; $i < $numQuizes; $i++){
    $quizData = $quizData . "  <tr onclick='showQuiz(".($i+1).")'>
      <td class=' table_cell_quiz_content'>
      ".($i+1)."
      </td>
      <td class=' table_cell_quiz_content'>
      test
      </td>
      <td class=' table_cell_quiz_content'>
      15
      </td>
      </tr>";
    $showQuizes = $showQuizes . "
    <div id='quiz_".($i+1)."'>
    Quiz ".($i+1)."!
    <br>
    <span style='cursor:pointer' onclick='unShowQuiz($numQuizes)'>< Revenir en arriere</span>
    </div>
    ";
  }

  echo<<<flag
  <h>Liste des questionnaires que j'ai deja fait :</h>
  <table class="table" id="table_quiz">
      <thead class="thead-dark">
        <tr>
          <th scope="col" class="table_cell_quiz">#</th>
          <th scope="col" class="table_cell_quiz">Titre du questionnaire</th>
          <th scope="col" class="table_cell_quiz">Note obtenue</th>
        </tr>
      </thead>
      <tbody>
        $quizData
      </tbody>
  </table>
  $showQuizes
flag;
}

// ************  Chat ****************

function chat_generate_seemore($messagesTable, $type){

    foreach ($messagesTable as $message){
      $id = $message["id"];
      $description = $message["title"];
      $from_to = (intval($type) === 3) ? "À: " . $message["to_id"] : "De: " . $message["from_id"];
      $date = $message["date"];
      echo<<<flag
    <span class="msg_min" id="msg_$id" onclick="getMessage($id, $type)">
      <span class="msg_min_title">$from_to</span>
      <span class="msg_min_date">$date</span>
      <span class="msg_min_subject">$description</span>
    </span>
flag;
  }
}

function chat_generate_body($message, $type){
  $description = $message["title"];
  $from_to = (intval($type) === 3) ? "<b>À: </b>" . $message["to_id"] : "<b>De: </b>" . $message["from_id"];
  $core = $message["core"];
  $date = $message["date"];
  echo<<<flag
  <br>
  <span class="msg_body_title">$from_to</span>
  <span class="msg_min_date">$date</span>
  <span class="msg_body_subject"><b>Objet :</b> $description</span>
  <hr>
  <span class="msg_body_core"><b>Message : </b><br>$core</span>
flag;
}
