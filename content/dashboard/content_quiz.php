<!--
Questionnaires fait et pas faits
-->

<header class="quiz_header"></header>


<?php
    require_once("utils/quiz/quiz.php");
    require_once("utils/quiz/attempt.php");
    require_once("utils/quiz/timestamp.php");

    if(isset($_GET["qcm_del"]) && $user->role === "admin"){
      Qcm::del($dbh, htmlspecialchars($_GET["qcm_del"]));
    }

    $valid_qcm = true; // always start with good intentions lol
    if (isset($_GET["qcm_id"]) === false){
        $valid_qcm = false;
    } else {
        $qcm_id = $_GET["qcm_id"];
        $qcm = Qcm::fromId($dbh, $qcm_id);
        if ($qcm === false){
            $valid_qcm = false;
        }
    }

    if ($valid_qcm === false){
        $qcms = Qcm::getAll($dbh);
        showQcms($qcms, $user);
    } else {
        if (isset($_POST["ans"]) === false){
            if (Timestamp::hasStamp($dbh, $qcm_id, $user->login)){
                Quiz::denyAccess();
            } else {
                Quiz::createForm($dbh, $qcm_id);
                Timestamp::touch($dbh, $qcm_id, $user->login);
            }
        } else {
            if (Attempt::hasAttemptedQcm($dbh, $qcm_id, $user->login)){
                denyAccess();
            } else {
                $now = time();
                $stamp = Timestamp::getStamp($dbh, $qcm_id, $user->login)[0];
                $stamp = filter_var($stamp, FILTER_VALIDATE_INT);
                $duration = $qcm->duration_seconds;
                $duration = filter_var($duration, FILTER_VALIDATE_INT);
                if ($stamp === false || $duration === false){
                    // something bad happened, something very bad happened
                    Quiz::attemptFailed();
                } else {
                    $timed_out = ($now - $stamp) > ($duration + 5); // 5 seconds for leniency (+ server delay?)
                    if ($timed_out === false){
                        $data = isset($_POST["ans"]) ? $_POST["ans"] : array();
                        $success = Attempt::insert($dbh, $data, $user->login);
                        if ($success === false){
                            Quiz::attemptFailed();
                        } else {
                            Quiz::attemptSucceeded();
                        }
                    } else {
                        // in case client bypasses client-side verification
                        Quiz::timedOut();
                    }
                }
            }
        }
    }

?>

<?php generate_footer(); ?>
