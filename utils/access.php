<?php

class Login
{

  public static $DEFAULT_EMAIL = "";

  public static $FEEDBACK = array(
    "no_feedback" => array(
      "message" => "",
      "success" => false, // useless
      "script" => "",
      "visibility" => "hidden",
      "show_defaults" => false
    ),
    "success" => array(
      "message" => "",
      "success" => true,
      "script" => "",
      "visibility" => "hidden",
      "show_defaults" => false
    ),
    "wrong_password" => array(
      "message" => "Mot de passe erroné.",
      "success" => false,
      "script" => "js/invalid_pwd.js",
      "visibility" => "visible",
      "show_defaults" => true
    ),
    "email_not_found" => array(
      "message" => "Adresse mail introuvable.",
      "success" => false,
      "script" => "js/invalid_email.js",
      "visibility" => "visible",
      "show_defaults" => true
    ),
    "unknown_error" => array(
      "message" => "Connexion échouée.",
      "success" => false,
      "script" => "",
      "visibility" => "visible",
      "show_defaults" => true
    )
  );

  public static function attempt($dbh, $email, $pwd){
    // returns boolean. We first verify if this email is in the database.
    // If not, we return false. If so, we compare passwords.
    $query = "SELECT pwd FROM users WHERE email=?;";
    $sth = $dbh->prepare($query);
    $success = $sth->execute(array($email));
    if (!$success){
      return Login::$FEEDBACK["unknown_error"];
    }
    if ($user = $sth->fetch()) {
        if (sha1($pwd) == $user["pwd"]) {
            // pwd is valid
            return Login::$FEEDBACK["success"];
        } else {
            return Login::$FEEDBACK["wrong_password"];
        }
    } else {
        // user not found in DB
        return Login::$FEEDBACK["email_not_found"];
    }
  }

  public static function generate_form($feedback, $default_email){

    if ($feedback["show_defaults"]){
      $default_email = htmlspecialchars($default_email);
    } else{
      $default_email = Login::$DEFAULT_EMAIL;
    }

    echo<<<flag
  <form class="form-signin needs-validation" method="post" novalidate>
    <img class="mb-4" src="media/mathmaroc.png" alt="" width="100"="image/svg+xml">

    <label for="inputEmail" class="sr-only">Adresse mail</label>
    <input type="email" id="inputEmail" class="form-control not-last-element" name="email" placeholder="Adresse mail" value="$default_email" required autofocus>

    <label for="inputPassword" class="sr-only">Mot de passe</label>
    <input type="password" id="inputPassword" class="form-control last-element" placeholder="Mot de passe" name="pwd" required>

    <button class="btn btn-lg btn-primary btn-block" type="submit">Connexion</button>

    <a href="index.php?action=register" style="margin: 0px; padding: 0px;">Première visite sur ce site ?</a>
    <a href="index.php?action=forgot" style="margin-top: 0px; padding-top: 0px;">Vous avez oublié votre mot de passe ?</a>

    <div class='alert alert-danger' role='alert' style='visibility: {$feedback["visibility"]};'> {$feedback["message"]} </div>
  </form>
  <script src="js/general_form_validation.js"></script>
  <script src="{$feedback["script"]}"></script>
flag;
  }
}


class Registration
{

  public static $DEFAULTS = array(
    "email" => "",
    "login" => "",
    "surname" => "",
    "name" => "",
    "birthday" => "",
  );


    public static $FEEDBACK = array(
      "no_feedback" => array(
        "message" => "",
        "visibility" => "hidden",
        "alert_status" => "",
        "script" => "",
        "show_defaults" => false
      ),
      "email_in_use" => array(
        "message" => "Cette adresse e-mail est déjà utilisée.",
        "visibility" => "visible",
        "alert_status" => "danger",
        "script" => "js/invalid_email.js",
        "show_defaults" => true
      ),
      "login_in_use" => array(
        "message" => "Ce pseudonyme est déjà utilisé.",
        "visibility" => "visible",
        "alert_status" => "danger",
        "script" => "js/invalid_login.js",
        "show_defaults" => true
      ),
      "different_passwords" => array(
        "message" => "Les mots de passe ne sont pas identiques.",
        "visibility" => "visible",
        "alert_status" => "danger",
        "script" => "js/invalid_pwd.js",
        "show_defaults" => true
      ),
      "unknown_error" => array(
        "message" => "Ajout échoué.",
        "visibility" => "visible",
        "alert_status" => "danger",
        "script" => "",
        "show_defaults" => true
      ),
      "success" => array(
        "message" => "Ajout avec succès.",
        "visibility" => "visible",
        "alert_status" => "success",
        "script" => "",
        "show_defaults" => false
      )
    );


    public static function attempt($dbh, $data)
    {

        $email = $data["email"];
        $pwd = $data["pwd"];
        $pwd_conf = $data["conf"];
        $login = $data["login"];
        $name = $data["name"];
        $surname = $data["surname"];
        $birthday = $data["birthday"];

        if ($pwd != $pwd_conf) {
            return Registration::$FEEDBACK["different_passwords"];
        }

        $query = "SELECT * FROM users WHERE email=?";
        $sth = $dbh->prepare($query);
        $sth->execute(array($email));
        if ($sth->fetch()) {
            return Registration::$FEEDBACK["email_in_use"];
        }
        $sth->closeCursor();

        $query = "SELECT * FROM users WHERE login=?";
        $sth = $dbh->prepare($query);
        $sth->execute(array($login));
        if ($sth->fetch()) {
            $sth->closeCursor();
            return Registration::$FEEDBACK["login_in_use"];
        }
        $sth->closeCursor();

        $query = "INSERT INTO users (email, pwd, login, name, surname, birthday) VALUES (?, ?, ?, ?, ?, ?)";
        $sth = $dbh->prepare($query);
        $success = $sth->execute(array($email, sha1($pwd), $login, $name, $surname, $birthday));
        $sth->closeCursor();
        if ($success) {
            return Registration::$FEEDBACK["success"];
        } else {
            return Registration::$FEEDBACK["unknown_error"];
        }

    }




