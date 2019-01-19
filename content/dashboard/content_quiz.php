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
    generate_qcms($qcms);    
  ?>

</main>

<?php generate_footer(); ?>
