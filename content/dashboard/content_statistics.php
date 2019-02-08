<?php

require_once("utils/profile/user_data.php");

echo "Number of qcms tried by me (current user)<br>";
$num_qcm_tried = UserData::numberOfQcmsTried($dbh, $user);
print_r($num_qcm_tried);
echo "<br>";


$data = UserData::fromEmail($dbh, $user);
echo "data = array with all data about me (current user) (for each qcm i tried)<br><br>";
$some_attempted_qcm = $data[0];
$qcm_object = $data[0]["qcm"];
foreach ($data[0] as $key => $value) {
    echo $key . "<br>";
}

echo "<br>data[0]['qcm'] contient l'object qcm associé<br>";

echo "<br>data[0]['scores'] contains my score/the max score/whether answer is correct for each question<br>";
foreach ($data[0]["scores"] as $key => $value){
    print_r($value);
    echo "<br>";
}

echo "<br>data[0]['correct_ans'] contient le nombre de réponses correctes<br> = ";
print_r($data[0]["correct_ans"]);

echo "<br>data[0]['qcm_score'] contient mon score pour ce qcm<br> = ";
print_r($data[0]["qcm_score"]);


?>