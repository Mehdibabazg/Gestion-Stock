<?php
session_start();
require '../DataSet/db.php';
$rech=$_POST['rech'];
$condition=$_POST['condition'];
$etat = $_POST['etat'];

if ($etat == 'vendu') {
    if($condition == 'n_serie'){
        $condition = "S.N_serie";
        $req = "SELECT nom, societe, CAST( D.date_vente AS DATE ) AS date_vente, date_entre, D.N_bon, S.reference, S.N_serie, D.prix_vente, fournisseur FROM
                vente_details D inner join client C on D.id_client = C.id inner join Stock S on D.N_serie = S.N_serie WHERE $condition LIKE '%$rech%'
                ORDER BY D.date_vente desc,N_bon,S.reference";
        $data = $pdo->query($req);
        /* echo $req;
        echo $data->rowCount(); */
        ?>
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th><center>Nom</center></th>
                    <th><center>Société</center></th>
                    <th><center>Date de Vente</center></th>
                    <th><center>Date d'Entrée</center></th>
                    <th><center>N Bon</center></th>
                    <th><center>Reference</center></th>
                    <th><center>N Série</center></th>
                    <th><center>Prix de Vente</center></th>
                    <th><center>Fournisseur</center></th>
                </tr>
            </thead>
            <tbody style="color:black;">
                <?php foreach ($data as $row){ ?>
                <tr>
                    <td><center><?php echo ucwords($row['nom']); ?></center></td>
                    <td><center><?php echo ucwords($row['societe']); ?></center></td>
                    <td><center><?php echo date("d/m/Y", strtotime($row['date_vente'])); ?></center></td>
                    <td><center><?php echo date("d/m/Y", strtotime($row['date_entre'])); ?></center></td>
                    <td><center><?php echo ucwords($row['N_bon']); ?></center></td>
                    <td><center><?php echo ucwords($row['reference']); ?></center></td>
                    <td><center><?php echo ucwords($row['N_serie']); ?></center></td>
                    <td><center><?php echo number_format($row['prix_vente'],2,',',''); ?></center></td>
                    <td><center><?php echo ucwords($row['fournisseur']); ?></center></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
        <?php
    }else if($condition == 'fournisseur'){
        $req = "SELECT CAST(date_entre AS DATE) AS date_entre, type, reference, COUNT(N_serie) AS total FROM stock WHERE $condition LIKE '%$rech%'
                GROUP BY CAST(date_entre AS DATE), type, reference ORDER BY CAST(date_entre AS DATE) desc, type";
        $data = $pdo->query($req);
        ?>
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th><center>Date d'Entrée</center></th>
                    <th><center>Type</center></th>
                    <th><center>Référence</center></th>
                    <th><center>Total</center></th>
                </tr>
            </thead>
            <tbody style="color:black;">
                <?php foreach ($data as $row){ ?>
                <tr>
                    <td><center><?php echo date("d/m/Y", strtotime($row['date_entre'])); ?></center></td>
                    <td><center><?php echo ucwords($row['type']); ?></center></td>
                    <td><center><?php echo ucwords($row['reference']); ?></center></td>
                    <td><center><?php echo number_format($row['total'],2,',',''); ?></center></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
        <?php
    }else if($condition == 'N_bon'){
        //echo $condition;
        $req1 = "SELECT nom, societe, date_vente, N_bon, reference, N_serie, prix_vente FROM (SELECT nom, societe, CAST( D.date_vente AS DATE ) AS date_vente,
                D.N_bon, S.reference, S.N_serie, D.prix_vente FROM 
                vente_details D inner join client C on D.id_client = C.id inner join Stock S on D.N_serie = S.N_serie WHERE D.$condition LIKE '%$rech%'
                UNION
                SELECT nom, societe, CAST( V.date_vente AS DATE ) AS date_vente, V.N_bon, A.reference, CAST( V.quantite AS VARCHAR(20)) 
                AS N_serie, V.prix_vente FROM vente_article V inner join client C on V.id_client = C.id 
                inner join articles A on A.id = V.id_articles WHERE V.$condition LIKE '%$rech%')X";
        $data = $pdo->query($req1);
        //echo $req1;
        ?>
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th><center>Nom</center></th>
                    <th><center>Société</center></th>
                    <th><center>Date de Vente</center></th>
                    <th><center>N Bon</center></th>
                    <th><center>Reference</center></th>
                    <th><center>N Série</center></th>
                    <th><center>Prix de Vente</center></th>
                </tr>
            </thead>
            <tbody style="color:black;">
                <?php foreach ($data as $row){ ?>
                <tr>
                    <td><center><?php echo ucwords($row['nom']); ?></center></td>
                    <td><center><?php echo ucwords($row['societe']); ?></center></td>
                    <td><center><?php echo date("d/m/Y", strtotime($row['date_vente'])); ?></center></td>
                    <td><center><?php echo ucwords($row['N_bon']); ?></center></td>
                    <td><center><?php echo ucwords($row['reference']); ?></center></td>
                    <td><center><?php echo ucwords($row['N_serie']); ?></center></td>
                    <td><center><?php echo number_format($row['prix_vente'],2,',',''); ?></center></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
        <?php
    }else{
        //echo $condition;
        $req1 = "SELECT nom, societe, date_vente, N_bon, reference, N_serie, prix_vente FROM (SELECT nom, societe, CAST( D.date_vente AS DATE ) AS date_vente,
                D.N_bon, S.reference, S.N_serie, D.prix_vente FROM 
                vente_details D inner join client C on D.id_client = C.id inner join Stock S on D.N_serie = S.N_serie WHERE $condition LIKE '%$rech%'
                UNION
                SELECT nom, societe, CAST( V.date_vente AS DATE ) AS date_vente, V.N_bon, A.reference, CAST( V.quantite AS VARCHAR(20)) 
                AS N_serie, V.prix_vente FROM vente_article V inner join client C on V.id_client = C.id 
                inner join articles A on A.id = V.id_articles WHERE $condition LIKE '%$rech%')X";
        $data = $pdo->query($req1);
        //echo $req1;
        ?>
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th><center>Nom</center></th>
                    <th><center>Société</center></th>
                    <th><center>Date de Vente</center></th>
                    <th><center>N Bon</center></th>
                    <th><center>Reference</center></th>
                    <th><center>N°Série / QTE</center></th>
                    <th><center>Prix de Vente</center></th>
                </tr>
            </thead>
            <tbody style="color:black;">
                <?php foreach ($data as $row){ ?>
                <tr>
                    <td><center><?php echo ucwords($row['nom']); ?></center></td>
                    <td><center><?php echo ucwords($row['societe']); ?></center></td>
                    <td><center><?php echo date("d/m/Y", strtotime($row['date_vente'])); ?></center></td>
                    <td><center><?php echo ucwords($row['N_bon']); ?></center></td>
                    <td><center><?php echo ucwords($row['reference']); ?></center></td>
                    <td><center><?php echo ucwords($row['N_serie']); ?></center></td>
                    <td><center><?php echo number_format($row['prix_vente'],2,',',' '); ?></center></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
        <?php
    }
}else if($etat == 'enstock'){
    if($condition == 'n_serie'){
        $condition = "N_serie";
        $req = "SELECT type, reference, N_serie, date_entre, etat_vente, N_bon, fournisseur FROM stock 
                Where etat_vente ='Non' AND $condition LIKE '%$rech%' ORDER BY date_entre DESC";
        $data1 = $pdo->query($req);
        ?>
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th><center>Type</center></th>
                    <th><center>Référence</center></th>
                    <th><center>N° Série</center></th>
                    <th><center>Date d'Entrée</center></th>
                    <th><center>Etat de Vente</center></th>
                    <th><center>N° Bon</center></th>
                    <th><center>Fournisseur</center></th>
                </tr>
            </thead>
            <tbody style="color:black;">
                <?php foreach ($data1 as $row){ ?>
                <tr>
                    <td><center><?php echo ucwords($row['type']); ?></center></td>
                    <td><center><?php echo ucwords($row['reference']); ?></center></td>
                    <td><center><?php echo ucwords($row['N_serie']); ?></center></td>
                    <td><center><?php echo date("d/m/Y", strtotime($row['date_entre'])); ?></center></td>
                    <td><center><?php echo ucwords($row['etat_vente']); ?></center></td>
                    <td><center><?php echo ucwords($row['N_bon']); ?></center></td>
                    <td><center><?php echo ucwords($row['fournisseur']); ?></center></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
        <?php
        
    }
    else if($condition == "reference"){
        $req = "SELECT * FROM (SELECT type, reference, COUNT(N_serie) as quantite FROM stock WHERE etat_vente = 'Non' GROUP BY type, reference 
                UNION 
                SELECT type, reference, quantite FROM articles)X WHERE X.reference LIKE '%$rech%' ORDER BY X.reference DESC";
        $data = $pdo->query($req);
        
        ?>
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th><center>Type</center></th>
                    <th><center>Référence</center></th>
                    <th><center>Quantité</center></th>
                </tr>
            </thead>
            <tbody style="color:black;">
                <?php foreach ($data as $row){ ?>
                <tr>
                    <td><center><?php echo ucwords($row['type']); ?></center></td>
                    <td><center><?php echo ucwords($row['reference']); ?></center></td>
                    <td><center><?php echo $row['quantite']; ?></center></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
        <?php
    }else if($condition == "fournisseur"){
        $req = "SELECT type, reference, N_serie, date_entre, etat_vente, N_bon, fournisseur FROM stock 
                WHERE fournisseur LIKE '%$rech%' GROUP BY date_entre desc";
        $data = $pdo->query($req);
        ?>
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th><center>Type</center></th>
                    <th><center>Référence</center></th>
                    <th><center>N° Série</center></th>
                    <th><center>Date d'Entrée</center></th>
                    <th><center>Etat de Vente</center></th>
                    <th><center>N° Bon</center></th>
                    <th><center>Fournisseur</center></th>
                </tr>
            </thead>
            <tbody style="color:black;">
                <?php foreach ($data as $row){ ?>
                <tr>
                    <td><center><?php echo ucwords($row['type']); ?></center></td>
                    <td><center><?php echo ucwords($row['reference']); ?></center></td>
                    <td><center><?php echo ucwords($row['N_serie']); ?></center></td>
                    <td><center><?php echo date("d/m/Y", strtotime($row['date_entre'])); ?></center></td>
                    <td><center><?php echo ucwords($row['etat_vente']); ?></center></td>
                    <td><center><?php echo ucwords($row['N_bon']); ?></center></td>
                    <td><center><?php echo ucwords($row['fournisseur']); ?></center></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
        <?php
    }
}
    
?>
