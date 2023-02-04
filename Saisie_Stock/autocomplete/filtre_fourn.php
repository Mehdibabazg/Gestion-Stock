<?php
include '../../DataSet/db.php';

$fourn = filter_input(INPUT_GET, 'term', FILTER_SANITIZE_STRING);

//SQL para selecionar os registros
$result_msg_cont = "SELECT DISTINCT fournisseur FROM  stock WHERE fournisseur LIKE '%".$fourn."%' ORDER BY fournisseur ASC LIMIT 5";

//Seleciona os registros
$resultado_msg_cont = $pdo->prepare($result_msg_cont);
$resultado_msg_cont->execute();

while($row_msg_cont = $resultado_msg_cont->fetch(PDO::FETCH_ASSOC)){
    $data[] = $row_msg_cont['fournisseur'];
}

echo json_encode($data);


?>