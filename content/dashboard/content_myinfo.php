<main class="myinfo_main container-fluid">

  <div class="myinfo_pdp row">
    <div class="myinfo_pdp_pdp col-md-3">
      <?php
      myinfo_generate_pdp_pdp($personalInfo);
      ?>
    </div>
    <div class="myinfo_pdp_info col-md-9">
      <?php
      myinfo_generate_pdp_info($personalInfo);
      ?>
    </div>
  </div>

  <div class="myinfo_personal row">
    <h1>Details personelles</h1>
    <span class="myinfo_personal_academic">
      <?php
      myinfo_generate_personal_academic($personalInfo);
      ?>
    </span>
    <span class="myinfo_personal_postal">
      <?php
      myinfo_generate_personal_postal($personalInfo);
      ?>
    </span>
    <span class="myinfo_personal_personal">
      <?php
      myinfo_generate_personal_personal($personalInfo);
      ?>
    </span>
  </div>

  <div class="myinfo_quiz row">
    <h1>Details questionnaires</h1>
    <div class="myinfo_quiz_tabs">
      <header>
        <span>Classements</span>
        <span>Questionnaires faits</span>
      </header>
      <main>
        <div class="myinfo_quiz_tabs_rank myinfo_quiz_tabs_content">
          <?php
          myinfo_generate_rank_tab($quizInfo);
          ?>
        </div>
        <div class="myinfo_quiz_tabs_done myinfo_quiz_tabs_content">
          <?php
          myinfo_generate_done_tab($quizInfo);
          ?>
        </div>
      </main>
    <div>
  </div>

</main>
<?php generate_dashboard_footer(); ?>
