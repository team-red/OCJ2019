<?php

// When adding new page add it with its category.

$pages = array(
    // Main menu
    array(
      "name"=> "home_page",
      "title"=> "Acceuil",
      "icon_name" => "uni5A",
      "category" => "Menu principal"
    ),
    array(
      "name"=> "myinfo",
      "title"=> "Mes infos",
      "icon_name" => "uniE011",
      "category" => "Menu principal"
    ),
    array(
      "name"=> "quiz",
      "title"=> "Questionnaires",
      "icon_name" => "uniE049",
      "category" => "Menu principal"
    ),
    array(
      "name"=> "chat",
      "title"=> "Messagerie",
      "icon_name" => "uni2D",
      "category" => "Menu principal"
    ),
    // Admin
    array(
      "name" => "create_quiz",
      "title" => "Creer Questionnaire",
      "icon_name" => "uni2E",
      "category" => "Administrateur"
    ),
    array(
      "name" => "manage_students",
      "title" => "Gestionnaire d'éleves",
      "icon_name" => "uni50",
      "category" => "Administrateur"
    ),
    // User Account
    array(
      "name"=> "settings",
      "title"=> "Paramètres",
      "icon_name" => "uniE005",
      "category" => "Compte d'utilisateur"
    ),
    array(
      "name" => "logout",
      "title" => "Déconnexion",
      "icon_name" => "uniE003",
      "category" => "Compte d'utilisateur"
    )
);

$default_page = $pages[0];

// --------- General ------------

function is_admin_exclusive($page_name, $valid_pages)
{
  foreach ($valid_pages as $current_page) {
    if ($current_page["name"] === $page_name) {
        if ($current_page["category"] === "Administrateur")
        {
          return true;
        }
        else
        {
          return false;
        }
    }
  }
}
function generate_header_tag(){
    echo <<<flag
    <header class="app-header">
      <span style="font-size:30px;cursor:pointer" class="pointer" onclick="openNav()">  &#9776;</span>
    </header>
flag;
  }
  function generate_sidebar($active_page, $valid_pages, $admin){
    // Adding first stuff
    $html = "
    <!-- The dark window when the sidebar is open on small devices -->
    <div id='dark' onclick='closeNav()'></div>
    <!-- The actual sidebar -->
    <aside id='side-bar' class='app-aside'>
    <div class='logo_header'>
    <img class='logo' src='media/mathmaroc-dashboard.png' alt='logo'>
    </div>
    <div class='sidebar_main'>
    <ul class='sidebar_pages'>";

      $category = "";
    foreach ($valid_pages as $valid_page){
      // Adding category if a new one is selected in the loop and skiping General
      if($valid_page["category"] !== "Administrateur" || ($valid_page["category"] === "Administrateur" && $admin)){
        if($valid_page["category"] !== $category){
          $category = $valid_page["category"];
          $html = $html."<li class='sidebar_category'> &nbsp; --- ".$category."</li>";
        }

      // Adding pages and verifying wheter the page is active or not (if so adding it to the class sidebar_page_selected)
      $selected = ($valid_page["name"] === $active_page) ? " sidebar_page_selected" : "";

      $html = $html."
      <li>
        <a class='sidebar_page".$selected."' id='sidebar_".$valid_page["name"]."' href='dashboard.php?page=".$valid_page["name"]."'>
          <i class='icon-".$valid_page["icon_name"]." sidebar_icon'></i>
          ".$valid_page["title"]."
          <i class='icon-uniE04B sidebar_arrow'></i>
        </a>
      </li>";
      }
    }

    require_once("utils/database.php");
    $dbh = Database::connect();
    $query = "SELECT email FROM users WHERE role='admin';";
    $sth = $dbh->prepare($query);
    $sth->execute(array());
    $adminEmail = $sth->fetch()[0];
    $sth->closeCursor();

    $html = $html."
      </ul>
    </div>
    <div class='sidebar_help'>
    <div class='need_help'><a href='#' style='text-decoration: none; color:unset;'  onclick=".'"contact('."'$adminEmail'".')"'." ><i class='icon-uni36'></i> Besoin d'aide? </a></div>
    </div>
    </aside>";
    // printing the html code
    echo $html;
  }
  function generate_footer(){
    echo <<<flag
    <footer class="dash_footer">
    </footer>
flag;
  }

