<!--
Questionnaires fait et pas faits
-->

<header class="quiz_header">
</header>

<!-- think of a generate content php function -->
<main class="quiz_main container-fluid">
  <h1>Liste des questionnaires disponibles :</h1>

  <?php

    require_once("utils/quiz/qcm.php");

    $qcms = Qcm::getAll($dbh);

    foreach ($qcms as $key => $qcm) {
      $key++;
      echo <<<flag
      <a href="#" class="row quiz">
        <div class="col-md-2 head">Q$key</div>
        <div class="col-md-9 body">
          {$qcm->title}
          <br>
          faire avant le {$qcm->start_time}
        </div>
        <div class="col-md-1 options"><i class="icon-uniE049"></i></br><i class="icon-uniE00B"></i></br><i class="icon-uniE013"></i></div>
      </a>
flag;
    }


  ?>

  <?php //generate_quiz(); ?>

</main>

<?php generate_dashboard_footer(); ?>
