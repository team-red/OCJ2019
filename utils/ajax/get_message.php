<?php
if (isset($_POST["id"]) && isset($_POST["type"])) {
    require_once("../database.php");
    require_once("../helper.php");
    $dbh = Database::connect();
    $user_email = "ayoubfoussoul@gmail.com"; // get this from the session ...
    $query = "SELECT from_id, to_id, title, core, date FROM chat WHERE id=?;";
    $sth = $dbh->prepare($query);
    $sth->execute(array($_POST["id"]));
    $msg = $sth->fetch();
    $sth->closeCursor();
    chat_generate_body($msg, $_POST["type"]);
} else {
    throw new Exception("Invalid POST params.");
}
$dbh = null;
