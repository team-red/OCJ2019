<?php
if (isset($_SESSION["logged_in"])) {
    // if the user is logged in, redirect him to the dashboard
    // always call exit() after header() (to avoid php logic to execute after it)
    header("location: dashboard.php");
    exit();
} else {
    if (!isset($_GET["action"])) {
        // default landing page is the login page
        $_GET["action"] = "login";
    }
    if ($_GET["action"] === "register") {
      require("utils/access/registration.php");
        if (isset($_POST["email"], $_POST["pwd"], $_POST["login"], $_POST["name"], $_POST["surname"], $_POST["birthday"], $_POST["conf"])) {
            $feedback = Registration::attempt($dbh, $_POST);
            Registration::generate_form($feedback, $_POST);
        } else {
          Registration::generate_form(Registration::$FEEDBACK["no_feedback"], array());
        }
    } else if ($_GET["action"] === "forgot") {
      require("utils/access/forgot_password.php");
      if (isset($_POST["email"])){
        $feedback = ResetPassword::attempt($dbh, $_POST["email"]);
        ResetPassword::generate_form($feedback, $_POST["email"]);
      }
      else{
        ResetPassword::generate_form(ResetPassword::$FEEDBACK["no_feedback"], "");
      }
    } else {
        // either $_GET["action"] = "login"
        // or $_GET["action"] is something else that is not "login" or "register" or "forgot",
        // for which we redirect to login section
        require("utils/access/login.php");
        if (isset($_POST["email"], $_POST["pwd"])) {
          $feedback = Login::attempt($dbh, $_POST["email"], $_POST["pwd"]);
          if ($feedback["success"]){
              // successful login
              $_SESSION["logged_in"] = true;
              $_SESSION["email"] = $_POST["email"];
              // store login in the session info
              // again, EXIT always after header()
              header("location: dashboard.php");
              exit();
          } else {
            Login::generate_form($feedback, $_POST["email"]);
          }
        } else {
            Login::generate_form(Login::$FEEDBACK["no_feedback"], array());
        }
    }
}
