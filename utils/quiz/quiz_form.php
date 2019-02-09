<?php

require_once("utils/quiz/qcm.php");

class QuizForm
{

    public static $debug = true;

    public static $FEEDBACK = array(
        "no_feedback" => array(
            "message" => "",
            "visibility" => "hidden",
            "alert_status" => ""
        ),
        "success" => array(
            "message" => "Ajout avec succès.",
            "visibility" => "visible",
            "alert_status" => "success",
        ),
        "failed" => array(
            "message" => "Erreur.",
            "visibility" => "visible",
            "alert_status" => "danger",
        )

    );

    public static function attempt($dbh, $user, $raw_data){

        $data = QuizForm::getData($raw_data);
        if ($data === false){
            return QuizForm::$FEEDBACK["failed"];
        }
        // eventually check if the data consistent
        // in terms of score

        // creating the qcm entry, and fetching its id
        $minutes =
        $qcm_id = Qcm::insert(
            $dbh,
            $user->login,
            $data["duration"] * 60, // in seconds
            $data["title"],
            $data["max_score"]
        );

        if ($qcm_id === false){
            return QuizForm::$FEEDBACK["failed"];
        }

        foreach ($data["questions"] as $qst) {
            // creating a question entry
            $qst_id = Qst::insert(
                $dbh,
                $qcm_id,
                $qst["body"],
                $qst["max_score"]
            );
            if ($qst_id === false){
                return QuizForm::$FEEDBACK["failed"];
            }
            foreach ($qst["answers"] as $ans) {
                // creating an answer entry
                $is_correct = ($ans["score"] === $qst["max_score"]) ? 1 : 0;
                // we consider an answer correct if it achieves max score
                $success = Answer::insert(
                    $dbh,
                    $qst_id,
                    $ans["body"],
                    $ans["score"],
                    $is_correct
                );
                if ($success === false) {
                    return QuizForm::$FEEDBACK["failed"];
                }
            }
        }
        return QuizForm::$FEEDBACK["success"];
    }

    public static function getData($from_post){

        $data = array();

        $names = array("title", "max-score", "max-duration");
        foreach ($names as $value) {
            if (!isset($from_post[$value])){
                if (QuizForm::$debug === true){
                    echo "Title/Max-score/Max-duration is not set in POST variable";
                }
                return false;
            }
        }

        $title = $from_post["title"];
        $max_score = $from_post["max-score"];
        $duration = $from_post["max-duration"];

        $data["title"] = $title;
        $data["max_score"] = $max_score;
        $data["duration"] = $duration;

        $questions = array();

        if (!isset($from_post["question-count"])){
            if (QuizForm::$debug === true){
                echo "Question count is not set in POST variable";
            }
            return false;
        }

        $question_count = $from_post["question-count"];

        if ( ($question_count = filter_var($question_count, FILTER_VALIDATE_INT)) === false ){
            if (QuizForm::$debug === true){
                echo "The question count could not be converted to an INT";
            }
            return false;
        }

        for ($i = 1; $i <= $question_count; $i++){

            $question = array();

            if (!isset($from_post["qst" . $i . "-body"]) || !isset($from_post["qst" .$i . "-max-score"])){
                if (QuizForm::$debug === true){
                    echo "Body/Max-score of question #$i is not set in POST variable";
                }
                return false;
            }

            $body = $from_post["qst" . $i . "-body"];
            $score = $from_post["qst" .$i . "-max-score"];

            if ( ($score = filter_var($score, FILTER_VALIDATE_INT)) === false ){
                if (QuizForm::$debug === true){
                    echo "Max score of question #$i could not be converted to an INT";
                }
                return false;
            }


            $question["body"] = $body;
            $question["max_score"] = $score;

            $answers = array();

            if (!isset($from_post["qst" . $i . "-count"])){
                if (QuizForm::$debug === true){
                    echo "Count of question #$i could not be found";
                }
                return false;
            }

            $answer_count = $from_post["qst" . $i . "-count"];

            if ( ($answer_count = filter_var($answer_count, FILTER_VALIDATE_INT)) === false ) {
                if (QuizForm::$debug === true){
                    echo "Count of question #$i could not be converted to an INT";
                }
                return false;
            }

            for ($j = 1; $j <= $answer_count; $j++){
                $answer = array();

                if (!isset($from_post["qst" . $i . "-ans" .$j . "-body"]) || !isset($from_post["qst" . $i . "-ans" .$j . "-score"])){
                    if (QuizForm::$debug === true){
                        echo "Body/Max-score of answer#$j/question#$i is not set in POST variable";
                    }
                    return false;
                }

                $body = $from_post["qst" . $i . "-ans" .$j . "-body"];
                $score = $from_post["qst" . $i . "-ans" .$j . "-score"];
                if ( ($score = filter_var($score, FILTER_VALIDATE_INT)) === false ){
                    if (QuizForm::$debug === true){
                        echo "Max-score of answer#$j/question#$i could not be converted to an INT";
                    }
                    return false;
                }

                $answer["body"] = $body;
                $answer["score"] = $score;
                $answers[] = $answer;
            }
            $question["answers"] = $answers;
            $questions[] = $question;

        }
        $data["questions"] = $questions;
        return $data;

    }

