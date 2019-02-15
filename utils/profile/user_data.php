<?php

require_once("utils/profile/user.php");
require_once("utils/quiz/qcm.php");
require_once("utils/quiz/qst.php");

class UserData
{

    public static function numberOfQcmsTried($dbh, $user){
        $query = "SELECT COUNT(DISTINCT qcm.id) FROM stamps
                  JOIN qcm ON qcm.id = stamps.id_qcm
                  WHERE stamps.user_login=?;";
        $sth = $dbh->prepare($query);
        $sth->execute(array($user->login));
        $count = $sth->fetch()[0];
        $sth->closeCursor();
        return $count;

    }

    public static function numberOfQcmsSucceded($dbh, $user){
        $qcmData = UserData::fromEmail($dbh, $user);
        $count = 0;
        foreach ($qcmData as $key => $qcmStaf) {
          if(intval($qcmStaf["qcm_score"]) >= intval($qcmStaf["qcm"]->max_score)){
            $count++;
          }
        }
        return $count;

    }

    public static function scoreOutOfTwenty($dbh, $user){
        $qcmData = UserData::fromEmail($dbh, $user);
        $count = 0;
        $max = 0;
        foreach ($qcmData as $key => $qcmStaf) {
          $count += $qcmStaf["qcm_score"];
          $max += $qcmStaf["qcm"]->max_score;
        }

        $max = ($max === 0) ? 1 : $max;
        return number_format(($count / $max) * 20, 0);
    }

    public static function numberOfQcms($dbh){
        $query = "SELECT COUNT(DISTINCT qcm.id) FROM qcm;";
        $sth = $dbh->prepare($query);
        $sth->execute(array());
        $count = $sth->fetch()[0];
        $sth->closeCursor();
        return $count;
    }

    public static function fromEmail($dbh, $user){
        $query = "SELECT DISTINCT qcm.id, qcm.title, qcm.max_score, qcm.start_time FROM stamps
                  JOIN qcm ON qcm.id = stamps.id_qcm
                  WHERE stamps.user_login=?;";
        $sth = $dbh->prepare($query);
        $sth->setFetchMode(PDO::FETCH_CLASS, 'Qcm');
        $sth->execute(array($user->login));
        $qcms = $sth->fetchAll();
        $sth->closeCursor();
        foreach ($qcms as $qcm){
            $qcm->questions = Qst::getAll($dbh, $qcm->id);
        }

        $res = array();
        foreach ($qcms as $qcm){
            $qcm_res = array();
            $qcm_res["qcm"] = $qcm;
            $qcm_res["scores"] = UserData::getScores($dbh, $qcm->id, $user);
            $num = 0;
            $qcm_score = 0;
            foreach ($qcm_res["scores"] as $score) {
                $num += $score["is_correct"];
                $qcm_score += $score["score"];
            }
            $qcm_res["correct_ans"] = $num;
            $qcm_res["qcm_score"] = $qcm_score;
            $res[] = $qcm_res;
        }
        return $res;

    }

