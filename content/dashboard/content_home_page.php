<!--
Breifing sur l'utilisateur : avatar, nom, prenom, ecole (non renseignée sinon), nombre de qcms faits, note moyenne,
nombre de qcms restants, dernieres activités...

upcomming qcms
new qcms ouverts

 -->

<main class="home_page_main container-fluid">

  <div class="home_page_main_row row">
    <aside class="home_page_left col-md-4">
      <?php home_page_generate_left(); ?>
    </aside>

    <aside class="home_page_right col-md-8">
      <?php home_page_generate_right(); ?>
    </aside>
  </div>

</main>
<?php generate_dashboard_footer(); ?>