//---------- Home page ----------
  function home_page_generate_left($user){
    //variables !!!!!!!!!! be carefull to always store name in right capitalization !!!!!!!!!!
    $profilPhoto = htmlspecialchars(User::getPhotoSource($user->login));
    $class = htmlspecialchars($user->grade);
    $class = $class === "" ? "Non renseigné" : $class;
    $school = htmlspecialchars($user->school);
    $school = $school === "" ? "Non renseigné" : $school;
    $academy = "Non renseigné"; //todo
    $last_name = htmlspecialchars($user->name);
    $first_name = htmlspecialchars($user->surname);
    $email = htmlspecialchars($user->email);
    $birthday = htmlspecialchars($user->birthday);
    $accountStatus = htmlspecialchars(User::$roles[$user->role]);

    echo<<<flag
    <div class="min_box min_box_myinfo">
    <div id="min_box_header_myinfo">
    <span><i class="icon-uniE011 sidebar_icon" style="font-weight: 900;margin-right: 10px;"></i>Infos personelles</span>
    <a href="./dashboard.php?page=myinfo" class="min_see_more">Voir plus de details ></a>
    </div>
    <div class="row min_box_main">
    <div class="col-md-12 min_col">
    <span class="min_cell min_cell_myinfo no_border">Resume</span>
    <div class="min_col_myinfo_content">
    <img src="$profilPhoto" alt="Photo de profil" id="home_page_profil_photo"/>

    <div>
    <h1 id="home_page_name">$last_name $first_name</h1>
    <span id="home_page_subject">$accountStatus</span>

    </div>
    <hr/>
    <span id="home_page_class" class="home_page_info"><b>Classe</b><br>$class</span>
    <span id="home_page_school" class="home_page_info"><b>Ecole</b><br>$school</span>
    <span id="home_page_academy" class="home_page_info"><b>Academie</b><br>$academy</span>
    <hr/>
    <span id="home_page_email" class="home_page_info"><b>Email</b><br>$email</span>
    <span id="home_page_birthday" class="home_page_info"><b>Date de naissance</b><br>$birthday</span>
    </div>
    </div>
    </div>
    </div>
flag;
}

  function home_page_generate_right(){

  require_once("utils/database.php");
  require_once("utils/profile/user_data.php");
  require_once("utils/profile/user.php");

  $dbh = Database::connect();
  $result = UserData::getAllScoresAndRanks($dbh);

  // things to get from SQL


  $champion = (sizeof($result) > 0) ? $result[0][1]->surname ." ". $result[0][1]->name : "NA";
  $myRank = -1;
  $afterMe = "NA";
  $onMe = false;
  foreach ($result as $preRank => $user) {
    if($onMe){
      $afterMe = $user[1]->surname ." ". $user[1]->name;
      break;
    }
    else{
      if($user[1]->email === $_SESSION["email"]){
        $myRank = $preRank + 1;
        $onMe =true;
      }
    }
  }

  $user = User::fromEmail($dbh, $_SESSION["email"]);
  $myRankPlusOne = $myRank+1;
  $lastRank = sizeof($result);
  $lastOne = end($result)[1]->surname . " " . end($result)[1]->name;
  $done = UserData::numberOfQcmsTried($dbh, $user);
  $numOfQuizes = UserData::numberOfQcms($dbh);
  $success = UserData::numberOfQcmsSucceded($dbh, $user);
  $mark = UserData::scoreOutOfTwenty($dbh, $user);


  // getting stuff from db

  $user_email = $_SESSION["email"]; // get this from the session ...
  $query = "SELECT id, from_id, title, date FROM chat WHERE to_id=?;";
  $sth = $dbh->prepare($query);
  $sth->execute(array($user_email));
  $result = array();
  while ($msg = $sth->fetch()) {
    array_push($result, $msg);
  }
  $sth->closeCursor();
  $messagesTable = $result;
  // end stuff getting

  $minChat = "";
  $max = 5;
  foreach ($messagesTable as $key => $message){
      if($key === $max){break;}
      $order = $key+1;
      $from = $message["from_id"];
      $description = $message["title"];
      $date = $message["date"];
      $minChat = $minChat . "<tr>
      <th scope='row' class='min_chat_num'>$order</th>
      <td class='min_chat_from'>$from</td>
      <td class='min_chat_subject min_chat_hide'>$description</td>
      <td class='min_chat_date'>$date</td>
    </tr>";
  }
  if($minChat == ""){
    $minChat = "
    <tr>
      <th scope='row'></th>
      <td></td>
      <td style='text-align: center; vertical-align: middle;'>Pas de messages pour le moment</td>
      <td></td>
    </tr>
    ";
  }

  $quizStats = "
  <table class='table table_min'>
      <thead class='thead-dark'>
        <tr>
          <th scope='col' class='no_border min_table_cell_quiz'>Classement</th>
          <th scope='col' class='no_border min_table_cell_quiz'>Elève</th>
        </tr>
      </thead>
      <tbody>";


if($myRank === 1){
  $quizStats = $quizStats . "<tr>
       <th scope='row' class='no_border'>1</th>
       <td class='no_border' id='min_table_cell_your_rank'>Vous</td>
     </tr><tr>
       <th scope='row' class='no_border'>2</th>
       <td class='no_border'>$afterMe</td>
     </tr><tr>
       <th scope='row' class='no_border'>...</th>
       <td class='no_border'>...</td>
     </tr><tr>
       <th scope='row' class='no_border'>...</th>
       <td class='no_border'>...</td>
     </tr>
     <tr>
       <th scope='row' class='no_border'>$lastRank</th>
       <td class='no_border'>$lastOne</td>
     </tr></tbody>
 </table>";
}
elseif ($myRank === 2) {
  $quizStats = $quizStats . "<tr>
       <th scope='row' class='no_border'>1</th>
       <td class='no_border'>$champion</td>
     </tr><tr>
       <th scope='row' class='no_border'>2</th>
       <td class='no_border' id='min_table_cell_your_rank'>Vous</td>
     </tr><tr>
       <th scope='row' class='no_border'>3</th>
       <td class='no_border'>$afterMe</td>
     </tr><tr>
       <th scope='row' class='no_border'>...</th>
       <td class='no_border'>...</td>
     </tr>
     <tr>
       <th scope='row' class='no_border'>$lastRank</th>
       <td class='no_border'>$lastOne</td>
     </tr></tbody>
  </table>";
}
else{
   $quizStats = $quizStats . "<tr>
        <th scope='row' class='no_border'>1</th>
        <td class='no_border'>$champion</td>
      </tr><tr>
        <th scope='row' class='no_border'>...</th>
        <td class='no_border'>...</td>
      </tr><tr>
        <th scope='row' class='no_border'>$myRank</th>
        <td class='no_border' id='min_table_cell_your_rank'>Vous</td>
      </tr><tr>
        <th scope='row' class='no_border'>$myRankPlusOne</th>
        <td class='no_border'>$afterMe</td>
      </tr>
      <tr>
        <th scope='row' class='no_border'>...</th>
        <td class='no_border'>...</td>
      </tr></tbody>
  </table>";
}

echo<<<flag
<div class="min_box min_box_quiz">
<div id="min_box_header_quiz">
<span><i class="icon-uniE049 sidebar_icon" style="font-weight: 900;margin-right: 10px;"></i>Infos questionnaires</span>
<a class="min_see_more" href="dashboard.php?page=quiz">Aller sur la partie questionnaires > </a>
</div>
<div class="row min_box_main">

<div class="col-md-6 min_col">
  $quizStats
</div>
<div class="col-md-6 min_col">
<table class="table table_min" id="table_min_stat">
    <thead class="thead-dark">
      <tr>
        <th scope="col" class="no_border min_table_cell_quiz">Fait</th>
        <th scope="col" class="no_border min_table_cell_quiz">Reussit</th>
        <th scope="col" class="no_border min_table_cell_quiz">Note</th>
      </tr>
    </thead>
    <tbody>
      <tr>
      <td class="no_border min_table_cell_quiz_content">
      <span class="min_col_stat_content_main">$done<span class="min_col_stat_content_sub">/$numOfQuizes</span></span>
      </td>
      <td class="no_border min_table_cell_quiz_content">
      <span class="min_col_stat_content_main">$success<span class="min_col_stat_content_sub">/$numOfQuizes</span></span>
      </td>
      <td class="no_border min_table_cell_quiz_content">
      <span class="min_col_stat_content_main">$mark<span class="min_col_stat_content_sub">/20</span></span>
      </td>
      </tr>
    </tbody>
</table>
</div>

</div>
</div>

<div class="min_box min_box_chat">
<div id="min_box_header_messages">
<span><i class="icon-uni2D sidebar_icon" style="font-weight: 900;margin-right: 10px;"></i>mes messages</span>
<a href='dashboard.php?page=chat' class="min_see_more">Voir plus de details ></a>
</div>
<div class="row min_box_main">
<div class="col-md-12 min_col">
<table class="table table_chat table_min">
  <thead class="thead-dark">
    <tr>
      <th scope="col" class="no_border min_table_cell_chat min_chat_num">#</th>
      <th scope="col" class="no_border min_table_cell_chat min_chat_from">De</th>
      <th scope="col" class="no_border min_table_cell_chat min_chat_subject min_chat_hide">Objet</th>
      <th scope="col" class="no_border min_table_cell_chat min_chat_date">Date</th>
    </tr>
  </thead>
  <tbody>
    $minChat
  </tbody>
</table>
</div>
</div>
</div>

flag;

$dbh = null; //todo

}

