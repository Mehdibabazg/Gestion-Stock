<?php
include '../../DataSet/db.php';

$ref = filter_input(INPUT_GET, 'term', FILTER_SANITIZE_STRING);

//SQL para selecionar os registros
$result_msg_cont = "SELECT DISTINCT reference, type FROM stock WHERE reference LIKE '%".$ref."%' ORDER BY reference ASC LIMIT 5";

//Seleciona os registros
$resultado_msg_cont = $pdo->prepare($result_msg_cont);
$resultado_msg_cont->execute();

while($row = $resultado_msg_cont->fetch(PDO::FETCH_ASSOC)){
  $data[] = $row['reference'];


}

echo json_encode($data);


?>