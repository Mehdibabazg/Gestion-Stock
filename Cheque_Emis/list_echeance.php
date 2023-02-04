<?php 

require '../DataSet/db.php';

$condition = $_POST['echeance'];

$sql = "SELECT DATE_FORMAT(echeance, '%M', 'fr_FR') AS mois, YEAR(echeance) AS annee, ROUND(SUM(montant), 2) AS montant FROM cheques 
        WHERE YEAR(echeance) = '$condition' AND debite = 'Non' GROUP BY mois";
$data = $pdo->query($sql);
?>
<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
    <thead>
        <tr>
            <th><center>Mois</center></th>
            <th><center>Montant</center></th>
        </tr>
    </thead>
    <tbody style="color:black;">
        <form name="listC" id="listC">
        <?php
            foreach ($data as $row){ ?>
        <tr>
            <td><center><?php echo $row['mois'].' '.$row['annee'];?></center></td>
            <td><center><?php echo number_format($row['montant'],2,","," ");?></center></td>
        </tr>
        <?php   } ?>
        </form>
    </tbody>
</table>