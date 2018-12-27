<!--
Breifing sur l'utilisateur : avatar, nom, prenom, ecole (non renseignée sinon), nombre de qcms faits, note moyenne,
nombre de qcms restants, dernieres activités...
 -->
<header class="home_page_header">
</header>
<main class="home_page_main container-fluid">
  <header class="row"><span class="col-md-12">Resumé : </span></header>
  <div class="row home_page_profil">
    <aside class="col-md-4 home_page_profil_photo">
      <?php home_page_get_profil_photo(); ?>
    </aside>
    <main class="col-md-8 home_page_information">
      <?php home_page_get_information(); ?>
    </main>
  </div>
  <div class="row home_page_quiz">
    <div class="col-md-4 home_page_quiz_done">
      <?php home_page_get_done(); ?>
    </div>
    <div class="col-md-4 home_page_quiz_undone">
      <?php home_page_get_undone(); ?>
    </div>
    <div class="col-md-4 home_page_quiz_results">
      <?php home_page_get_results(); ?>
    </div>
  </div>
  <div class="row home_page_chat">
    <aside class="col-md-4 home_page_chat_sidebar">
      <?php home_page_generate_chat_sidebar(); ?>
    </aside>
    <main class="col-md-8 home_page_chat_main">
      <?php home_page_generate_chat_main(); ?>
    </main>
  </div>
  <div class="row home_page_about">
    <main class="col-md-12">
      <?php home_page_generate_about(); ?>
    </main>
  </div>
</main>

<?php generate_dashboard_footer(); ?>
