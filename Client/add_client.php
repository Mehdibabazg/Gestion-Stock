<?php
$nom = $_POST['nom'];
$societe = $_POST['societe'];
$gsm = $_POST['phone'];
$email = $_POST['email'];
$adresse = $_POST['adresse'];
require '../DataSet/db.php';
$pro_info = "INSERT INTO client (nom, societe, gsm, email, adresse ) VALUES ('$nom', '$societe', '$gsm', '$email', '$adresse')";
$inf = $pdo->query($pro_info);
if ($inf) {
    echo 'true';
}else{
    echo 'false';
}