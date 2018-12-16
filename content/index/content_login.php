<?php
require_once("utils/access.php");
if (isset($_SESSION["logged_in"])) {
    // if the user is logged in, redirect him to the dashboard
    // always call exit() after header() (to avoid php logic to execute after it)
    header("location: private/dashboard.php");
    exit();
} else {
    if (!isset($_GET["action"])) {
        // default landing page is the login page
        $_GET["action"] = "login";
    }
    if ($_GET["action"] == "register") {
        if (isset($_POST["email"], $_POST["pwd"], $_POST["login"], $_POST["name"], $_POST["surname"], $_POST["birthday"], $_POST["conf"])) {
            $attempt = (array) attempt_registration($dbh, $_POST); // cast to suppress warning
            generate_registration_form($attempt["success"], $attempt["message"]);

        } else {
          generate_registration_form(true, "");
        }
    } else if ($_GET["action"] == "forgot") {

      if (isset($_POST["email"])){
        $attempt = (array) attempt_send_reset_link($_POST["email"]);
        generate_forgot_password_form($attempt["success"], $attempt["message"]);
      }

      else{
        generate_forgot_password_form(true, "");
      }

    } else {
        // either $_GET["action"] = "login"
        // or $_GET["action"] is something else that is not "login" or "register" or "forgot",
        // for which we redirect to login section
        if (isset($_POST["email"], $_POST["pwd"])) {
            if (attempt_login($dbh, $_POST["email"], $_POST["pwd"])) {
              // conditional attemps login and decides if it was successful
                $_SESSION["logged_in"] = true;
                // again, EXIT always after header()
                header("location: private/dashboard.php");
                exit();
            } else {
                generate_login(true);
            }
        } else {
            generate_login(false);
        }
    }
}
