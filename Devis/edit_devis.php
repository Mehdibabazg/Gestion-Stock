<?php
$id = $_REQUEST['id'];
$qte = $_REQUEST['qte'];
$prix = $_REQUEST['prix'];



require '../DataSet/db.php';
$edit_devis = "UPDATE devis_details SET quantite = '$qte', prix_ttc = '$prix' WHERE id = $id" ;
$inf = $pdo->query($edit_devis);
if ($inf) {
    echo 'true';
}else{
    echo 'false';
}