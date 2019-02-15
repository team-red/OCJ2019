<?php

require_once("utils/profile/admin_panel.php");
require_once("utils/profile/user.php");
require_once("utils/quiz/qcm.php");

echo "<div class='manage_students_main'><h1 class='manage_students_main_title'>Voici la liste des élèves inscrits sur le site : </h1><br>";
if (!isset($_GET["action"])){
    AdminPanel::createUserManagerForm($dbh);
} else if ($_GET["action"] === "view_activity"){
    if (isset($_GET["value"])){
        $login = $_GET["value"];
        $student = User::fromLogin($dbh, $login);
        if ($student === false) {
            AdminPanel::createUserManagerForm($dbh);
        }
        else {
            AdminPanel::createUserOverview($dbh, $student);
        }
    } else {
        AdminPanel::createUserManagerForm($dbh);
    }
} else if ($_GET["action"] === "delete"){
    if (isset($_GET["value"])){
        $login = $_GET["value"];
        $student = User::fromLogin($dbh, $login);
        if ($student !== false && $student->role === "user") {
            User::deleteUser($dbh, $student->login);
        }
    }
    AdminPanel::createUserManagerForm($dbh);
} else if ($_GET["action"] === "unblock"){
    if (isset($_GET["u_login"]) && isset($_GET["qcm_id"])){
        $qcm = Qcm::fromId($dbh, $_GET["qcm_id"]);
        $student = User::fromLogin($dbh, $_GET["u_login"]);
        UserData::unblockUserQcm($dbh, $student->login, $qcm->id);
        AdminPanel::createUserOverview($dbh, $student);
    } else {
        AdminPanel::createUserManagerForm($dbh);
    }
}
echo '</div>';
?>
