<!--
Questionnaires fait et pas faits
-->

<!DOCTYPE html>
<html lang="fr-FR">
<?php
require_once("utils/helper.php");
require_once("utils/database.php");
generate_header($page, "css/dashboard.css", $dashboard_pages);
?>

<header class="questionnaires_header">

</header>

<!-- think of a generate content php function -->
<main class="questionnaires_main container-fluid">

  <?php generate_questionnaires(); ?>

</main>

<?php generate_dashboard_footer(); ?>

<script src="js/popper.min.js"></script>
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/dashboard.js"></script>
</html>
