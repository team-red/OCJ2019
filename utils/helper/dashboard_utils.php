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
      "name"=> "profil",
      "title"=> "Profile",
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
      "name" => "statistics",
      "title" => "Statistiques",
      "icon_name" => "uniE002",
      "category" => "Administrateur"
    ),
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
      "title"=> "Paramettres",
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
      <header class='logo_header'>
      <img class='logo' src='media/mathmaroc-dashboard.png' alt='logo'>
      </header>
      <main class='sidebar_main'>
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
        <a class='sidebar_page".$selected."'id='sidebar_".$valid_page["name"]."' href='dashboard.php?page=".$valid_page["name"]."'>
          <i class='icon-".$valid_page["icon_name"]." sidebar_icon'></i>
          ".$valid_page["title"]."
          <i class='icon-uniE04B sidebar_arrow'></i>
        </a>
      </li>";
      }
    }
    $html = $html."
      </ul>
    </main>
    <footer class='sidebar_help'>
    <div class='need_help'><a href='#' style='text-decoration: none; color:unset;'><i class='icon-uni36'></i> Besoin d'aide? </a></div>
    </footer>
    </aside>";
    // printing the html code
    echo $html;
  }
  function generate_footer(){
    echo <<<flag
    <footer class="dash_footer">
    Copyright © 2018. All rights reserved
    </footer>
flag;
  }
  
  //---------- Quiz ------------
  function generate_quiz(){
    for($i=1 ; $i<10 ;$i++){
    echo <<<flag
    <a href="#" class="row quiz">
      <div class="col-md-2 head">Q
flag;
    echo $i;
    echo <<<flag
      </div>
      <div class="col-md-9 body">Questionnaire sur les combinaisons et le triangle de pascal à faire avant 12 decembre 2018</div>
      <div class="col-md-1 options"><i class="icon-uniE049"></i></br><i class="icon-uniE00B"></i></br><i class="icon-uniE013"></i></div>
    </a>
flag;
  }
  }
  
  //---------- Home page ----------
  function generate_mini_profile($user){
    // setting the photo source. We check if the image exists otherwise we use a default picture.
    // All profile photos should be named login.jpg where login is the login of the user (login because it's unique)
    // Two problems, one is what if the user uploads a .png or any other type. We could either rename it to .jpg without
    // actually converting it. Or we could convert it and rename it. (this second method is more RAS but it's probably annoying to implement)
    // Using the login may seem unelegant, but it's either that or rename uploaded files with random names and verify
    // that the randomely chosen name wasn't used before. Uniqueness is necessary if we put all image files in the same directory.
    // If we don't and say put all the user data in a folder called "ayoub" then we need to add a field in the database
    // indicating the name of the last profile photo the user uploaded. Again, a pain!
    $default = "media/profile/default.jpg";
    $filename = preg_replace('((^\.)|\/|(\.$))', '_', $user->login); // escaping dots and backslashes because they have a special meaning in paths
    $src = "media/profile/" . $filename . ".jpg";
    $photo_src = file_exists($src) ? $src : $default;

    $full_name = htmlspecialchars($user->name) . " " . htmlspecialchars($user->surname);
    $class = htmlspecialchars($user->grade);
    $school = htmlspecialchars($user->school);
    $email= htmlspecialchars($user->email);
    $address = htmlspecialchars($user->address);
    $account_status = User::$roles[$user->role];

    $tz = new DateTimeZone('Europe/Paris');
    $age = DateTime::createFromFormat('Y-m-d', $user->birthday, $tz)
     ->diff(new DateTime('now', $tz))
     ->y;
  
    // A refaire en utilisant des vignettes!?
    echo<<<flag
    <div class="left">
    <div class="info">
    <img src="$photo_src" alt="Photo de profil" id="home_page_profil_photo"/>
    <h1 id="home_page_name">$full_name</h1>
    <span id="home_page_description">$account_status</span>
    <hr></hr>
    <span id="home_page_class" class="home_page_info"><b>Classe</b><br>$class</span>
    <span id="home_page_school" class="home_page_info"><b>Ecole</b><br>$school</span>
    <hr></hr>
    <span id="home_page_email" class="home_page_info"><b>Email</b><br>$email</span>
    <span id="home_page_age" class="home_page_info"><b>Age</b><br>$age</span>
    <span id="home_page_adress" class="home_page_info"><b>Adresse Postale</b><br>$address</span>
  
    </div>
    <a href="./dashboard.php?page=profil" id="home_page_see_more">Voir le profil complet ></a>
    </div>
flag;
  }
  function home_page_generate_right(){
    $min_chat = "";
    for($i = 0 ; $i < 15; $i++){
        $min_chat = $min_chat . "<tr>
        <th scope='row'>$i</th>
        <td>test</td>
        <td>test_objet</td>
        <td>$i:00</td>
      </tr>";
    }
  
    echo<<<flag
    <div class="row">
    <span class="col-md-4 chart_container">
    <canvas id="chart_done" class="home_page_chart home_page_chart"></canvas>
    <span class="home_page_chart_description">Historique des questionnaires faits</span>
    </span>
    <span class="col-md-4 chart_container">
    <canvas id="chart_success" class="home_page_chart"></canvas>
    <span class="home_page_chart_description">Taux de réussite des questionnaires</span>
    </span>
    <span class="col-md-4 chart_container">
    <canvas id="chart_marks" class=" home_page_chart"></canvas>
    <span class="home_page_chart_description">Note globale</span>
    </span>
    </div>
  
    <hr></hr>
  
    <div class="row">
    <div>
    <header>
    <h>Inbox</h>
    </header>
    <main>
  
  
    <table class="table">
      <thead class="thead-dark">
        <tr>
          <th scope="col">#</th>
          <th scope="col">De</th>
          <th scope="col">Objet</th>
          <th scope="col">Date</th>
        </tr>
      </thead>
      <tbody>
        $min_chat
      </tbody>
    </table>
  
  
  
    </main>
    </div>
    </div>
  
flag;
  }

  function showQcms($qcms)
  {
    echo <<<flag
    <main class="quiz_main container-fluid">
    <h1>Liste des questionnaires disponibles :</h1>
flag;
    foreach ($qcms as $key => $qcm) {
        $key++;
        $title = htmlspecialchars($qcm->title);
        $time = htmlspecialchars((new DateTime($qcm->start_time, new DateTimeZone('Europe/Paris')))->format("d-m-Y"));
        echo <<<flag
        
        <a href="dashboard.php?page=quiz&qcm_id=$qcm->id" class="row quiz">
          <div class="col-md-2 head">Q{$key}</div>
            <div class="col-md-9 body">
              $title
              <br>
              Mis en ligne le $time
            </div>
          <div class="col-md-1 options"><i class="icon-uniE049"></i></br><i class="icon-uniE00B"></i></br><i class="icon-uniE013"></i></div>
        </a>
flag;
    }
    echo <<<flag
    </main>
flag;
  }
?>