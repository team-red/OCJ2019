<?php
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
        "show_defaults" => false
      ),
      "email_in_use" => array(
        "message" => "Cette adresse e-mail est déjà utilisée.",
        "visibility" => "visible",
        "alert_status" => "danger",
        "show_defaults" => true
      ),
      "login_in_use" => array(
        "message" => "Ce pseudonyme est déjà utilisé.",
        "visibility" => "visible",
        "alert_status" => "danger",
        "show_defaults" => true
      ),
      "invalid_login" => array(
        "message" => "Login invalide.",
        "visibility" => "visible",
        "alert_status" => "danger",
        "show_defaults" => true
      ),
      "invalid_email" => array(
        "message" => "Email invalide.",
        "visibility" => "visible",
        "alert_status" => "danger",
        "show_defaults" => true
      ),
      "invalid_birthday" => array(
        "message" => "Date de naissance invalide.",
        "visibility" => "visible",
        "alert_status" => "danger",
        "show_defaults" => true
      ),
      "different_passwords" => array(
        "message" => "Les mots de passe ne sont pas identiques.",
        "visibility" => "visible",
        "alert_status" => "danger",
        "show_defaults" => true
      ),
      "unknown_error" => array(
        "message" => "Ajout échoué.",
        "visibility" => "visible",
        "alert_status" => "danger",
        "show_defaults" => true
      ),
      "success" => array(
        "message" => "Ajout avec succès.",
        "visibility" => "visible",
        "alert_status" => "success",
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

        $dt = DateTime::createFromFormat("Y-m-d", $birthday, new DateTimeZone('Europe/Paris'));
        if($dt === false || array_sum($dt->getLastErrors())){
          return Registration::$FEEDBACK["invalid_birthday"];
        }
        
        $match_res = preg_match('/^[a-zA-Z0-9_]{4,32}$/', $login); 
        if ($match_res === false || $match_res === 0){
          return Registration::$FEEDBACK["invalid_login"];
        }

        $match_res = preg_match('/^\S+@\S+$/', $email); 
        if ($match_res === false || $match_res === 0){
          return Registration::$FEEDBACK["invalid_email"];
        }

        if ($pwd !== $pwd_conf) {
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
        $success = $sth->execute(array($email, password_hash($pwd, PASSWORD_DEFAULT), $login, $name, $surname, $birthday));
        $sth->closeCursor();
        if ($success) {
            return Registration::$FEEDBACK["success"];
        } else {
            return Registration::$FEEDBACK["unknown_error"];
        }
    }
    public static function generate_form($feedback, $defaults)
    {
        // $success -> boolean indicating if this was called after a successful registration
        // $message -> string with error message
        //             if $message is non-empty, we display it
        //             else we hide
        // $default -> array with default inputs for input tags
        $escaped_defaults = array();
        if ($feedback["show_defaults"]) {
            foreach ($defaults as $index => $value) {
                $escaped_defaults[$index] = htmlspecialchars($value, ENT_QUOTES);
            }
        } else {
            $escaped_defaults = Registration::$DEFAULTS;
        }
        echo <<<flag
  <form class="form-signin needs-validation" id="registration-form" method="post" novalidate>
    <img class="mb-4" src="media/mathmaroc.png" alt="logo Math&Maroc" width="100">
    <div>
      <label for="inputEmail" class="sr-only">Adresse Mail$</label>
      <input type="email" id="inputEmail" class="form-control not-last-element" name="email" placeholder="Adresse mail" value="{$escaped_defaults["email"]}" required>
      <div class="valid-feedback ">Looks good!</div>
      <div class="invalid-feedback " id="email-invalid-feedback"></div>
    </div>
    <div>
      <label for="inputPassword" class="sr-only not-last-element">Mot de passe</label>
      <input type="password" id="inputPassword" class="form-control not-last-element" placeholder="Mot de passe" name="pwd" required>
      <label for="inputPasswordConfirmation" class="sr-only">Mot de passe</label>
      <input type="password" id="inputPasswordConfirmation" class="form-control not-last-element" placeholder="Veuillez confirmer votre mot de passe" name="conf" required>
      <div class="valid-feedback ">Looks good!</div>
      <div class="invalid-feedback " id="conf-invalid-feedback"></div>
    </div>
    <div>
      <label for="inputLogin" class="sr-only">Pseudo</label>
      <input type="text" id="inputLogin" class="form-control not-last-element" placeholder="Pseudo" name="login" value="{$escaped_defaults["login"]}" required>
      <div class="valid-feedback ">Looks good!</div>
      <div class="invalid-feedback " id="login-invalid-feedback"></div>
    </div>
    <div>
      <label for="inputName" class="sr-only">Prénom</label>
      <input type="text" id="inputName" class="form-control not-last-element" placeholder="Prénom" name="name" value="{$escaped_defaults["name"]}" required>
      <div class="valid-feedback ">Looks good!</div>
      <div class="invalid-feedback " id="name-invalid-feedback"></div>
    </div>
    <div>
      <label for="inputSurname" class="sr-only">Nom de Famille</label>
      <input type="text" id="inputSurname" class="form-control not-last-element" placeholder="Nom de famille" name="surname" value="{$escaped_defaults["surname"]}" required>
      <div class="valid-feedback ">Looks good!</div>
      <div class="invalid-feedback " id="surname-invalid-feedback"></div>
    </div>
    <div>
      <label for="inputBirthday" class="sr-only"> de Naissance</label>
      <input type="date" id="inputBirthday" class="form-control last-element" name="birthday" value="{$escaped_defaults["birthday"]}" required>
      <div class="valid-feedback last-feedback">Looks good!</div>
      <div class="invalid-feedback last-feedback" id="birthday-invalid-feedback"></div>
    </div>
    <button class="btn btn-lg btn-primary btn-block" type="submit">Inscription</button>
    <a href="index.php?action=login" style="margin: 0px; padding: 0px;">Connexion ?</a>
    <a href="index.php?action=forgot" style="margin-top: 0px; padding-top: 0px;">Vous avez oublié votre mot de passe ?</a>
    <div class='alert alert-{$feedback["alert_status"]}' role='alert' style='visibility: {$feedback["visibility"]}; font-size: 0.9rem;'> {$feedback["message"]} </div>
  </form>
  <script src="js/form_validation/zxcvbn.js"></script>
  <script src="js/form_validation/block_invalid_forms.js"></script>
  <script src="js/form_validation/registration_form.js"></script>
flag;
    }
}