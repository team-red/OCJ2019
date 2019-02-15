<?php

require_once("utils/helper/chat_utils.php");

?>

<div class="chat_main container-fluid">
  <h2>Messagerie</h2>
  <header id="chat_mobile">
    <span class="chat_link msg_from_admin" onclick="getSeeMore(1)">Important</span>
    <span  class="chat_link msg_in" onclick="getSeeMore(2)">Recu</span>
    <span class="chat_link msg_out" onclick="getSeeMore(3)">Envoyé</span>
    <span class="chat_link msg_new" onclick="writeMsg()">Nouveau</span>
  </header>

  <div id="chat_main_main">
    <div id="chat_largescreen">
      <span class="chat_link msg_from_admin" onclick="getSeeMore(1)">Important</span>
      <span  class="chat_link msg_in" onclick="getSeeMore(2)">Recu</span>
      <span class="chat_link msg_out" onclick="getSeeMore(3)">Envoyé</span>
      <span class="chat_link msg_new" onclick="writeMsg()">Nouveau</span>
    </div>
    <div id="chat_seemore_container">
      <div id="chat_seemore">
      </div>
    </div>

    <div id="chat_body_container">
    <div id="chat_body">

      <?php
      if(isset($_POST["check"])){
        require_once("utils/database.php");
        $dbh = Database::connect();
        $user_email = $_SESSION["email"]; // get this from the session ...
        $date = date('Y-m-d H:i:s');

        $query = "SELECT role FROM users WHERE email=?;";
        $sth = $dbh->prepare($query);
        $sth->execute(array($user_email));
        $role = $sth->fetch()[0];
        $sth->closeCursor();

        $query = "INSERT INTO chat (from_id, to_id, tag, title, core, date) VALUES (?, ?, ?, ?, ?, ?)";
        $sth = $dbh->prepare($query);
        try {
          $sth->execute(array($user_email, htmlspecialchars($_POST["to"]), ($role === "admin")? 1: 0, htmlspecialchars($_POST["title"]), htmlspecialchars($_POST["core"]), $date));
          echo<<<flag
          <br>
          <h3>Message Envoyé</h3>
          <a href='#' onclick='writeMsg()'>Cliquez ici pour revenir à la page precedente</a>
          <style>#chat_seemore_container{display: none;} #chat_body_container{width : 75%;}</style>
flag;
        } catch(PDOException $e) {
          echo "<br>Une erreure est survenue lors de l'ajout du message! Verifiez bien que l'utilisateur auquel vous envoyez le message est bien enregistré sur le site";
          echo "<br><a href='#' onclick='writeMsg()' >Cliquez ici pour revenir à la page precedente</a>";
          echo "<style>#chat_seemore_container{display: none;} #chat_body_container{width : 75%;}</style>";
        }
        $sth->closeCursor();
      }else{
        if(isset($_GET['sendTo']))
          echo "<script> default_chat("."'".$_GET['sendTo']."'"."); </script>";
        else {
          echo "<script> default_chat("."null"."); </script>";
        }
      }
      ?>
    </div>
  </div>
</div>
</div>
