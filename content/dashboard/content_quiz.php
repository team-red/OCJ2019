<!--
Questionnaires fait et pas faits
-->

<header class="quiz_header"></header>


<?php
  require_once("utils/quiz/quiz.php");
  if (isset($_GET["qcm_id"])){
    $qcm_id = $_GET["qcm_id"];
    if ($user->hasAccess($dbh, $qcm_id)){
      Quiz::createForm($dbh, $qcm_id);
    } else {
      echo "Too bad for you, you already tried (or some other excuse if we change the db)";
    }
  } else {
    require_once("utils/quiz/qcm.php"); // included in quiz.php?
    $qcms = Qcm::getAll($dbh);
    showQcms($qcms);
  }
?>

<?php generate_footer(); ?>
