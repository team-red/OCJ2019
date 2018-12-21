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

$dashboard_pages = array(
  array(
    "name"=> "main",
    "title"=> "Acceuil",
    "icon_name" => "home"
  ),
  array(
    "name"=> "questionnaires",
    "title"=> "Questionnaires",
    "icon_name" => "question-circle"
  ),
  array(
    "name"=> "setting",
    "title"=> "Paramettres",
    "icon_name" => "sliders-h"
  ),
  array(
    "name" => "logout",
    "title" => "Logout",
    "icon_name" => "sign-out-alt"
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
    <div class="side-header"><img class="logo" src="media/mathmaroc.png" alt="logo"></div>
    <span style="font-size:30px;cursor:pointer" class="pointer" onclick="openNav()">  &#9776;</span>
  </header>
flag;
}
function generate_sidebar_dashboard($page, $valid_pages){
  echo <<<flag
    <!-- The dark window when the sidebar is open on small devices -->
    <div id="dark" onclick="closeNav()"></div>
    <!-- The actual sidebar -->
    <aside id="side-bar" class="app-aside app-aside-expand-md app-aside-light">
    <ul class="sidebar_pages">
flag;
foreach ($valid_pages as $valid_page){
  echo "<a href='dashboard.php?page=".$valid_page["name"]."'><li class='sidebar_page ";
  if($valid_page["name"] == $page) echo "sidebar_page_selected";
  echo "' id='sidebar_".$valid_page["name"]."'><span class='sidebar_icons ";
  if($valid_page["name"] == $page) echo "sidebar_page_selected";
  echo "''> <i class='fas fa-".$valid_page["icon_name"]."'></i></span>".$valid_page["title"]."<i class='fas fa-angle-right ";
  if($valid_page["name"] == $page) echo "sidebar_page_selected";
  echo "' style='float: right; color: #6c757d; margin-top: 4px;'></i></li></a>";
}
echo <<<flag
    </ul>
    </aside>
flag;
}
