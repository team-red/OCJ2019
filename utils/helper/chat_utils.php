<?php

function chat_generate_seemore($messagesTable, $type){

    foreach ($messagesTable as $message){
      $id = $message["id"];
      $description = $message["title"];
      $from_to = (intval($type) === 3) ? "À: " . $message["to_id"] : "De: " . $message["from_id"];
      $date = $message["date"];
      echo<<<flag
    <span class="msg_min" id="msg_$id" onclick="getMessage($id, $type)">
      <span class="msg_min_title">$from_to</span>
      <span class="msg_min_date">$date</span>
      <span class="msg_min_subject">$description</span>
    </span>
flag;
  }
}

function chat_generate_body($message, $type){
  $description = $message["title"];
  $from_to = (intval($type) === 3) ? "<b>À: </b>" . $message["to_id"] : "<b>De: </b>" . $message["from_id"];
  $core = $message["core"];
  $date = $message["date"];
  echo<<<flag
  <br>
  <span class="msg_body_title">$from_to</span>
  <span class="msg_min_date">$date</span>
  <span class="msg_body_subject"><b>Objet :</b> $description</span>
  <span class="msg_body_core"><b>Message : </b><br>$core</span>
flag;
}

?>
