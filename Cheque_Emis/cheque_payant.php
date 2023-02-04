<?php
session_start();
require '../DataSet/db.php';
$msg = $_POST['cheque'];
$update_cheque=$pdo->query("UPDATE cheques SET debite = 'Oui' WHERE id in ( $msg )");
if($update_cheque){
    echo 'Opération Effectué';
}