    public static function getAllScoresAndRanks($dbh){
      $allUsersScoresAndRanks = array();
      $users = User::getAll($dbh);
      foreach($users as $user){
        $userScore = 0;
        $data = UserData::fromEmail($dbh, $user);
        foreach($data as $qcmData){
          $userScore += $qcmData['qcm_score'];
        }
        array_push($allUsersScoresAndRanks, array($userScore, $user));
      }

      function method($a,$b){
        return ($a[0] >= $b[0]) ? -1 : 1;
      }
      usort($allUsersScoresAndRanks, "method");

      return $allUsersScoresAndRanks;
    }


public static function getAllQuizes($dbh, $user){

        $query = "SELECT DISTINCT qcm.id, qcm.start_time FROM attempt
                  JOIN answer ON attempt.answer_id = answer.id
                  JOIN qst ON answer.id_qst = qst.id
                  JOIN qcm ON qcm.id = id_qcm
                  WHERE attempt.user_login=?
                  ORDER BY qcm.start_time DESC;";
        $sth = $dbh->prepare($query);
        $sth->execute(array($user->login));
        $qcms = $sth->fetchAll();
        $sth->closeCursor();

        $finalResult = array();

        foreach ($qcms as $qcmData){

          $qcm = Qcm::fromId($dbh, $qcmData[0]);
          if ($qcm === false){
              return false;
          }
          $minutes = ($qcm->duration_seconds) / 60;
          $minutes = htmlspecialchars(filter_var($minutes, FILTER_VALIDATE_INT));
          $seconds = htmlspecialchars($qcm->duration_seconds);
          $title = htmlspecialchars($qcm->title);
          $result = "";
          $result = $result. "<span style='visibility: hidden;' id='quiz-duration-show'>$seconds</span>
          <form method='post' class='quiz_main_form'>
              <span style='font-size: x-large;'><b>$title</b> ($minutes minutes)</span>
              ";

          $qsts = $qcm->questions;
          foreach ($qsts as $qkey => $qst) {
              $enum = $qkey + 1;
              $q_body = htmlspecialchars($qst->body);
              $result = $result. "<div><span style='font-size: large;'>Question $enum</span>
              <div><span>$q_body</span><br><br>";

              $answers = $qst->answers;
              foreach ($answers as $akey => $ans){

                $query = "SELECT answer.score, answer.is_correct FROM attempt
                          JOIN answer ON attempt.answer_id = answer.id
                          JOIN qst ON answer.id_qst = qst.id
                          JOIN qcm ON qcm.id = id_qcm
                          WHERE attempt.user_login=? AND qcm.id=? AND attempt.answer_id=?;";

                $sth = $dbh->prepare($query);
                $sth->execute(array($user->login, $qcmData[0], $ans->id));
                $answerData = $sth->fetch();
                $checked = ($answerData) ? " checked" : " ";
                $color = "unset";
                if($checked === " checked") $color = ($answerData[1] == 1) ? "green" : "red";
                $score = $ans->score;
                $sth->closeCursor();

                  $a_enum = $akey + 1;
                  $a_body = htmlspecialchars($ans->body);
                  $result = $result. "
                  <div class='custom-control custom-radio'>
                      <input disabled='disabled' type='radio' class='custom-control-input' name='ans[$qkey]' value='{$ans->id}'{$checked}>
                      <label class='custom-control-label' style='color: $color' for='qst{$enum}-ans$a_enum'>$a_body ($score pts)</label>
                  </div>";
              }
              $result = $result."</div><br></div>";
        }
          $result = $result. "</form>";
          array_push($finalResult,array($result, $qcm));
}
  return $finalResult;
}


    public static function getScores($dbh, $qcm_id, $user){
        $query = "SELECT answer.score, qst.max_score, answer.is_correct FROM attempt
                  JOIN answer ON attempt.answer_id = answer.id
                  JOIN qst ON answer.id_qst = qst.id
                  JOIN qcm ON qcm.id = id_qcm
                  WHERE qcm.id=? AND attempt.user_login=?;";

        $sth = $dbh->prepare($query);
        $sth->execute(array($qcm_id, $user->login));
        $scores = $sth->fetchAll();
        $sth->closeCursor();
        return $scores;
    }



    public static function unblockUserQcm($dbh, $login, $qcm_id){
        // get the attempt ids to clear
        $query = "SELECT attempt.id FROM attempt
        JOIN answer ON attempt.answer_id = answer.id
        JOIN qst ON answer.id_qst = qst.id
        JOIN qcm ON qcm.id = id_qcm
        WHERE attempt.user_login = ?
        AND id_qcm = ?;";

        $sth = $dbh->prepare($query);
        $sth->execute(array($login, $qcm_id));
        $data = $sth->fetchAll();
        $sth->closeCursor();

        // clear the attempts
        foreach($data as $attempt){
            $attempt_id = $attempt[0];
            $query = "DELETE FROM attempt WHERE id=?;";
            $sth = $dbh->prepare($query);
            $sth->execute(array($attempt_id));
            $sth->closeCursor();
        }

        // clearing the timestamps so the user can access the forms again
        $query = "DELETE FROM stamps WHERE id_qcm=? AND user_login=?;";
        $sth = $dbh->prepare($query);
        $sth->execute(array($qcm_id, $login));
        $sth->closeCursor();
    }
}


?>
