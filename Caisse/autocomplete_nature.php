<?php
include '../DataSet/db.php';

$nature = filter_input(INPUT_GET, 'term', FILTER_SANITIZE_STRING);

//SQL para selecionar os registros
$result_msg_cont = "SELECT DISTINCT nature FROM caisse WHERE nature LIKE '%".$nature."%' ORDER BY nature ASC LIMIT 5";

//Seleciona os registros
$resultado_msg_cont = $pdo->prepare($result_msg_cont);
$resultado_msg_cont->execute();

while($row_msg_cont = $resultado_msg_cont->fetch(PDO::FETCH_ASSOC)){
    $data[] = $row_msg_cont['nature'];
}
echo json_encode($data);