<?php
include '../DataSet/db.php';

$type = filter_input(INPUT_GET, 'term', FILTER_SANITIZE_STRING);

//SQL para selecionar os registros
$result_msg_cont = "SELECT X.type FROM ( 
                    SELECT DISTINCT type FROM articles 
                    UNION SELECT DISTINCT type FROM stock ) X
                    WHERE X.type LIKE '%".$type."%'  ORDER BY X.type ASC LIMIT 8";

//Seleciona os registros
$resultado_msg_cont = $pdo->prepare($result_msg_cont);
$resultado_msg_cont->execute();

while($row_msg_cont = $resultado_msg_cont->fetch(PDO::FETCH_ASSOC)){
    $data[] = $row_msg_cont['type'];
}

echo json_encode($data);