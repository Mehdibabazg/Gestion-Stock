<?php
$id = $_REQUEST['id'];
$ref = $_REQUEST['ref'];
$type = $_REQUEST['type'];
$qte = $_REQUEST['qte'];
$prix = $_REQUEST['prix'];
$tva = $_REQUEST['tva'];
$fourn = $_REQUEST['fourn'];

require '../DataSet/db.php';

$pro_info = "UPDATE articles SET reference = '$ref', type = '$type', quantite = quantite + $qte, prix_achat = '$prix', prix_achat = '$prix', TVA = '$tva', fournisseur = '$fourn' WHERE id = $id" ;
$inf = $pdo->query($pro_info);
    echo "<script>
            window.location.href='Articles.php';
            </script>";