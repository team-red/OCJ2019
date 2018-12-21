<?php
session_name("peanutbutterandjelly");
session_start();
require_once("utils/helper.php");
require_once("utils/database.php");

if (isset($_GET["page"]) && check_page($_GET["page"], $index_pages)) {
    $page = $_GET["page"];
} else {
    $page = "login";
}

$dbh = Database::connect();
 ?>

 <!DOCTYPE html>
 <html lang="fr-FR">
 <?php generate_header($page, "css/login.css", $index_pages); ?>
 <body class="text-center">
   <!--<div class="container-fluid">-->

     <?php require_once("content/index/content_".$page.".php"); ?>

   <!--</div>-->
   <script src="js/popper.min.js"></script>
   <script src="js/jquery.min.js"></script>
   <script src="js/bootstrap.min.js"></script>

   <?php
   $dbh = null;
   ?>
 </body>
 </html>