function showQcms($qcms, $user)
  {
    echo <<<flag
    <div class="quiz_main container-fluid">
    <h1>Liste des questionnaires disponibles:</h1>
    <span style="color:red; margin-bottom:4rem; display:block;">Faites bien attention! une fois un questionnaire commencé il y aura plus la possibilité de le refaire!</span>

flag;

$isAdmin = ($user->role !== "admin") ? "none" : "block";

    foreach ($qcms as $key => $qcm) {
        $key++;
        $title = htmlspecialchars($qcm->title);
        $duration = htmlspecialchars(intval($qcm->duration_seconds / 60)) . " min";
        $time = htmlspecialchars((new DateTime($qcm->start_time, new DateTimeZone('Europe/Paris')))->format("d-m-Y"));
        echo <<<flag

        <div class="row quiz">
        <a href="dashboard.php?page=quiz&qcm_id=$qcm->id" class="col-md-11" onclick="return confirm('Êtes-vous sûrs de vouloir commencer ce questionnaire?');">
        <div class="row">
          <div class="col-md-2 head"><span style="">Q{$key}</span></div>
            <div class="col-md-10 body">
              <span class="quiz_title">$title</span>
              <br>
              <br>
              Durée : $duration
              <br>
              Mis en ligne le $time
            </div>
          </div>
        </a>
        <a class="col-md-1 options" style="display: $isAdmin; font-size: large;" onclick="return confirm('Êtes-vous sûrs?');" href="dashboard.php?page=quiz&qcm_del=$qcm->id"><i class="icon-uniE01C"></i></a>
        </div>
flag;
    }
    echo <<<flag
    </div>
flag;
  }
?>
