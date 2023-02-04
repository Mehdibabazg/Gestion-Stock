<?php
session_start();
require '../DataSet/db.php';
$reference = $_POST['reference'];
$prix = $_POST['prix'];
    $pro_info = "INSERT INTO reference (reference, prix) VALUES (?,?)";
    $inf = $pdo->prepare($pro_info);
    $inf->execute(["$reference", "$prix"]);
    if ($inf) {
        echo "Operation Effectué";
    }
