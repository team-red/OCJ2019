<?php
require_once("utils/profile/user.php");
require_once("utils/database.php");
require_once("utils/profile/user_data.php");

function myinfo_generate_pdp_pdp($user){
  $profilPhoto = htmlspecialchars(User::getPhotoSource($user->login));
  echo<<<flag
  <img src="$profilPhoto" alt="Photo de profil" id="myinfo_profil_photo"/>
flag;
}

function myinfo_generate_pdp_info($user){
  $first_name = htmlspecialchars($user->surname);
  $last_name = htmlspecialchars($user->name);
  $school = htmlspecialchars($user->school);
  $school = $school === "" ? "Non renseigné" : $school;
  $accountStatus = htmlspecialchars(User::$roles[$user->role]);

  echo<<<flag
  <h1>$last_name $first_name</h1>
  <h5>$school</h5>
  <span>$accountStatus</span>

flag;
}
function myinfo_generate_options(){
  $dbh = Database::connect();
  $query = "SELECT email FROM users WHERE role='admin';";
  $sth = $dbh->prepare($query);
  $sth->execute(array());
  $adminEmail = $sth->fetch()[0];
  $sth->closeCursor();
  $dbh = null;
  echo "<span class='myinfo_options'><a href='#' OnClick='javascript:window.print()'><i class='icon-uni7D'></i></a><a href='dashboard.php?page=settings'><i class='icon-uni2E'></i></a><a href='#' onclick=".'"contact('."'$adminEmail'".')"'." ><i class='icon-uni36'></i></a></span> ";
}

function myinfo_generate_personal_academic($user){
  $academy = "Non renseigné";
  $school = htmlspecialchars($user->school);
  $school = $school === "" ? "Non renseigné" : $school;
  $class = htmlspecialchars($user->grade);
  $class = $class === "" ? "Non renseigné" : $class;

  echo<<<flag
  <br><br><br>
  <span class="row"><span class="col-md-3"><b>Ecole :</b></span><span class="col-md-9">$school</span></span><br>
  <span class="row"><span class="col-md-3"><b>Academie :</b></span><span class="col-md-9">$academy</span></span><br>
  <span class="row"><span class="col-md-3"><b>Classe :</b></span><span class="col-md-9">$class</span></span><br>
  <br>
flag;
}

function myinfo_generate_personal_postal($user){
  $email = htmlspecialchars($user->email);
  $phone = "Non renseigné";
  $adress = htmlspecialchars($user->address);
  $adress = ($adress !== "") ? $adress : "Non renseigné";

  echo<<<flag
  <br>
  <span class="row"><span class="col-md-3"><b>Email :</b></span><span class="col-md-9">$email</span></span><br>
  <span class="row"><span class="col-md-3"><b>Telephone :</b></span><span class="col-md-9">$phone</span></span><br>
  <span class="row"><span class="col-md-3"><b>Adresse Postale :</b></span><span class="col-md-9">$adress</span></span><br>
  <br>
flag;
}

function myinfo_generate_personal_personal($user){
  $gender = "Non renseigné";
  $birthday = htmlspecialchars($user->birthday);
  $description = "Non renseigné";

  echo<<<flag
  <br>
  <span class="row"><span class="col-md-3"><b>Gendre :</b></span><span class="col-md-9">$gender</span></span><br>
  <span class="row"><span class="col-md-3"><b>Date de naissance :</b></span><span class="col-md-9">$birthday</span></span><br>
  <span class="row"><span class="col-md-3"><b>Signature :</b></span><span class="col-md-9">$description</span></span><br>
  <br>
flag;
}

function myinfo_generate_rank_tab(){

  $dbh = Database::connect();
  $result = UserData::getAllScoresAndRanks($dbh);
  $dbh = null; //todo

  $rankData = "";
  $i=1;
  foreach ($result as $userData) {
    $sendToEmail = $userData[1]->email; //todo
    $fullName = $userData[1]->surname . " " . $userData[1]->name;

    $rankData = $rankData . "  <tr>
      <td class=' table_cell_rank_content'>
      ".($i++)."
      </td>
      <td class=' table_cell_rank_content'>
      $fullName
      </td>
      <td class=' table_cell_rank_content table_cell_rank_content_contact' onclick=".'"contact('."'$sendToEmail'".')"'." >
      <span class='icon-uni3E table_cell_rank_contact'></span>
      </td>
      </tr>";
  }

  $champion = (sizeof($result) > 0) ? $result[0][1]->surname ." ". $result[0][1]->name : "NA";
  $rank2 = (sizeof($result) > 1) ? $result[1][1]->surname ." ". $result[1][1]->name : "NA";
  $rank3 = (sizeof($result) > 2) ? $result[2][1]->surname ." ". $result[2][1]->name : "NA";

    echo<<<flag
    <div class="row" id="myinfo_champions">
      <div class="col-md-4 myinfo_champions_cell">
      <img src="media/rank2.png" alt="classment 2" id="myinfo_rank2_photo"/>
      <span>$rank2</span>
      </div>
      <div class="col-md-4 myinfo_champions_cell_first">
      <img src="media/rank1.png" alt="classement 1" id="myinfo_rank1_photo"/>
      <span>$champion</span>
      </div>
      <div class="col-md-4 myinfo_champions_cell">
      <img src="media/rank3.png" alt="classement 3" id="myinfo_rank3_photo"/>
      <span>$rank3</span>
      </div>
    </div>
    <diV class="row" id="myinfo_rank">
    <table class="table" id="table_rank">
        <thead class="thead-dark">
          <tr>
            <th scope="col" class="table_cell_rank">Classement</th>
            <th scope="col" class="table_cell_rank">Elève</th>
            <th scope="col" class="table_cell_rank">Contacter...</th>
          </tr>
        </thead>
        <tbody>
          $rankData
        </tbody>
    </table>

    </div>
flag;
}

function myinfo_generate_done_tab(){


  $dbh = Database::connect();
  $result = UserData::getAllQuizes($dbh, User::fromEmail($dbh, $_SESSION["email"]));

  $quizData = "";
  $showQuizes = "";
  $numQuizes = 15;
  $i = 1;
  foreach ($result as $qcmData) {
    $scores = UserData::getScores($dbh, $qcmData[1]->id ,User::fromEmail($dbh, $_SESSION["email"]));
    $qcm_score = 0;
    foreach ($scores as $score) {
        $qcm_score += $score["score"];
    }
    $quizData = $quizData . "  <tr onclick='showQuiz(".$i.")'>
      <td class=' table_cell_quiz_content'>
      ".$i."
      </td>
      <td class=' table_cell_quiz_content'>
      {$qcmData[1]->title}
      </td>
      <td class=' table_cell_quiz_content'>
      {$qcm_score}
      </td>
      </tr>";
    $showQuizes = $showQuizes . "
    <div id='quiz_".($i++)."'>
      {$qcmData[0]}
    <span class='back_quiz' onclick='unShowQuiz()'> <span class='back_button'>Revenir en arriere</span></span>
    </div>
    ";
  }

  echo<<<flag
  <span>Liste des questionnaires que vous avez déjà fait:</span>
  <table class="table" id="table_quiz">
      <thead class="thead-dark">
        <tr>
          <th scope="col" class="table_cell_quiz">#</th>
          <th scope="col" class="table_cell_quiz">Titre du questionnaire</th>
          <th scope="col" class="table_cell_quiz">Note obtenue</th>
        </tr>
      </thead>
      <tbody>
        $quizData
      </tbody>
  </table>
  $showQuizes
flag;

$dbh = null; //todo

}

?>
