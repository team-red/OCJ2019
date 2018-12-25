<!--
Breifing sur l'utilisateur : avatar, nom, prenom, ecole (non renseignée sinon), nombre de qcms faits, note moyenne,
nombre de qcms restants, dernieres activités...


 -->

<!DOCTYPE html>
<html lang="fr-FR">
<?php generate_header($page, "css/dashboard.css", $dashboard_pages); ?>

<header class="main_header">
</header>
<main class="main_main container-fluid">
  <div class="row hello">
    <div class="col-md-12">
      Hi Name! </br>
      Here is your account status :
    </div>
  </div>
  <div class="row stats">
    <div class="col-md-4 done"></div>
    <div class="col-md-4 mark"></div>
    <div class="col-md-4 left"></div>
  </div>

</main>

<?php generate_dashboard_footer(); ?>

<script src="js/popper.min.js"></script>
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/dashboard.js"></script>
</html>
