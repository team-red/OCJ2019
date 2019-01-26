<?php

    class Attempt
    {
        public $id;
        public $user_login;
        public $answer_id;

        public static function hasAttemptedQcm($dbh, $id_qcm, $user_login)
        {
            $query = "SELECT attempt.id FROM attempt
                      JOIN answer ON attempt.answer_id = answer.id
                      JOIN qst ON answer.id_qst = qst.id
                      WHERE qst.id_qcm=? AND attempt.user_login=?";
            $sth = $dbh->prepare($query);
            $sth->execute(array($id_qcm, $user_login));
            if ($id = $sth->fetch()){
                $sth->closeCursor();
                return true;
            } else {
                $sth->closeCursor();
                return false;
            }
        }

        public static function insert($dbh, $data, $user_login)
        {
            $query = "INSERT INTO attempt (user_login, answer_id) VALUES (?, ?);";
            $errors = 0;
            foreach ($data as $answer_id) {
                $sth = $dbh->prepare($query);
                $success = $sth->execute(array($user_login, $answer_id));
                if ($success === false){
                    $errors++;
                }
                $sth->closeCursor();
            }
            if ($errors === 0){
                return true;
            } else {
                return false;
            }
        }
    }

?>