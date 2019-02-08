<?php
require_once("utils/profile/user.php");

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
  <h>$accountStatus</h>

flag;
}
function myinfo_generate_options(){
  echo "<span class='myinfo_options'><a href='#' OnClick='javascript:window.print()'><i class='icon-uni7D'></i></a><a href='dashboard.php?page=settings'><i class='icon-uni2E'></i></a><a href='#'><i class='icon-uni36'></i></a></span> ";
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
  $adress = $adress === "" ? $adress : "Non renseigné";

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

function myinfo_generate_rank_tab($quizInfo){
  $rankData = "";

  for($i=0; $i < 10; $i++){
    $rankData = $rankData . "  <tr>
      <td class=' table_cell_rank_content'>
      ".($i+1)."
      </td>
      <td class=' table_cell_rank_content'>
      test
      </td>
      <td class=' table_cell_rank_content'>
      test_test
      </td>
      </tr>";
  }

    echo<<<flag
    <div class="row" id="myinfo_champions">
      <div class="col-md-4 myinfo_champions_cell">
      <img src="media/rank2.png" alt="classment 2" id="myinfo_rank2_photo"/>
      <h>BELOUAFI Kamal</h>
      </div>
      <div class="col-md-4 myinfo_champions_cell_first">
      <img src="media/rank1.png" alt="classement 1" id="myinfo_rank1_photo"/>
      <h>FOUSSOUL Ayoub</h>
      </div>
      <div class="col-md-4 myinfo_champions_cell">
      <img src="media/rank3.png" alt="classement 3" id="myinfo_rank3_photo"/>
      <h>ZHIRO Salma</h>
      </div>
    </div>
    <diV class="row" id="myinfo_rank">
    <table class="table" id="table_rank">
        <thead class="thead-dark">
          <tr>
            <th scope="col" class="table_cell_rank">Classement</th>
            <th scope="col" class="table_cell_rank">Nom de l'éleve</th>
            <th scope="col" class="table_cell_rank">De</th>
          </tr>
        </thead>
        <tbody>
          $rankData
        </tbody>
    </table>

    </div>
flag;
}

function myinfo_generate_done_tab($quizInfo){
  $quizData = "";
  $showQuizes = "";
  $numQuizes = 10;

  for($i=0; $i < $numQuizes; $i++){
    $quizData = $quizData . "  <tr onclick='showQuiz(".($i+1).")'>
      <td class=' table_cell_quiz_content'>
      ".($i+1)."
      </td>
      <td class=' table_cell_quiz_content'>
      test
      </td>
      <td class=' table_cell_quiz_content'>
      15
      </td>
      </tr>";
    $showQuizes = $showQuizes . "
    <div id='quiz_".($i+1)."'>
    Quiz ".($i+1)."!
    <br>
    <span style='cursor:pointer' onclick='unShowQuiz($numQuizes)'>< Revenir en arriere</span>
    </div>
    ";
  }

  echo<<<flag
  <h>Liste des questionnaires que j'ai deja fait :</h>
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
}

?>