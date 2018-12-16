<?php
session_name("peanutbutterandjelly");
session_start();
// this is just the template
var_dump($_SESSION);
if (!isset($_SESSION["logged_in"])){
  // AGAIN, EXIT always after header()
  header("./index.php");
  exit();
}
require_once("../utils/helper.php");
require_once("../utils/database.php");
require_once("../utils/access.php");

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
<?php generate_header($page, "", $dashboard_pages); ?>
  <body class="text-center">

    <div class="container-fluid">

      <?php require_once("../content/dashboard/content_main.php"); ?>

    </div>


  </body>
</html>
