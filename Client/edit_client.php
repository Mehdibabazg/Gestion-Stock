<?php
$id = $_REQUEST['id'];
$nom = $_REQUEST['nom'];
$societe = $_REQUEST['societe'];
$gsm = $_REQUEST['gsm'];
$email = $_REQUEST['email'];
$adresse = $_REQUEST['adresse'];


require '../DataSet/db.php';
$client_info = "UPDATE client SET nom = '$nom', societe = '$societe', gsm = '$gsm', email = '$email', adresse = '$adresse' WHERE id = $id" ;
$inf = $pdo->query($client_info);
if ($inf) {
    echo 'true';
}else{
    echo 'false';
}