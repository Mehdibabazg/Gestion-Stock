<?php 

require '../DataSet/db.php';
$n_bon = $_POST['n_bon'];
$sql = "SELECT date_vente, societe, N_bon, sum(B.total) AS 'Total', facture FROM (
        SELECT DISTINCT (D.date_vente), societe, S.N_bon, sum(D.prix_vente) AS total, facture FROM vente_details D 
        INNER JOIN stock S on D.N_serie = S.N_serie INNER JOIN client C on D.id_client = C.id WHERE D.N_bon LIKE '%$n_bon%' 
        GROUP BY D.date_vente, S.N_bon 
        UNION 
        SELECT DISTINCT (V.date_vente), societe, V.N_bon, sum(V.prix_vente * V.quantite) AS total, facture FROM vente_article V 
        INNER JOIN client C ON c.id = V.id_client 
        WHERE V.N_bon LIKE '%$n_bon%' GROUP BY V.date_vente, N_bon) B GROUP BY B.date_vente, B.N_bon order by B.date_vente DESC";
$data = $pdo->query($sql);
?>
<table class="table table-condensed table-hover table-bordered table-striped" id="mytable">
    <thead>
        <tr>
            <th><center>Date de vente</center></th>
            <th><center>Société</center></th>
            <th><center>N°Bon</center></th>
            <th><center>Total</center></th>
            <th><center>Facture</center></th>
            <th><center>Affichage</center></th>
        </tr>
    </thead>
    <tbody style="color:black;">
        <?php
            foreach ($data as $row){ ?>
        <tr>
            <td><center><?php echo date("d/m/Y", strtotime($row['date_vente']));?></center></td>
            <td><center><?php echo($row['societe']);?></center></td>
            <td><center><?php echo($row['N_bon']);?></center></td>
            <td><center><?php echo number_format($row['Total'],2,","," ");?></center></td>
            <td><center><?php echo($row['facture']);?></center></td>
            <td><center>
                <button title="Afficher les details" data-bs-toggle="modal" data-bs-target="#bon_details" class="btn btn-space btn-secondary"
                    onclick="open_model_bon('<?php echo $row['N_bon']; ?>');">
                <i class="far fa-eye"></i></button>
                </center></td> 
        </tr>
        <?php   } ?>
    </tbody>
</table>