    public static function generate_form($feedback){
        echo <<<flag
        <script src="js/quiz_form/dynamic_fields.js"></script>

  <form method="post" id="create_quiz_form">
  <h1 style="padding: 1rem">Creez un nouveau questionaire: </h1>
  <br>
    <div class="form-group">
        <label for="qcm-title">Titre du questionnaire</label>
        <input type="text" id="qcm-title" class="form-control" placeholder="Titre" name="title" required>
    </div>

    <div class="form-group">
        <label for="qcm-max-score">Score maximum</label>
        <input type="number" id="qcm-max-score" class="form-control" placeholder="Score parfait" name="max-score" required>
    </div>

    <div class="form-group">
        <label for="qcm-max-duration">Durée</label>
        <input type="number" id="qcm-max-duration" class="form-control" placeholder="Durée en minutes" name="max-duration" required>
    </div>

    <div style="visibility: hidden;"><input type="number" id="question-count" name="question-count" value=1></div>

    <div id='questions'>

    <div class="qst" id="1">

        <div class="form-group">
            <div class="row">
                <div class="col-md">
                    Question 1
                </div>
                <div style="visibility: hidden;"><input type="number" id="qst1-count" name="qst1-count" value=1></div>
                <div class="col-md-1">
                    <a href="#" class="add-question"><i class="fa fa-plus"></i></a>
                </div>
            </div>
            <textarea cols="40" rows="5" id="qcm-qst1-body" class="form-control" placeholder="Texte de la question" name="qst1-body" required></textarea>
            <input type="number" id="qcm-qst1-max-score" class="form-control" placeholder="Score maximum" name="qst1-max-score" required>
        </div>

        <div class="form-row col-md-12">
            <div class="form-group col-md-5">
                <input type="text" class="form-control" id="qcm-qst1-ans1-body" placeholder="Réponse" name="qst1-ans1-body">
            </div>
            <div class="form-group col-md-5">
                <input type="number" class="form-control" id="qcm-qst1-ans1-score" placeholder="Score" name="qst1-ans1-score">
            </div>
            <div class="form-group col-md-1">
                <a href="#" class="qst1-add-answer"><i class="fa fa-plus"></i></a>
            </div>
        </div>

    </div>

    </div>

    <div class="mx-auto" style="width: 150px;">
        <button type="submit" class="btn btn-primary">Envoyez</button>
    </div>
    <br>
    <div class='alert alert-{$feedback["alert_status"]}' role='alert' style='visibility: {$feedback["visibility"]}; font-size: 0.9rem;'> {$feedback["message"]} </div>

</form>
flag;
    }
}



?>
