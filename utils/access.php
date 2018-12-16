<?php
function generate_registration_form($success, $message){
  // $success boolean indicating if this was called after a successful registration
  // $message string indicating an error message
  // if this was called operation after an attempted registration, I assure $message is non empty
  // else, the $message variable is an empty string
  $visibility = "visible";
  $alert_status = "danger";
  if ($message == ""){
    $visibility = "hidden";
  }
  if ($success){
    $alert_status = "success";
  }
  echo <<<flag
  <form class="form-signin needs-validation" method="post" novalidate>
    <img class="mb-4" src="media/mathmaroc.png" alt="" width="100" height="72" type="image/svg+xml">

    <label for="inputEmail" class="sr-only">Adresse Mail</label>
    <input type="email" id="inputEmail" class="form-control not-last-element" name="email" placeholder="Adresse mail" required autofocus>

    <label for="inputPassword" class="sr-only not-last-element">Mot de passe</label>
    <input type="password" id="inputPassword" class="form-control not-last-element" placeholder="Mot de passe" name="pwd" required>

    <label for="inputPasswordConfirmation" class="sr-only">Mot de passe</label>
    <input type="password" id="inputPasswordConfirmation" class="form-control not-last-element" placeholder="Veuillez confirmer votre mot de passe" name="conf" required>

    <label for="inputLogin" class="sr-only">Pseudo</label>
    <input type="text" id="inputPseudo" class="form-control not-last-element" placeholder="Pseudo" name="login" required>

    <label for="inputName" class="sr-only">Prénom</label>
    <input type="text" id="inputName" class="form-control not-last-element" placeholder="Prénom" name="name" required>

    <label for="inputSurname" class="sr-only">Nom de Famille</label>
    <input type="text" id="inputSurname" class="form-control not-last-element" placeholder="Nom de famille" name="surname" required>

    <label for="inputBirthday" class="sr-only"> de Naissance</label>
    <input type="date" id="inputBirthday" class="form-control last-element" placeholder="Date de Naissance" name="birthday" required>

    <button class="btn btn-lg btn-primary btn-block" type="submit">Inscription</button>

    <a href="index.php?action=login" class="btn btn-default" style="margin: 0px; padding: 0px;">Connexion ?</a>
    <a href="index.php?action=login" class="btn btn-default" style="margin-top: 0px; padding-top: 0px;">Vous avez oublié votre mot de passe ?</a>

    <div class='alert alert-$alert_status' role='alert' style='visibility: $visibility; margin-top: 0px; font-size: 0.9rem;'> $message </div>
  </form>
  <script src="js/password_matching.js"></script>
  <script src="js/general_form_validation.js"></script>
flag;
}

function generate_login($failed)
{
  // just outputs the login form
  // $failed is a boolean, indicating if this function was called after
  // a failed login. In such a case, we print a small warning to let
  // the user know his attempt failed.
  // There is some JavaScript included at the end to verify input (in a non-standard way)
    $visibility = "hidden";
    if ($failed) {
        $visibility = "visible";
    }
    echo<<<flag
  <form class="form-signin needs-validation" method="post" novalidate>
    <img class="mb-4" src="media/mathmaroc.png" alt="" width="100"="image/svg+xml">

    <label for="inputEmail" class="sr-only">Nom d'utilisateur</label>
    <input type="email" id="inputEmail" class="form-control not-last-element" name="email" placeholder="Adresse mail" required autofocus>

    <label for="inputPassword" class="sr-only">Mot de passe</label>
    <input type="password" id="inputPassword" class="form-control last-element" placeholder="Mot de passe" name="pwd" required>

    <button class="btn btn-lg btn-primary btn-block" type="submit">Connexion</button>

    <a href="index.php?action=register" class="btn btn-default" style="margin: 0px; padding: 0px;">Première visite sur ce site ?</a>
    <a href="index.php?action=login" class="btn btn-default" style="margin-top: 0px; padding-top: 0px;">Vous avez oublié votre mot de passe ?</a>

    <div class='alert alert-danger' role='alert' style='visibility: $visibility; margin-top: 0px;'> Connexion échouée. </div>
  </form>
  <script src="js/general_form_validation.js"></script>


flag;
}

function attempt_registration($dbh, $data)
{
  // attempts to register user.
  // returns an array with keys "success" & "message"
  // success -> whether or not the operation was successful
  // message -> error message to output to user in case
  //            the operation failed. Defaults to an empty string
    $attempt = array("success" => true, "error_message" => "");

    $email = $data["email"];
    $pwd = $data["pwd"];
    $pwd_conf = $data["conf"];
    $login = $data["login"];
    $name = $data["name"];
    $surname = $data["surname"];
    $birthday = $data["birthday"];

    if ($pwd != $pwd_conf){
      $attempt["success"] = false;
      $attempt["message"] = "Les mots de passe ne sont pas identiques";
      return $attempt;
    }

    $query = "SELECT * FROM users WHERE email=?";
    $sth = $dbh->prepare($query);
    $sth->execute(array($email));
    if ($sth->fetch()) {
      $sth->closeCursor();
        $attempt["success"] = false;
        $attempt["message"] = "Cette adresse e-mail est déjà utilisée";
        return $attempt;
    }
    $sth->closeCursor();

    $query = "SELECT * FROM users WHERE login=?";
    $sth = $dbh->prepare($query);
    $sth->execute(array($login));
    if ($sth->fetch()) {
      $sth->closeCursor();
        $attempt["success"] = false;
        $attempt["message"] = "Ce pseudonyme est déjà utilisé";
        return $attempt;
    }
    $sth->closeCursor();

    $query = "INSERT INTO users (email, pwd, login, name, surname, birthday) VALUES (?, ?, ?, ?, ?, ?)";
    $sth = $dbh->prepare($query);
    $success = $sth->execute(array($email, sha1($pwd), $login, $name, $surname, $birthday));
    $attempt["success"] = $success;
    if ($success){
      $attempt["message"] = "Ajout avec succès.";
    } else{
      $attempt["message"] = "Ajout échoué.";
    }
    $sth->closeCursor();
    return $attempt;
}


function attempt_login($dbh, $email, $pwd)
{
    // returns boolean. We first verify if this email is in the database.
    // If not, we return false. If so, we compare passwords.
    $query = "SELECT pwd FROM users WHERE email=?;";
    $sth = $dbh->prepare($query);
    $sth->execute(array($email));
    if ($user = $sth->fetch()) {
        if (sha1($pwd) == $user["pwd"]) {
            // pwd is valid
            return true;
        } else {
            return false;
        }
    } else {
        // user not found in DB
        return false;
    }
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
