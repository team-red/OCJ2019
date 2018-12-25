<?php
session_name("peanutbutterandjelly");
session_start();
// this is just the template
if (!isset($_SESSION["logged_in"])){
  // AGAIN, EXIT always after header()
  header("location: index.php");
  exit();
}
require_once("utils/helper.php");
require_once("utils/database.php");

// this part can be ignored, for the moment there is one page for Dashboard
// this would be useful to make it more interactive later
if (isset($_GET["page"]) && check_page($_GET["page"], $dashboard_pages)) {
    $page = $_GET["page"];
} else {
    $page = "main";
}

$dbh = Database::connect();
 ?>

<!DOCTYPE html>
<html lang="fr-FR">
<?php generate_header($page, "css/dashboard.css", $dashboard_pages); ?>

<body>
<div class="app">
  <!-- Header-->
  <?php generate_header_dashboard(); ?>
  <!-- SideBar -->
  <?php

  //POURTEST
  $isAdmin = (isset($_GET["admin"]) && $_GET["admin"] == "true") ? true : false;
  //POURTEST

  generate_sidebar_dashboard($page, $dashboard_pages, $isAdmin);
  ?>
  <!-- Main -->
  <main class="app-main">
    <?php require_once("content/dashboard/content_".$page.".php"); ?>
  </main>
</div>

<script src="js/popper.min.js"></script>
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/dashboard.js"></script>
</html>
