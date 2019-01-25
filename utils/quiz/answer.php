<?php

    class Answer
    {
        public $id;
        public $id_qst;
        public $body;
        public $is_correct;
        public $score;

        public static function getAll($dbh, $id_qst)
        {
            $query = "SELECT * FROM main.answer WHERE id_qst=? ORDER BY id DESC;";
            $sth = $dbh->prepare($query);
            $sth->setFetchMode(PDO::FETCH_CLASS, 'Answer');
            $sth->execute(array($id_qst));
            $answers = $sth->fetchAll();
            $sth->closeCursor();
            return $answers;
        }

        public static function insert($dbh, $qst_id, $body, $score, $is_correct)
        {
            // attempts inserting the answer in the database
            // on success, it returns the boolean true
            // on failure, it returns the boolean false
            $query = "INSERT INTO answer (id_qst, body, is_correct, score) VALUES (?, ?, ?, ?);
                      SELECT LAST_INSERT_ID();";
            $sth = $dbh->prepare($query);
            $success = $sth->execute(array(
                $qst_id,
                $body,
                $is_correct,
                $score
            ));
            $sth->closeCursor();
            return $success;
        }

        
    }

?>