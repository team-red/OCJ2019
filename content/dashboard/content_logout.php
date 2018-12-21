<?php

if (isset($_SESSION["logged_in"])){
  attempt_logout();
  header("location: index.php");
  exit();
}

 ?>
