<?php

    require_once("utils/quiz/quiz_form.php");
    if (isset($_POST["title"])){
        $feedback = QuizForm::attempt($dbh, $user, $_POST);
        QuizForm::generate_form($feedback);
        
    } else {
        QuizForm::generate_form(QuizForm::$FEEDBACK["no_feedback"]);
    }

?>