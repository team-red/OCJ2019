<?php

    require_once("utils/quiz/qcm.php");

    class Quiz
    {

        public static function timedOut()
        {
            echo <<<flag
            <br><br><br>
            <h1 class="display-3">Durée maximale dépassée. Réponse refusée!</h1>
flag;
        }

        public static function denyAccess()
        {
            echo <<<flag
            <br><br><br>
            <h1 class="display-3">Vous avez déjà répondu!</h1>
flag;
        }

        public static function attemptFailed()
        {
            echo <<<flag
            <br><br><br>
            <h1 class="display-3">Erreur!</h1>
flag;
        }

        public static function attemptSucceeded()
        {
            echo <<<flag
            <br><br><br>
            <h1 class="display-3">Réponse enregistrée!</h1>
flag;
        }

        public static function createForm($dbh, $qcm_id)
        {
            $qcm = Qcm::fromId($dbh, $qcm_id);
            if ($qcm === false){
                return false;
            }
            $minutes = ($qcm->duration_seconds) / 60;
            $minutes = htmlspecialchars(filter_var($minutes, FILTER_VALIDATE_INT));
            $seconds = htmlspecialchars($qcm->duration_seconds);
            $title = htmlspecialchars($qcm->title);
            echo <<<flag
            <span style="visibility: hidden;" id="quiz-duration-send">$seconds</span>
            <form method='post' class='quiz_main_form'>

                <div style="font-size: medium;">
                <h4>Bonjour!</h4>
                <br>
                - Lisez <b> bien </b> les questions, ne répondez que si vous êtes <b> sûrs </b> de la réponse
                il y a souvent des reponses <b>pénalisantes</b>! <br>
                - Pour répondre choisissez la bonne réponse et cochez la case correspondante.<br>
                - Vous avez <b> $minutes minutes </b> pour valider vos réponses, dans le cas contraire
                les réponses seront validés automatiquement!.
                </div>
                <br><br>
                <div class="quiz_container">
                <span style='font-size: large;'><b>Titre du questionnaire :</b> $title</span>
                <center><span id="timer"></span></center><br><br>

flag;
            $qsts = $qcm->questions;
            foreach ($qsts as $qkey => $qst) {
                $enum = $qkey + 1;
                $q_body = htmlspecialchars($qst->body);
                echo <<<flag
                <div><span style='font-size: large;'>Question $enum :</span>
                <br>
                <div><span>$q_body</span><br><br>
flag;
                $answers = $qst->answers;
                foreach ($answers as $akey => $ans){
                    $checked = ($akey === 0) ? " checked" : " ";
                    $a_enum = $akey + 1;
                    $a_body = htmlspecialchars($ans->body);
                    echo <<<flag

                    <div class="custom-control custom-radio">
                        <input type="radio" class="custom-control-input" id="qst{$enum}-ans$a_enum" name="ans[$qkey]" value="{$ans->id}"{$checked}>
                        <label class="custom-control-label" for="qst{$enum}-ans$a_enum">$a_body</label>
                    </div>
flag;
                }
                echo "</div></div>";

            }
            echo <<<flag
                <div class="button_send_quiz"><button class="btn btn-lg btn-primary btn-block" type="submit" id="submit-form">Envoyez</button></div>
            </div>
            </form>
            <script src="js/quiz_timeout/timeout.js">
flag;
        }

    }


?>
