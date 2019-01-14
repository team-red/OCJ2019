<?php

class ResetPassword
{
    public static $DEFAULT_EMAIL = "";

    public static $FEEDBACK = array(
    "no_feedback" => array(
      "message" => "",
      "visibility" => "hidden",
      "alert_status" => "",
      "script" => "",
      "show_defaults" => false
    ),
    "email_not_found" => array(
      "message" => "Compte introuvable.",
      "visibility" => "visible",
      "alert_status" => "danger",
      "script" => "js/form_validation/invalid_email.js",
      "show_defaults" => true
    ),
    "success" => array(
      "message" => "Vérifiez votre mail.",
      "visibility" => "visible",
      "alert_status" => "success",
      "script" => "",
      "show_defaults" => false
    ),
    "unknown_error" => array(
      "message" => "Opération échouée.",
      "visibility" => "visible",
      "alert_status" => "danger",
      "script" => "",
      "show_defaults" => true
    )
  );

    public static function attempt($dbh, $email)
    {
        $test = rand(0, 3);
        if ($test == 0) {
            return ResetPassword::$FEEDBACK["no_feedback"];
        } elseif ($test == 1) {
            return ResetPassword::$FEEDBACK["email_not_found"];
        } elseif ($test == 2) {
            return ResetPassword::$FEEDBACK["success"];
        } elseif ($test == 3) {
            return ResetPassword::$FEEDBACK["unknown_error"];
        }
    }

    public static function generate_form($feedback, $default_email)
    {
        if ($feedback["show_defaults"]) {
            $default_email = htmlspecialchars($default_email);
        } else {
            $default_email = ResetPassword::$DEFAULT_EMAIL;
        }

        echo<<<flag

    <form class="form-signin needs-validation" method="post" id="forgot-form" novalidate>
      <img class="mb-4" src="media/mathmaroc.png" alt="" width="100"="image/svg+xml">

      <label for="inputEmail" class="sr-only">Adresse mail</label>
      <input type="email" id="inputEmail" class="form-control last-element" name="email" placeholder="Adresse mail" required>

      <button class="btn btn-lg btn-primary btn-block" type="submit">Réinitialisation</button>

      <a href="index.php?action=register" style="margin: 0px; padding: 0px;">Première visite sur ce site ?</a>
      <a href="index.php?action=login" style="margin-top: 0px; padding-top: 0px;">Connexion ?</a>

      <div class='alert alert-{$feedback["alert_status"]}' role='alert' style='visibility: {$feedback["visibility"]};'> {$feedback["message"]} </div>
    </form>
    <script src=js/form_validation/forgot_password_form.js></script>
    <script src="js/form_validation/block_invalid_forms.js"></script>
    <script src="{$feedback["script"]}"></script>

flag;
    }
}
