<?php
include '../DataSet/db.php';

$ref = filter_input(INPUT_GET, 'term', FILTER_SANITIZE_STRING);

$result_msg_cont = "SELECT DISTINCT reference FROM stock WHERE reference LIKE '%$ref%' 
                    AND reference NOT IN (SELECT DISTINCT reference FROM reference) ORDER BY reference ASC LIMIT 8";

$resultado_msg_cont = $pdo->prepare($result_msg_cont);
$resultado_msg_cont->execute();

while($row = $resultado_msg_cont->fetch(PDO::FETCH_ASSOC)){
    $data[] = $row['reference'];
}
echo json_encode($data);
?>