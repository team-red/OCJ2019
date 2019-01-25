<?php

    class Qcm
    {
        public $id; // integer
        public $author_login; // string
        public $start_time; // date
        public $duration_seconds; // in seconds
        public $is_corrected; // boolean (int)
        public $title; // string
        public $max_score; // int

        public static function getAll($dbh)
        {
            $query = "SELECT * FROM main.qcm ORDER BY start_time DESC;";
            $sth = $dbh->prepare($query);
            $sth->setFetchMode(PDO::FETCH_CLASS, 'Qcm');
            $sth->execute();
            $qcms = $sth->fetchAll();
            $sth->closeCursor();
            return $qcms;
        }

        public static function fromId($dbh, $id)
        {
            $query = "SELECT * FROM main.qcm WHERE id=?;";
            $sth = $dbh->prepare($query);
            $success = $sth->execute(array($id));
            // use success for debugging
            $sth->setFetchMode(PDO::FETCH_CLASS, 'Qcm');
            $sth->execute();
            $qcm = $sth->fetch();
            $sth->closeCursor();
            return $qcm;
        }
    }

?>