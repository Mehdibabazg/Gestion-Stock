<?php
session_start();
require '../DataSet/db.php';
$objet = $_POST['objet'];
$date = $_POST['date'];
$numero = $_POST['numero'];
$montant = $_POST['montant'];
$nature = $_POST['nature'];
    $sql = "INSERT INTO caisse (date, objet, montant, nature) VALUES ('$date', '$objet', '$montant', '$nature')";
    $data = $pdo->query($sql);
    if ($data) {
        echo 'Enregistrement Effectué';
    }else{
        echo 'false';
    }