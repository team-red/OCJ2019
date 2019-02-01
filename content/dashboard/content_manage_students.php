<table class="table">


    <thead class="thead-dark">
    
        <th scope="col">Nom Complet</th>
        <th scope="col">Debloquer</th>
        <th scope="col">Actions</a></th>
    
    </thead>

    <tbody>


    </tbody>

    


</table>

<table class="table">


    <thead class="thead-dark">
    
        <th scope="col">Titre du qcm</th>
        <th scope="col">Nombre de reponses correctes</th>
        <th scope="col">Nombre total de question</th>
        <th scope="col">Score</th>
        <th scope="col">Score Maximum</a></th>

    
    </thead>

    <?php

    require_once("utils/profile/user_data.php");
    $data = UserData::fromEmail($dbh, "admin@qcm");

    ?>

    <tbody>

    <?php

    foreach ($data as $qcm_res) {
        $title = htmlspecialchars($qcm_res["qcm"]->title);
        $num_correct = htmlspecialchars($qcm_ans["correct_ans"]);
        $num_tot = count($qcm_res["qcm"]->questions);
        $score = htmlspecialchars($qcm_res["score"]);
        $score_max = htmlspecialchars($qcm_res["qcm"]->max_score);
        echo <<<flag
        <tr>
            <td>$title</td>
            <td>$num_correct</td>
            <td>$num_tot</td>
            <td>$score</td>
            <td>$score_max</td>
        </tr>
flag;
    }

    ?>

    </tbody>

    


</table>