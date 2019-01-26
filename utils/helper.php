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
      <script type="text/javascript" src="js/jquery.min.js"></script>
      <script type="text/javascript" src="js/dashboard.js"></script>
  </head>
flag;
}

// ************* For dashboard *****************

// --------- General ------------
function generate_header_dashboard($active_page){
  echo <<<flag
  <header class="app-header">
    <span style="font-size:30px;cursor:pointer" class="pointer" onclick="openNav()">  &#9776;</span>
  </header>
flag;
}
function generate_sidebar_dashboard($active_page, $valid_pages, $admin){
  // Adding first stuff
  $html = "
    <!-- The dark window when the sidebar is open on small devices -->
    <div id='dark' onclick='closeNav()'></div>
    <!-- The actual sidebar -->
    <aside id='side-bar' class='app-aside'>
    <header class='logo_header'>
    <img class='logo' src='media/mathmaroc-dashboard.png' alt='logo'>
    </header>
    <main class='sidebar_main'>
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
      <a class='sidebar_page".$selected."'id='sidebar_".$valid_page["name"]."' href='dashboard.php?page=".$valid_page["name"]."'>
        <i class='icon-".$valid_page["icon_name"]." sidebar_icon'></i>
        ".$valid_page["title"]."
        <i class='icon-uniE04B sidebar_arrow'></i>
      </a>
    </li>";
    }
  }
  $html = $html."
    </ul>
  </main>
  <footer class='sidebar_help'>
  <div class='need_help'><a href='#' style='text-decoration: none; color:unset;'><i class='icon-uni36'></i> Besoin d'aide? </a></div>
  </footer>
  </aside>";
  // printing the html code
  echo $html;
}
function generate_dashboard_footer(){
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
function home_page_generate_left(){
  //variables to get from sql !!!!!!!!!! be carefull to always store name in right capitalization
  $profil_photo = "media/profi.jpg";
  //schoolar information
  $class = "2eme année";
  $school = "Ecole Polytechnique";
  $academy = "NA";
  //personal information
  $last_name= "foussoul";
  $first_name="ayoub";
  $email="ayoub.foussoul@polytechnique.edu";
  $birthday="12 septembre 1997";
  $account_status="Administrateur";

  // A refaire en utilisant des vignettes!?
  echo<<<flag
  <div class="min_box min_box_myinfo">
  <header id="min_box_header_myinfo">
  <h><i class="icon-uniE011 sidebar_icon" style="font-weight: 900;margin-right: 10px;"></i>Infos personelles</h>
  <a href="./dashboard.php?page=myinfo" class="min_see_more">Voir plus de details ></a>
  </header>
  <main class="row">
  <span class="col-md-12 min_col">
  <span class="min_cell min_cell_myinfo no_border">Resume</span>
  <div class="min_col_myinfo_content">
  <img src="$profil_photo" alt="Photo de profil" id="home_page_profil_photo"/>

<div>
  <h1 id="home_page_name">$last_name $first_name</h1>
  <span id="home_page_description">$account_status</span>

</div>
  <hr></hr>
  <span id="home_page_class" class="home_page_info"><b>Classe</b><br>$class</span>
  <span id="home_page_school" class="home_page_info"><b>Ecole</b><br>$school</span>
  <span id="home_page_academy" class="home_page_info"><b>Academie</b><br>$academy</span>
  <hr></hr>
  <span id="home_page_email" class="home_page_info"><b>Email</b><br>$email</span>
  <span id="home_page_birthday" class="home_page_info"><b>Date de naissance</b><br>$birthday</span>
  </div>
  </span>
  </main>
  </div>
flag;
}
function home_page_generate_right(){
  // things to get from SQL
  $champion = "FOUSSOUL Ayoub";
  $myRank = 32;
  $myRankPlusOne = $myRank++;
  $afterMe = "SLIMANI Adam";
  $done = 12;
  $numOfQuizes = 19;
  $success = 13;
  $mark = 15;

  $min_chat = "";
  for($i = 0 ; $i < 5; $i++){
      $order = $i+1;
      $min_chat = $min_chat . "<tr>
      <th scope='row' class='min_chat_num'>$order</th>
      <td class='min_chat_from'>test</td>
      <td class='min_chat_subject'>test_objet</td>
      <td class='min_chat_date'>$order:00</td>
    </tr>";
  }
  if($min_chat == ""){
    $min_chat = "
    <tr>
      <th scope='row'></th>
      <td></td>
      <td style='text-align: center; vertical-align: middle;'>Pas de messages pour le moment</td>
      <td></td>
    </tr>
    ";
  }

  echo<<<flag
  <div class="min_box min_box_quiz">
  <header id="min_box_header_quiz">
  <h><i class="icon-uniE049 sidebar_icon" style="font-weight: 900;margin-right: 10px;"></i>Infos questionnaires</h>
  <a class="min_see_more" href="dashboard.php?page=quiz">Aller sur la partie questionnaires > </a>
  </header>
  <main class="row">

  <span class="col-md-6 min_col">
  <table class="table table_min">
      <thead class="thead-dark">
        <tr>
          <th scope="col" class="no_border min_table_cell_quiz">Classement</th>
          <th scope="col" class="no_border min_table_cell_quiz">Eleve</th>
        </tr>
      </thead>
      <tbody>
        <tr>
        <th scope="row" class="no_border">1</th>
        <td class="no_border">$champion</td>
      </tr><tr>
        <th scope="row" class="no_border">...</th>
        <td class="no_border">...</td>
      </tr><tr>
        <th scope="row" class="no_border">$myRank</th>
        <td class="no_border" id="min_table_cell_your_rank">Vous</td>
      </tr><tr>
        <th scope="row" class="no_border">$myRankPlusOne</th>
        <td class="no_border">$afterMe</td>
      </tr>
      <tr>
        <th scope="row" class="no_border">...</th>
        <td class="no_border">...</td>
      </tr></tbody>
  </table>
  </span>
  <span class="col-md-6 min_col">
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
  </span>

  </main>
  </div>

  <div class="min_box min_box_chat">
  <header id="min_box_header_messages">
  <h><i class="icon-uni2D sidebar_icon" style="font-weight: 900;margin-right: 10px;"></i>mes messages</h>
  <a href='dashboard.php?page=chat' class="min_see_more">Voir plus de details ></a>
  </header>
  <main class="row">
  <span class="col-md-12 min_col">
  <table class="table table_chat table_min">
    <thead class="thead-dark">
      <tr>
        <th scope="col" class="no_border min_table_cell_chat min_chat_num">#</th>
        <th scope="col" class="no_border min_table_cell_chat min_chat_from">De</th>
        <th scope="col" class="no_border min_table_cell_chat min_chat_subject">Objet</th>
        <th scope="col" class="no_border min_table_cell_chat min_chat_date">Date</th>
      </tr>
    </thead>
    <tbody>
      $min_chat
    </tbody>
  </table>
  </span>
  </main>
  </div>

flag;
}
