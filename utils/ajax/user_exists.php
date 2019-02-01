<?php
session_name("peanutbutterandjelly");
session_start();
if (isset($_SESSION['initiated']) && $_SESSION['initiated'] === true && isset($_POST["auth"], $_POST["value"])) {
    require_once("../database.php");
    $dbh = Database::connect();
    if ($_POST["auth"] === "email") {
        $query = "SELECT * FROM users WHERE email=?;";
        $sth = $dbh->prepare($query);
        $sth->execute(array($_POST["value"]));
        if ($sth->fetch()) {
            echo "Found";
        } else {
            echo "Not Found";
        }
        $sth->closeCursor();
    } elseif ($_POST["auth"] === "login") {
        $query = "SELECT * FROM users WHERE login=?;";
        $sth = $dbh->prepare($query);
        $sth->execute(array($_POST["value"]));
        if ($sth->fetch()) {
            echo "Found";
        } else {
            echo "Not Found";
        }
        $sth->closeCursor();
    } else {
        throw new Exception("Invalid POST params.");
    }
    $dbh = null;
}