<?php

include "../DataSet/db.php";

$societe = $_POST['societe'];
$num_devis = $_POST['num_devis'];
$id_client = $_POST['id_client'];
$new_num_devis = $_POST['new_num_devis'];
$date = date("Y-m-d");

$devis = $pdo->query("INSERT INTO devis (num_devis, id_client, date_devis) VALUES 
                        ('$new_num_devis', '$id_client', '$date')");

$devis_details = $pdo->query("INSERT INTO devis_details (num_devis, reference, type, quantite, prix_ttc) 
                    SELECT '$new_num_devis', reference, type, quantite, prix_ttc FROM devis_details WHERE num_devis = '$num_devis'");
                    if ($devis && $devis_details) {
                        echo 'true';
                    }
?>