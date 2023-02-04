<?php
include '../DataSet/db.php';

$reference = filter_input(INPUT_GET, 'term', FILTER_SANITIZE_STRING);

//SQL para selecionar os registros
$result_msg_cont = "SELECT X.reference FROM ( 
                    SELECT DISTINCT reference FROM articles 
                    UNION SELECT DISTINCT reference FROM stock ) X
                    WHERE X.reference LIKE '%".$reference."%'  ORDER BY X.reference ASC LIMIT 8";

//Seleciona os registros
$resultado_msg_cont = $pdo->prepare($result_msg_cont);
$resultado_msg_cont->execute();

while($row_msg_cont = $resultado_msg_cont->fetch(PDO::FETCH_ASSOC)){
    $data[] = $row_msg_cont['reference'];
}

echo json_encode($data);