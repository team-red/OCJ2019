<main class="myinfo_main container-fluid">

  <div class="myinfo_pdp_options row">
    <?php
    myinfo_generate_options($personalInfo);
    ?>
  </div>
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

  <div class="myinfo_personal myinfo_container">
    <h class="row"><h class="col-md-2">Details personelles</h><hr class="col-md-10 myinfo_hr"></h>
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

  <div class="myinfo_quiz myinfo_container">
    <h class="row"><h class="col-md-2">Questionnaires</h><hr class="col-md-10 myinfo_hr"></h>
    <div class="myinfo_quiz_tabs">
      <header>
        <span id="myinfo_quiz_tab_rank" onclick="rank_tab()">Classements</span>
        <span id="myinfo_quiz_tab_done" onclick="done_tab()">Questionnaires</span>
      </header>
      <main>
        <div class="myinfo_quiz_tabs_content container-fluid" id="myinfo_quiz_tabs_rank">
          <?php
          myinfo_generate_rank_tab($quizInfo);
          ?>
        </div>
        <div class="myinfo_quiz_tabs_content container-fluid" id="myinfo_quiz_tabs_done">
          <?php
          myinfo_generate_done_tab($quizInfo);
          ?>
        </div>
      </main>
    <div>
  </div>

</main>
<?php generate_footer(); ?>
