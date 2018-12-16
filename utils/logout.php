<?php
session_name("peanutbutterandjelly");
session_start();

require_once("access.php");

if (isset($_SESSION["logged_in"])){
  attempt_logout();
  header("location: ../index.php");
  exit();
}
 ?>
