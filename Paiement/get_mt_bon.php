<?php
session_start();
$N_bon = $_REQUEST['n_bon'];
include "../DataSet/db.php";
$sql = "SELECT sum(B.total) AS 'Somme Total' FROM (
        SELECT sum(D.prix_vente) AS total FROM vente_details D INNER JOIN stock S on D.N_serie=S.N_serie WHERE D.N_bon = '$N_bon'
        UNION SELECT sum(V.prix_vente * V.quantite) AS total FROM vente_article V WHERE V.N_bon = '$N_bon' ) B";
$req = $pdo->query($sql);

foreach ($req as $row){
        echo number_format($row['Somme Total'],2,',','');
}

?>