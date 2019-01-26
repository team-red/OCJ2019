<?php

    class Timestamp
    {
        public $id;
        public $id_qcm;
        public $user_login;
        public $stamp;

        public static function touch($dbh, $id_qcm, $user_login)
        {
            $query = "INSERT INTO stamps (id_qcm, user_login) VALUES (?, ?)";
            $sth = $dbh->prepare($query);
            $sth->execute(array($id_qcm, $user_login));
            $sth->closeCursor();
        }

        public static function getStamp($dbh, $id_qcm, $user_login)
        {
            $query = "SELECT unix_timestamp(stamp) FROM stamps WHERE id_qcm=? AND user_login=?";
            $sth = $dbh->prepare($query);
            $sth->execute(array($id_qcm, $user_login));
            $stamp = $sth->fetch();
            $sth->closeCursor();
            return $stamp;
        }

        public static function hasStamp($dbh, $id_qcm, $user_login)
        {
            if (Timestamp::getStamp($dbh, $id_qcm, $user_login))
            {
                return true;
            } else {
                return false;
            }
        }
    }

?>