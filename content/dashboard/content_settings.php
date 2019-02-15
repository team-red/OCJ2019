<?php

require_once("utils/helper/settings_utils.php");
require_once("utils/profile/user.php");

if (isset($_POST["action"])){
    switch ($_POST["action"]){
        case "delete_account":
            User::deleteUser($dbh, $user->login);
            session_unset();
            session_destroy();
            header("location: index.php");
            exit();
            break;
        case "modify_data":
            User::modifyData($dbh, $user->login, $_POST);
            $user = User::fromLogin($dbh, $user->login);
            // update the current user object
            break;
        case "change_photo":
            User::setPhotoSource($user->login, $_FILES["pdp"]);
            break;
    }
}

UserParameters::createChangePhotoForm($user->login);
echo "<br>";
UserParameters::createChangeInfoForm($user);
echo "<br>";
UserParameters::createDeleteAccountForm();


?>
