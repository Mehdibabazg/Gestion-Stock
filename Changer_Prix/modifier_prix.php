<?php
$prix = $_REQUEST['prix'];
$ref = $_REQUEST['ref'];


require '../DataSet/db.php';
$ref_info = "UPDATE reference SET prix = $prix WHERE reference = '$ref'" ;
$inf = $pdo->query($ref_info);
