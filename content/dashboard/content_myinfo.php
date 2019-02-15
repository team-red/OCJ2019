<?php
require_once("utils/helper/info_utils.php");
?>

<div class="myinfo_main container-fluid">

  <div class="myinfo_pdp_options row">
    <?php
    myinfo_generate_options($user);
    ?>
  </div>
  <div class="myinfo_pdp row">

    <div class="myinfo_pdp_pdp col-md-3">
      <?php
      myinfo_generate_pdp_pdp($user);
      ?>
    </div>
    <div class="myinfo_pdp_info col-md-9">
      <?php
      myinfo_generate_pdp_info($user);
      ?>
    </div>
  </div>

  <div class="myinfo_personal myinfo_container">
    <div class="row myinfo_container_title"><span class="col-md-2">Details personelles</span><hr class="col-md-10 myinfo_hr"></div>
    <span class="myinfo_personal_academic">
      <?php
      myinfo_generate_personal_academic($user);
      ?>
    </span>
    <span class="myinfo_personal_postal">
      <?php
      myinfo_generate_personal_postal($user);
      ?>
    </span>
    <span class="myinfo_personal_personal">
      <?php
      myinfo_generate_personal_personal($user);
      ?>
    </span>
  </div>

  <div class="myinfo_quiz myinfo_container">
    <div class="row"><span class="col-md-2">Questionnaires</span><hr class="col-md-10 myinfo_hr"></div>
    <div class="myinfo_quiz_tabs">
      <div class="myinfo_quiz_tabs_header">
        <span id="myinfo_quiz_tab_rank" onclick="rank_tab()">TOP10</span>
        <span id="myinfo_quiz_tab_done" onclick="done_tab()">Questionnaires</span>
      </div>
      <div>
        <div class="myinfo_quiz_tabs_content container-fluid" id="myinfo_quiz_tabs_rank">
          <?php
          myinfo_generate_rank_tab(array(
            "champion" => "FOUSSOUL Ayoub",
            "myRank" => 22,
            "afterMe" => "SLIMANI Adam",
            "lastRank" => 203,
            "lastOne" => "BOUTIHAL Achraf",
            "done" => 12,
            "numOfQuizes" => 19,
            "success" => 13,
            "mark" => 15,
          ));
          ?>
        </div>
        <div class="myinfo_quiz_tabs_content container-fluid" id="myinfo_quiz_tabs_done">
          <?php
          myinfo_generate_done_tab(array(
            "champion" => "FOUSSOUL Ayoub",
            "myRank" => 22,
            "afterMe" => "SLIMANI Adam",
            "lastRank" => 203,
            "lastOne" => "BOUTIHAL Achraf",
            "done" => 12,
            "numOfQuizes" => 19,
            "success" => 13,
            "mark" => 15,
          ));
          ?>
        </div>
      </div>
    </div>
  </div>

</div>
<?php generate_footer(); ?>
