<?php
$id = $_REQUEST['id'];
require '../DataSet/db.php';
    $delete_article="DELETE FROM devis_details WHERE id = $id";
    $req = $pdo->prepare($delete_article);
    $req->execute();
    if ($req) {
        echo 'true';
    }else{
        echo 'false';
    }
?>