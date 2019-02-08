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

    public static function fromEmail($dbh, $user){
        $query = "SELECT DISTINCT qcm.id, qcm.title, qcm.max_score, qcm.start_time FROM stamps
                  JOIN qcm ON qcm.id = stamps.id_qcm
                  WHERE stamps.user_login=?
                  ORDER BY qcm.start_time DESC;";
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