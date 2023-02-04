<?php
include '../DataSet/db.php';
if(!empty($_POST['reference'])){
    $reference = $_POST['reference'];

    $result_msg_cont = "SELECT prix FROM reference WHERE reference = '$reference'";

    $resultado_msg_cont = $pdo->prepare($result_msg_cont);
    $resultado_msg_cont->execute();
    $count = $resultado_msg_cont->rowCount();
    if($count >0){
        foreach ($resultado_msg_cont as $row){
            $data = $row['prix'] * 1.2;
            $prix = $data + $data * 0.15;
        }
        echo ($prix);
    }
}