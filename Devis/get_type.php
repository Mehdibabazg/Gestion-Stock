<?php
include '../DataSet/db.php';
if(!empty($_POST['reference'])){
    $reference = $_POST['reference'];

    $result_msg_cont = "SELECT DISTINCT type FROM ( 
                        SELECT reference, type FROM articles 
                        UNION SELECT reference, type FROM stock ) X WHERE X.reference = '$reference'";

    $resultado_msg_cont = $pdo->prepare($result_msg_cont);
    $resultado_msg_cont->execute();
    $count = $resultado_msg_cont->rowCount();
    if($count >0){
        foreach ($resultado_msg_cont as $row){
            $data = $row['type'];
        }
        echo ($data);
    }
    
}