<main class="home_page_main container-fluid">

  <div class="home_page_main_row row">
    <aside class="home_page_left col-md-4">
      <?php home_page_generate_left($personalInfo); ?>
    </aside>

    <aside class="home_page_right col-md-8">
      <?php home_page_generate_right($quizInfo); ?>
    </aside>
  </div>

</main>
<?php generate_dashboard_footer(); ?>