  public static function generate_form($feedback, $defaults){
    // $success -> boolean indicating if this was called after a successful registration
    // $message -> string with error message
    //             if $message is non-empty, we display it
    //             else we hide
    // $default -> array with default inputs for input tags

    if ($feedback["show_defaults"]){
      $defaults = array_map(htmlspecialchars, $defaults);
    } else {
      $defaults = Registration::$DEFAULTS;
    }

    echo <<<flag
  <form class="form-signin needs-validation" method="post" novalidate>
    <img class="mb-4" src="media/mathmaroc.png" alt="" width="100" height="72" type="image/svg+xml">

    <label for="inputEmail" class="sr-only">Adresse Mail$</label>
    <input type="email" id="inputEmail" class="form-control not-last-element" name="email" placeholder="Adresse mail" value="{$defaults["email"]}" required autofocus>

    <label for="inputPassword" class="sr-only not-last-element">Mot de passe</label>
    <input type="password" id="inputPassword" class="form-control not-last-element" placeholder="Mot de passe" name="pwd" required>

    <label for="inputPasswordConfirmation" class="sr-only">Mot de passe</label>
    <input type="password" id="inputPasswordConfirmation" class="form-control not-last-element" placeholder="Veuillez confirmer votre mot de passe" name="conf" required>

    <label for="inputLogin" class="sr-only">Pseudo</label>
    <input type="text" id="inputLogin" class="form-control not-last-element" placeholder="Pseudo" name="login" value="{$defaults["login"]}" required>

    <label for="inputName" class="sr-only">Prénom</label>
    <input type="text" id="inputName" class="form-control not-last-element" placeholder="Prénom" name="name" value="{$defaults["name"]}" required>

    <label for="inputSurname" class="sr-only">Nom de Famille</label>
    <input type="text" id="inputSurname" class="form-control not-last-element" placeholder="Nom de famille" name="surname" value="{$defaults["surname"]}" required>

    <label for="inputBirthday" class="sr-only"> de Naissance</label>
    <input type="date" id="inputBirthday" class="form-control last-element" placeholder="Date de Naissance" name="birthday" value="{$defaults["email"]}" required>

    <button class="btn btn-lg btn-primary btn-block" type="submit">Inscription</button>

    <a href="index.php?action=login" style="margin: 0px; padding: 0px;">Connexion ?</a>
    <a href="index.php?action=forgot" style="margin-top: 0px; padding-top: 0px;">Vous avez oublié votre mot de passe ?</a>
    <div class='alert alert-{$feedback["alert_status"]}' role='alert' style='visibility: {$feedback["visibility"]}; font-size: 0.9rem;'> {$feedback["message"]} </div>
  </form>
  <script src="js/password_matching.js"></script>visibilty
  <script src="js/general_form_validation.js"></script>
  <script src="{$feedback["script"]}">./script>
flag;

  }



}


function attempt_send_reset_link($email)
{
  // this is a template logic for what we should actually do
    $mail_sent = false;
    $account_found = false;
    if ($account_found) {
      // normally should query the db to check if the account exists
      // if so create a private page with input tag, and send it via email
        if ($mail_sent) {
          // if the email server send the mail successfully
            return array("success" => true, "message" => "Vérifiez votre mail.");
        } else {
          // if the email server fails to send the mail successfully
            return array("success" => false, "message" => "Opération échouée.");
        }
    } else {
        return array("success" => false, "message" => "Compte introuvable.");
    }
}

function generate_forgot_password_form($success, $message){
  $visibility = "visible";
  $alert_status = "danger";
  if ($message == ""){
    $visibility = "hidden";
  }
  if ($success){
    $alert_status = "success";
  }
  echo<<<flag
<form class="form-signin needs-validation" method="post" novalidate>
  <img class="mb-4" src="media/mathmaroc.png" alt="" width="100"="image/svg+xml">

  <label for="inputEmail" class="sr-only">Adresse mail</label>
  <input type="email" id="inputEmail" class="form-control last-element" name="email" placeholder="Adresse mail" required autofocus>

  <button class="btn btn-lg btn-primary btn-block" type="submit">Réinitialisation</button>

  <a href="index.php?action=register" style="margin: 0px; padding: 0px;">Première visite sur ce site ?</a>
  <a href="index.php?action=login" style="margin-top: 0px; padding-top: 0px;">Connexion ?</a>

  <div class='alert alert-$alert_status' role='alert' style='visibility: $visibility;'> $message </div>
</form>
<script src="js/general_form_validation.js"></script>
flag;

}




function attempt_logout()
{
    // these conditionals are for debugging reasons. If we do this well, we
    // won't have to verify that $_SESSION is set and use is logged in.
    if (isset($_SESSION["logged_in"])) {
        session_unset();
        session_destroy();
    } else {
        // for debugging purposes
        throw new Exception("bad bad bad, you can't log out if you aren't logged in");
    }
}
