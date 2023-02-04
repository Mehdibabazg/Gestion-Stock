<?php
require '../DataSet/db.php';

$ref = $_REQUEST['ref'];
$qte = $_REQUEST['qte'];
$sql = "SELECT quantite reference FROM articles WHERE reference = '$ref'";
$req = $pdo->query($sql);
$row = $req->fetchAll();
if ($ref == $row['reference']) {
    $pro = "UPDATE articles SET quantite = quantite + $qte WHERE reference = '$ref'";
    $info = $pdo->query($pro);
    echo "<script>
            window.location.href='Articles.php';
            </script>";
}else{
    $type = $_REQUEST['type'];
    $prix = $_REQUEST['prix'];
    $tva = $_REQUEST['tva'];
    $fourn = $_REQUEST['fourn'];
    $pro_info = "INSERT INTO articles (reference, type, quantite, prix_achat, tva, fournisseur ) VALUES ('$ref', '$type', '$qte', '$prix', '$tva', '$fourn')";
    $inf = $pdo->query($pro_info);
    echo "<script> window.location.href='Articles.php';</script>";}