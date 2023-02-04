<?php
session_start();
require '../DataSet/db.php';
$reference = $_POST['ref'];
$type = $_POST['type'];
$fournisseur = $_POST['fourn'];
$N_serie = $_POST['n_serie'];
$dateE = date("Y-m-d");
    if (!empty($type) | !empty($reference) | !empty($fournisseur) | !empty($N_serie)) {
        $sql = "SELECT N_serie, etat_vente FROM stock WHERE N_serie = '$N_serie'";
        $req = $pdo->query($sql);
        $resultat=$req->fetch(PDO::FETCH_ASSOC);
        $count = $req->rowCount();
        if ($count>0) {
            if ($resultat['etat_vente']=='Oui') {
                $req2 = $pdo->query("UPDATE stock SET N_bon = '', etat_vente = 'Non', date_vente = '1900-01-01', prix_vente = '' WHERE N_serie='$N_serie'");
                $req3 = $pdo->query("DELETE FROM `vente_details` WHERE N_serie = '$N_serie'");
                echo "Mise à Jour Effectuée";
            }else{
                echo "Produit existe déja !!!";
            }
        }else{
            $pro_info = "INSERT INTO stock (type, reference, fournisseur, N_serie, date_entre, date_vente, etat_vente) VALUES (?,?,?,?,?,?,?)";
            $inf = $pdo->prepare($pro_info);
            $inf->execute(["$type", "$reference", "$fournisseur", "$N_serie", "$dateE", "1900-01-01", "Non"]);
            if ($inf) {
                echo 'Enregitrement Efféctué';
            }else{
                echo '';
            }
        }
    }