<!--
Breifing sur l'utilisateur : avatar, nom, prenom, ecole (non renseignée sinon), nombre de qcms faits, note moyenne,
nombre de qcms restants, dernieres activités...

upcomming qcms
new qcms ouverts

 -->


<?php
  require_once("utils/profile/user.php");
  if (isset($_SESSION["email"])){
    $user = User::fromEmail($dbh, $_SESSION["email"]);
  } else {
    // _SESSION information corrupted
    // logging out
    session_unset();
    session_destroy();
    header("location: index.php");
    exit();
  }
?>

<main class="home_page_main container-fluid">

  <div class="home_page_main_row row">
    <aside class="home_page_left col-md-4">
      <?php home_page_generate_left($user); ?>
    </aside>

    <aside class="home_page_right col-md-8">
      <?php home_page_generate_right(array(
        "champion" => "FOUSSOUL Ayoub",
        "myRank" => 22,
        "afterMe" => "SLIMANI Adam",
        "lastRank" => 203,
        "lastOne" => "BOUTIHAL Achraf",
        "done" => 12,
        "numOfQuizes" => 19,
        "success" => 13,
        "mark" => 15,
        )); ?>
    </aside>
  </div>

</main>
<?php generate_footer(); ?>
