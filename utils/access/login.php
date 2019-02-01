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
      "script" => "js/form_validation/invalid_pwd.js",
      "visibility" => "visible",
      "show_defaults" => true
    ),
    "email_not_found" => array(
      "message" => "Adresse mail introuvable.",
      "success" => false,
      "script" => "js/form_validation/invalid_email.js",
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

    public static function attempt($dbh, $email, $pwd)
    {
        // returns boolean. We first verify if this email is in the database.
        // If not, we return false. If so, we compare passwords.
        $query = "SELECT pwd FROM users WHERE email=?;";
        $sth = $dbh->prepare($query);
        $success = $sth->execute(array($email));
        if (!$success) {
            return Login::$FEEDBACK["unknown_error"];
        }
        if ($user = $sth->fetch()) {
            if (password_verify($pwd, $user["pwd"]) === true) {
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

    public static function generate_form($feedback, $default_email)
    {
        if ($feedback["show_defaults"]) {
            $default_email = htmlspecialchars($default_email);
        } else {
            $default_email = Login::$DEFAULT_EMAIL;
        }
        $js_src = $feedback["script"];
        $js_tag = $js_src !== "" ? "<script src='$js_src'></script>" : "";

        echo<<<flag
  <form class="form-signin needs-validation" id="login-form" method="post" novalidate>
    <img class="mb-4" src="media/mathmaroc.png" alt="logo Math&Maroc" width="100">

    <label for="inputEmail" class="sr-only">Adresse mail</label>
    <input type="email" id="inputEmail" class="form-control not-last-element" name="email" placeholder="Adresse mail" value="$default_email" required>

    <label for="inputPassword" class="sr-only">Mot de passe</label>
    <input type="password" id="inputPassword" class="form-control last-element" placeholder="Mot de passe" name="pwd" required>

    <button class="btn btn-lg btn-primary btn-block" type="submit">Connexion</button>

    <a href="index.php?action=register" style="margin: 0px; padding: 0px;">Première visite sur ce site ?</a>
    <a href="index.php?action=forgot" style="margin-top: 0px; padding-top: 0px;">Vous avez oublié votre mot de passe ?</a>

    <div class='alert alert-danger' role='alert' style='visibility: {$feedback["visibility"]};'> {$feedback["message"]} </div>
  </form>
  <script src="js/form_validation/block_invalid_forms.js"></script>
  <script src="js/form_validation/login_form.js"></script>
  $js_tag;
flag;
    }
}
