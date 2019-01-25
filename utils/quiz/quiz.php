<?php

    require_once("utils/quiz/qcm.php");

    class Quiz
    {

        public static function createForm($dbh, $qcm_id)
        {
            $qcm = Qcm::fromId($dbh, $qcm_id);
            if ($qcm === false){
                echo "LOL QCM NOT FOUND";
                return false; 
            }
            //require_once("utils/quiz/bla.html");
            echo <<<flag

            <form method="post">

                <center>$qcm->title</center>

flag;
            $qsts = $qcm->questions;
            foreach ($qsts as $qkey => $qst) {
                $qkey++;
                echo "<div><center>Question $qkey</center>";
                $answers = $qst->answers;
                foreach ($answers as $akey => $ans){
                    echo <<<flag
                    <div class="custom-control custom-radio">
                        <input type="radio" class="custom-control-input" id="qst{$qkey}-ans$akey" name="qst{$qkey}[]">
                        <label class="custom-control-label" for="qst{$qkey}-ans$akey">$ans->body</label>
                    </div>
flag;
                }
                echo "</div>";

            }
            echo <<<flag
            </form>
flag;
        }

    }


?>