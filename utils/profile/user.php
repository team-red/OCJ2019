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
            $filename = preg_replace('((^\.)|\/|(\.$))', '_', $login);
            // escaping dots and backslashes because they have a special meaning in paths
            $src = "media/profile/" . $filename . ".jpg";
            if (file_exists($src)){
                $success = unlink($src); // delete his profile photo if it exists
            }
        }

        public static function modifyData($dbh, $login, $data)
        {
            $passChangedAttemp = false;
            if($data["pwd"] === $data["pwd_conf"]){
              if($data["pwd"] !== ""){
                $query = "UPDATE users SET surname=?, name=?, pwd=?, school=?, city=?, address=?, grade=?, birthday=? WHERE login=?;";
                $sth = $dbh->prepare($query);
                $success = $sth->execute(array(
                    $data["surname"], $data["name"], password_hash($data["pwd"], PASSWORD_DEFAULT), $data["school"], $data["city"], $data["address"], $data["grade"], $data["birthday"], $login
                ));
                if($sth->rowCount() === 0) {
                  echo password_hash($data["old_pwd"], PASSWORD_DEFAULT);
                  $passChangedAttemp =true;
                }
              }else{
                $query = "UPDATE users SET surname=?, name=?, school=?, city=?, address=?, grade=?, birthday=? WHERE login=?";
                $sth = $dbh->prepare($query);
                $success = $sth->execute(array(
                    $data["surname"], $data["name"],$data["school"], $data["city"], $data["address"], $data["grade"], $data["birthday"], $login
                ));
          }
            $sth->closeCursor();

          }

          if($passChangedAttemp){
              echo "Erreur! verifiez votre ancien mot de passe et que les deux mots de passes sont bien identiques";
            }

        }

        public static function getPhotoSource($login)
        {
            $filename = preg_replace('((^\.)|\/|(\.$))', '_', $login);
            // escaping dots and backslashes because they have a special meaning in paths
            $src = "media/profile/" . $filename . ".jpg";
            return file_exists($src) ? $src : "media/default.jpg";
        }

        public static function setPhotoSource($login, $file)
        {
            $filename = preg_replace('((^\.)|\/|(\.$))', '_', $login);
            // escaping dots and backslashes because they have a special meaning in paths
            $src = "media/profile/" . $filename . ".jpg";

            $target_file = basename($file["name"]);
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

            if (getimagesize($file["tmp_name"]) === false){
                return false;
            }
            if ($file["size"] > 500000) {
                return false;
            }
            if ($imageFileType !== "jpg"){
                return false;
            }

            if (move_uploaded_file($file["tmp_name"], $src) === false) {
                return false;
            }

        }
    }

?>
