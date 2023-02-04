<?php
$id = $_REQUEST['id'];
$date = $_REQUEST['date'];
$objet = $_REQUEST['objet'];
$nature = $_REQUEST['nature'];
$montant = $_REQUEST['montant'];

require '../DataSet/db.php';

$pro_info = "UPDATE caisse SET date = '$date', objet = '$objet', nature = '$nature', montant = '$montant' WHERE id = $id" ; 
echo $pro_info;
$inf = $pdo->query($pro_info);
if ($inf) {
    echo "Modification Effectué Avec Succées";
}