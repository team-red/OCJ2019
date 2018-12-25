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
// When adding new page add it with its category
$dashboard_pages = array(
  // General
  array(
    "name"=> "main",
    "title"=> "Acceuil",
    "icon_name" => "home",
    "category" => "General"
  ),
  array(
    "name"=> "profil",
    "title"=> "Profil",
    "icon_name" => "user-circle",
    "category" => "General"
  ),
  array(
    "name"=> "questionnaires",
    "title"=> "Questionnaires",
    "icon_name" => "question-circle",
    "category" => "General"
  ),
  // Admin
  array(
    "name" => "stats",
    "title" => "Statistiques",
    "icon_name" => "poll",
    "category" => "Admin"
  ),
  array(
    "name" => "creer_questionnaire",
    "title" => "Creer Questionnaire",
    "icon_name" => "pencil-alt",
    "category" => "Admin"
  ),
  array(
    "name" => "gestionnaire_eleves",
    "title" => "Gestionnaire d'éleves",
    "icon_name" => "users-cog",
    "category" => "Admin"
  ),
  // User Account
  array(
    "name"=> "setting",
    "title"=> "Paramettres",
    "icon_name" => "sliders-h",
    "category" => "User account"
  ),
  array(
    "name" => "logout",
    "title" => "Logout",
    "icon_name" => "sign-out-alt",
    "category" => "User account"
  )
);

function check_page($page_name, $valid_pages)
{
    foreach ($valid_pages as $page) {
        if ($page["name"] == $page_name) {
            return true;
        }
    }
    return false;
}

function get_page_title($page_name, $valid_pages)
{
    // called only if page exists in valid_pages
    foreach ($valid_pages as $current_page) {
        if ($current_page["name"] == $page_name) {
            return $current_page["title"];
        }
    }
}

function generate_header($page_name, $sheet_path, $valid_pages)
{
    $title = get_page_title($page_name, $valid_pages);
    echo <<<flag
  <head>
      <title>$title</title>
      <meta name="author" content="ahmed">
      <meta name="keywords" content="manga">
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <!-- Font Awesom for page icons -->
      <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
      <!-- Bootstrap CSS -->
      <link href="css/bootstrap.min.css" rel="stylesheet">
      <link rel="stylesheet" type="text/css" href="$sheet_path">
  </head>
flag;
}
function generate_header_dashboard(){
  echo <<<flag
  <header class="app-header">
    <div class="side-header"></div>
    <span style="font-size:30px;cursor:pointer" class="pointer" onclick="openNav()">  &#9776;</span>
  </header>
flag;
}
function generate_sidebar_dashboard($page, $valid_pages, $admin){
// Adding first stuff
$html = "
    <!-- The dark window when the sidebar is open on small devices -->
    <div id='dark' onclick='closeNav()'></div>
    <!-- The actual sidebar -->
    <aside id='side-bar' class='app-aside'>
    <header class='logo_header'>
    <img class='logo' src='media/mathmaroc-white.png' alt='logo'>
    </header>
    <main>
    <ul class='sidebar_pages'>";

$category = "General";
foreach ($valid_pages as $valid_page){
  // Adding category if a new one is selected in the loop and skiping General
  if($valid_page["category"] != "Admin" || ($valid_page["category"] == "Admin" && $admin)){
    if($valid_page["category"] != $category){
        $category = $valid_page["category"];
        $html = $html."<li class='sidebar_category'>".$category."</li>";
    }

  // Adding pages and verifying wheter the page is active or not (if so adding it to the class sidebar_page_selected)
  $selected = ($valid_page["name"] == $page) ? " sidebar_page_selected" : "";
  $html = $html."
  <a onmouseover='page_hovered(sidebar_".$valid_page["name"].")' onmouseout='page_mouseout(sidebar_".$valid_page["name"].")' href='dashboard.php?page=".$valid_page["name"]."'>
    <li class='sidebar_page".$selected."'id='sidebar_".$valid_page["name"]."'>
      <span class='sidebar_icons".$selected."'>
        <i class='fas fa-".$valid_page["icon_name"]."'></i>
      </span>
      ".$valid_page["title"]."
      <i class='fas fa-angle-right sidebar_arrow".$selected."'></i>
    </li>
  </a>";
  }
}
$html = $html."
</ul></main>
<footer class='sidebar_help'>
<div class='need_help'><a href='#' style='text-decoration: none; color:unset;'><i class='fas fa-info-circle'></i> Besoin d'aide? </a></div>
</footer>
</aside>";

// printing the html code
echo $html;

}

function generate_questionnaires(){
  for($i=1 ; $i<10 ;$i++){
  echo <<<flag
  <div class="row questionnaire">
    <div class="col-md-2 head">Q
flag;
echo $i;
echo <<<flag
    </div>
    <div class="col-md-9 body">Questionnaire sur les combinaisons et le triangle de pascal à faire avant 12 decembre 2018</div>
    <div class="col-md-1 options"><i class="fas fa-question-circle"></i></br><i class="fas fa-arrow-circle-right"></i></br><i class="far fa-star"></i></div>
  </div>
flag;
}
}

function generate_dashboard_footer(){
  echo <<<flag
  <footer class="questionnaires_footer">
  Copyright © 2018. All rights reserved
  </footer>
flag;
}
