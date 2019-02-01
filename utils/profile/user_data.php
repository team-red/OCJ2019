<?php

require_once("utils/profile/user.php");
require_once("utils/quiz/qst.php");

class UserData
{

    public static function fromEmail($dbh, $email){
        $user = User::fromEmail($dbh, $email);
        $login = $user->login;
        
        $query = "SELECT qcm.id, qcm.title, qcm.max_score FROM attempt
                  JOIN answer ON attempt.answer_id = answer.id
                  JOIN qst ON answer.id_qst = qst.id
                  JOIN qcm ON qcm.id = id_qcm
                  WHERE attempt.user_login=?;";
        $sth = $dbh->prepare($query);
        $sth->setFetchMode(PDO::FETCH_CLASS, 'Qcm');
        $sth->execute(array($login));
        $qcms = $sth->fetchAll();
        $sth->closeCursor();
        foreach ($qcms as $qcm){
            $qcm->questions = Qst::getAll($dbh, $qcm->id);
        }

        $res = array();
        foreach ($qcms as $qcm){
            $qcm_res = array();
            $qcm_res["qcm"] = $qcm;
            $qcm_res["score"] = UserData::getScores($dbh, $qcm->id, $login);
            $num = 0;
            foreach ($qcm_res["score"] as $score) {
                $num += $score["is_correct"];
            }
            $qcm_res["correct_ans"] = $num;
            $res[] = $qcm_res;
        }
        return $res;

    }

    public static function getScores($dbh, $qcm_id, $login){
        $query = "SELECT answer.score, qst.max_score, answer.is_correct FROM attempt
                  JOIN answer ON attempt.answer_id = answer.id
                  JOIN qst ON answer.id_qst = qst.id
                  JOIN qcm ON qcm.id = id_qcm
                  WHERE qcm.id=? AND attempt.user_login=?;";
        $sth = $dbh->prepare($query);
        $sth->execute(array($qcm_id, $login));
        $scores = $sth->fetchAll();
        $sth->closeCursor();
        return $scores;

    }
}


?>