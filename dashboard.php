<?php
session_name("peanutbutterandjelly");
session_start();
// this is just the template
if (!isset($_SESSION["logged_in"])){
  // AGAIN, EXIT always after header()
  header("location: index.php");
  exit();
}
require_once("utils/helper/utils.php");
require_once("utils/helper/dashboard_utils.php");

// this part can be ignored, for the moment there is one page for Dashboard
// this would be useful to make it more interactive later
if (isset($_GET["page"]) && check_page($_GET["page"], $pages)) {
    $active_page = $_GET["page"];
} else {
    $active_page = $default_page["name"];
}

require_once("utils/database.php");
$dbh = Database::connect();

 ?>

<!DOCTYPE html>
<html lang="fr-FR">
<?php generate_header($active_page, "css/dashboard.css", $pages); ?>

<body>
<div class="app">
  <!-- Header-->
  <?php generate_header_tag(); ?>
  <!-- SideBar -->
  <?php

  //POURTEST
  $isAdmin = (isset($_GET["admin"]) && $_GET["admin"] === "true");
  //POURTEST

  generate_sidebar($active_page, $pages, $isAdmin);
  ?>
  <!-- Main -->
  <main class="app-main">
    <?php require_once("content/dashboard/content_".$active_page.".php"); ?>
  </main>
</div>


<script type="text/javascript" src="js/popper.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>

<?php
$dbh = null;
?>

</html>
