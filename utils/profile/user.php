<?php

    require_once("utils/quiz/timestamp.php");

    class User
    {
        public $login; // string
        public $surname; // string
        public $name; // string
        public $birthday; // date
        public $email; // email (string)
        public $signature; // string
        public $city; // string
        public $school; // string
        public $address; // string
        public $grade; // string
        public $role;

        public static $roles = array(
            'admin' => 'Administrateur',
            'user' => 'Utilisateur'
        );

        public static function getAll($dbh)
        {
            $query = "SELECT * FROM main.users ORDER BY role;";
            $sth = $dbh->prepare($query);
            $sth->setFetchMode(PDO::FETCH_CLASS, 'User');
            $sth->execute();
            $users = $sth->fetchAll();
            $sth->closeCursor();
            return $users;
        }

        public static function fromEmail($dbh, $email)
        {
            $query = 'SELECT * FROM users WHERE email=?;';
            $sth = $dbh->prepare($query);
            $success = $sth->execute(array($email));
            // use success for debugging
            $sth->setFetchMode(PDO::FETCH_CLASS, 'User');
            $sth->execute();
            $user = $sth->fetch();
            $sth->closeCursor();
            return $user;
        }

        public static function fromLogin($dbh, $login)
        {
            $query = 'SELECT * FROM users WHERE login=?;';
            $sth = $dbh->prepare($query);
            $success = $sth->execute(array($login));
            // use success for debugging
            $sth->setFetchMode(PDO::FETCH_CLASS, 'User');
            $sth->execute();
            $user = $sth->fetch();
            $sth->closeCursor();
            return $user;
        }

        public static function deleteUser($dbh, $login)
        {
            $query = 'DELETE FROM users WHERE login=?;';
            $sth = $dbh->prepare($query);
            $success = $sth->execute(array($login));
            // use success for debugging
            $sth->execute();
            $sth->closeCursor();
        }
    }

?>