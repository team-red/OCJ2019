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

// this part can be ignored, for the moment there is one page for Dashboard
// this would be useful to make it more interactive later
if (isset($_GET["page"]) && check_page($_GET["page"], $dashboard_pages)) {
    $active_page = $_GET["page"];
} else {
    $active_page = $dashboard_pages[0]["name"];
}

 ?>

<!DOCTYPE html>
<html lang="fr-FR">
<?php generate_header($active_page, "css/dashboard.css", $dashboard_pages); ?>

<body>
<div class="app">
  <!-- Header-->
  <?php generate_header_tag($active_page); ?>
  <!-- SideBar -->
  <?php

  //POURTEST
  $isAdmin = (isset($_GET["admin"]) && $_GET["admin"] == "true") ? true : false;
  //POURTEST

  generate_sidebar($active_page, $dashboard_pages, $isAdmin);
  ?>
  <!-- Main -->
  <main class="app-main">
    <?php require_once("content/dashboard/content_".$active_page.".php"); ?>
  </main>
</div>


<script type="text/javascript" src="js/popper.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>

</html>
