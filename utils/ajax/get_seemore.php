<?php
if (isset($_POST["type"])) {
  if(isset($_POST["min"])){
    require_once("utils/database.php");
    require_once("utils/helper.php");
  }else{
    require_once("../database.php");
    require_once("../helper.php");
  }
    $dbh = Database::connect();
    $user_email = "ayoubfoussoul@gmail.com"; // get this from the session ...
    switch ($_POST["type"]) {
      case 1: // important
        $query = "SELECT id, from_id, title, date FROM chat WHERE to_id=? AND tag=1;";
        $sth = $dbh->prepare($query);
        $sth->execute(array($user_email));
        $result = array();
        while ($msg = $sth->fetch()) {
          array_push($result, $msg);
        }
        $sth->closeCursor();
        if(isset($_POST["min"])){
          $messagesTable = $result;
        }else{
        chat_generate_seemore($result, 1);
        }
        break;
      case 2: //in
        $query = "SELECT id, from_id, title, date FROM chat WHERE to_id=?;";
        $sth = $dbh->prepare($query);
        $sth->execute(array($user_email));
        $result = array();
        while ($msg = $sth->fetch()) {
          array_push($result, $msg);
        }
        $sth->closeCursor();
        chat_generate_seemore($result, 2);
        break;
      case 3: // out
        $query = "SELECT id, to_id, title, date FROM chat WHERE from_id=?;";
        $sth = $dbh->prepare($query);
        $sth->execute(array($user_email));
        $result = array();
        while ($msg = $sth->fetch()) {
          array_push($result, $msg);
        }
        $sth->closeCursor();
        chat_generate_seemore($result, 3);
        break;
    }
} else {
    throw new Exception("Invalid POST params.");
}
$dbh = null;
