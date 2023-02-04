<?php
session_start();
require '../DataSet/db.php';
$emis = $_POST['emis'];
$echeance = $_POST['echeance'];
$type = $_POST['type'];
$numero = $_POST['numero'];
$montant = $_POST['montant'];
$fournisseur = $_POST['fournisseur'];
$nature = $_POST['nature'];
            $sql = "INSERT INTO cheques (emis, echeance, type, numero, montant, fournisseur, nature, debite) VALUES (?,?,?,?,?,?,?,?)";
            $data = $pdo->prepare($sql);
            $data->execute(["$emis", "$echeance", "$type", "$numero", "$montant", "$fournisseur", "$nature", "Non"]);
