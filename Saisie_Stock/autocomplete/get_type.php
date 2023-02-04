<?php
include '../../DataSet/db.php';
if(!empty($_POST['ref'])){
    $ref = $_POST['ref'];

    $result_msg_cont = "SELECT DISTINCT type FROM stock WHERE reference = '$ref'";

    $resultado_msg_cont = $pdo->prepare($result_msg_cont);
    $resultado_msg_cont->execute();
    $count = $resultado_msg_cont->rowCount();
    if($count >0){
        foreach( $resultado_msg_cont as $row){
            $data = $row['type'];
        }
        echo ($data);
    }
    
}