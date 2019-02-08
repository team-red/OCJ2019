<?php
session_name("peanutbutterandjelly");
session_start();
$_SESSION['initiated'] = true;
require_once("utils/helper/utils.php");
require_once("utils/helper/index_utils.php");
require_once("utils/database.php");
if (isset($_GET["page"]) && check_page($_GET["page"], $pages)) {
    $page = $_GET["page"];
} else {
    $page = "login";
}
$dbh = Database::connect();
 ?>

 <!DOCTYPE html>
 <html lang="fr-FR">
 <?php generate_header($page, "css/login.css", "", $pages); ?>
 <body class="text-center">
   <!--<div class="container-fluid">-->

     <?php require_once("content/index/content_".$page.".php"); ?>

   <!--</div>-->
   <script src="js/popper.min.js"></script>
   <script src="js/bootstrap.min.js"></script>

   <?php
   $dbh = null;
   ?>
 </body>
 </html>