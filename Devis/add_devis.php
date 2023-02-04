<?php
  $tableData = stripcslashes($_POST['pTableData']);
  $tableData = json_decode($tableData,TRUE);
  $count = count($tableData);
  $societe = $_POST['societe'];
  $num_devis = $_POST['num_devis'];
  $date = date("Y-m-d");
include "../DataSet/db.php";
$devis = $pdo->query("INSERT INTO devis (num_devis, id_client, date_devis) VALUES 
                        ('$num_devis', '$societe', '$date')");
for ($i=0; $i < $count; $i++) { 
    $ref = $tableData[$i]['reference'];
    $type = $tableData[$i]['type'];
    $qte = $tableData[$i]['qte'];
    $prix = $tableData[$i]['prix'];
    $create_devis = $pdo->query("INSERT INTO devis_details (num_devis, reference, type, quantite, prix_ttc) VALUES 
                                ('$num_devis', '$ref', '$type', '$qte', '$prix')");
}
if ($create_devis) {
    echo 'success';    
}
?>