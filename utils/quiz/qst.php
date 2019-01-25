<?php

    require_once("utils/quiz/answer.php");

    class Qst
    {
        public $id;
        public $id_qcm;
        public $body;
        public $max_score;
        public $answers;

        public static function getAll($dbh, $id_qcm)
        {
            $query = "SELECT * FROM main.qst WHERE id_qcm=? ORDER BY id DESC;";
            $sth = $dbh->prepare($query);
            $sth->setFetchMode(PDO::FETCH_CLASS, 'Qst');
            $sth->execute(array($id_qcm));
            $questions = $sth->fetchAll();
            $sth->closeCursor();
            foreach ($questions as $question) {
                $question->answers = Answer::getAll($dbh, $question->id);
            }
            return $questions;
        }

        public static function insert($dbh, $id_qcm, $body, $max_score)
        {
            // attempts inserting the qst in the database
            // on success, it returns its id
            // on failure, it returns the boolean false
            $query = "INSERT INTO qst (id_qcm, body, max_score) VALUES (?, ?, ?);";
            $sth = $dbh->prepare($query);
            $success = $sth->execute(array(
                $id_qcm,
                $body,
                $max_score
            ));
            if ($success === false){ return false; }
            $sth->closeCursor();

            $query = "SELECT LAST_INSERT_ID();";
            $sth = $dbh->prepare($query);
            $success = $sth->execute(array());
            if ($success === false){ return false; }
            if ($qst_id = $sth->fetch()){
                $sth->closeCursor();
                return $qst_id[0];
            } else {
                $sth->closeCursor();
                return false;
            }
        }
    }

?>