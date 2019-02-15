<?php

require_once("utils/profile/user.php");
require_once("utils/profile/user_data.php");


class AdminPanel
{
    public static function createUserManagerForm($dbh){
        echo <<<flag
        <table class="table">
            <thead class="thead-dark">
              <tr>
                <th scope="col">Nom Complet</th>
                <th scope="col" class="manager_hide">Pseudo</th>
                <th scope="col">Nombre de QCMs essayés</th>
                <th scope="col">Actions</th>
              </tr>
            </thead>
            <tbody>
flag;
        $students = User::getAll($dbh);
        foreach ($students as $student) {
            $full_name = htmlspecialchars($student->surname . " " . $student->name);
            $num_qcms = UserData::numberOfQcmsTried($dbh, $student);
            $pseudo = htmlspecialchars($student->login);
            echo <<<flag
            <tr>
                <td>$full_name</td>
                <td class="manager_hide">$pseudo</td>
                <td>$num_qcms</td>
                <td>
                    <a href="dashboard.php?page=manage_students&action=view_activity&value=$student->login">Voir Activité</a>
                    <a href="dashboard.php?page=manage_students&action=delete&value=$student->login" style='color: red; margin-left: 10px;'>Supprimer</a>
                </td>
            </tr>
flag;
}


        echo <<<flag
            </tbody>
        </table>
flag;
    }

    public static function createUserOverview($dbh, $user){
        echo <<<flag
        <table class="table">
            <thead class="thead-dark">
                <th scope="col">Titre du qcm</th>
                <th scope="col">Nombre de reponses correctes</th>
                <th scope="col">Nombre total de questions</th>
                <th scope="col">Score</th>
                <th scope="col">Score Maximum</a></th>
                <th scope="col">Actions</th>
            </thead>
            <tbody>
flag;
        $data = UserData::fromEmail($dbh, $user);
        foreach ($data as $qcm_res) {
            $title = htmlspecialchars($qcm_res["qcm"]->title);
            $num_correct = htmlspecialchars($qcm_res["correct_ans"]);
            $num_tot = count($qcm_res["qcm"]->questions);
            $score = htmlspecialchars($qcm_res["qcm_score"]);
            $score_max = htmlspecialchars($qcm_res["qcm"]->max_score);
        echo <<<flag
                <tr>
                    <td>$title</td>
                    <td>$num_correct</td>
                    <td>$num_tot</td>
                    <td>$score</td>
                    <td>$score_max</td>
                    <td><a href="dashboard.php?page=manage_students&action=unblock&u_login={$user->login}&qcm_id={$qcm_res['qcm']->id}">Débloquer</a></td>
                </tr>
flag;
        }
        echo <<<flag
            </tbody>
        </table>
flag;
    }
}

?>
