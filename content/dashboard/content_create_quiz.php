<?php

    // verify later that i am admin here

    require_once("utils/quiz/quiz_form.php");
    if (isset($_POST["title"])){
        $momentOfTruth = QuizForm::getData($_POST);
        if ($momentOfTruth === false) {
            echo ":(";
        }
        else{
            print_r($momentOfTruth);
        }
    }
    QuizForm::generate_form();

?>