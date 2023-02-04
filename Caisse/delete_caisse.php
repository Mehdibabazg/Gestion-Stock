<?php
$id = $_REQUEST['id'];
require '../DataSet/db.php';
	$delete_caisse="DELETE FROM caisse WHERE id = $id";
	$req = $pdo->query($delete_caisse);
    if ($req) {
        echo 'Suppression Efféctué Avec Succées';
    }
?>