<?php

    require_once("utils/quiz/qst.php");

    class Qcm
    {
        public $id; // integer
        public $author_login; // string
        public $start_time; // date
        public $duration_seconds; // in seconds
        public $is_corrected; // boolean (int)
        public $title; // string
        public $max_score; // int
        public $questions;

        public static function getAll($dbh)
        {
            $query = "SELECT * FROM qcm ORDER BY start_time DESC;";
            $sth = $dbh->prepare($query);
            $sth->setFetchMode(PDO::FETCH_CLASS, 'Qcm');
            $sth->execute();
            $qcms = $sth->fetchAll();
            $sth->closeCursor();
            foreach ($qcms as $qcm) {
                $qcm->questions = Qst::getAll($dbh, $qcm->id);
            }
            return $qcms;
        }

        public static function fromId($dbh, $id)
        {
            // return false on fail
            $query = "SELECT * FROM main.qcm WHERE id=?;";
            $sth = $dbh->prepare($query);
            $success = $sth->execute(array($id));
            if ($success === false){ return false; }
            $sth->setFetchMode(PDO::FETCH_CLASS, 'Qcm');
            $sth->execute(array($id));
            if ($qcm = $sth->fetch()){
                $sth->closeCursor();
                $qcm->questions = Qst::getAll($dbh, $qcm->id);
                return $qcm;
            } else {
                $sth->closeCursor();
                return false;
            }
        }

        public static function insert($dbh, $author_login, $duration, $title, $score)
        {
            // attempts inserting the qcm in the database
            // on success, it returns its id
            // on failure, it returns the boolean false
            $query = "INSERT INTO qcm (author_login, duration_seconds, title, max_score) VALUES (?, ?, ?, ?);";
            $sth = $dbh->prepare($query);
            $success = $sth->execute(array(
                $author_login,
                $duration,
                $title,
                $score
            ));
            if ($success === false){ return false; }
            $sth->closeCursor();

            $query = "SELECT LAST_INSERT_ID();";
            $sth = $dbh->prepare($query);
            $success = $sth->execute(array());
            if ($success === false){ return false; }

            if ($qcm_id = $sth->fetch()){
                $sth->closeCursor();
                return $qcm_id[0];
            } else {
                $sth->closeCursor();
                return false;
            }

        }

        public static function del($dbh, $qcm_id){

          $query = "DELETE FROM qcm WHERE id=?;";
          $sth = $dbh->prepare($query);
          $sth->execute(array($qcm_id));
          $sth->closeCursor();

        }
    }

?>
