<?php

require '../DataSet/db.php';
$N_bon = $_POST['n_bon'];
$mt_cheque = $_POST['mt_cheque'];
$num_cheque = $_POST['num_cheque'];
$echeance = $_POST['echeance'];
$especes = $_POST['montant_especes'];
$virement = $_POST['montant_virement'];
$reste = $_POST['reste'];
$date_encaissement = date("Y-m-d"); 
        $sql = "INSERT INTO paiement(N_bon, num_cheque, mt_cheque, especes, virement, reste, date_encaissement, echeance, debit) VALUES (?,?,?,?,?,?,?,?,?)";
        $req=$pdo->prepare($sql);
        $req->execute(["$N_bon", "$num_cheque", "$mt_cheque", "$especes", "$virement", "$reste", "$date_encaissement", "$echeance", "Non"]);
        if ($req) {
            echo "Enregistrement Effectuée";
        }else{
            echo "Une Erreur s'est Produite";
        }
        
