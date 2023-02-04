<?php
    require '../DataSet/db.php';
    $N_bon = $_POST['n_bon'];
    $sql = "SELECT * FROM(
            SELECT DISTINCT(reference), count(S.N_serie) AS quantite, D.prix_vente FROM vente_details D 
            INNER JOIN stock S on D.N_serie=S.N_serie WHERE D.N_bon = '$N_bon' GROUP BY reference
            UNION 
            SELECT DISTINCT(reference), V.quantite ,prix_vente FROM vente_article V
            INNER JOIN articles A on A.id = V.id_articles WHERE N_bon = '$N_bon') B
            GROUP BY reference";
    $data = $pdo->query($sql);
?>

                <?php
                    foreach ($data as $row){ ?>
                <tr>
                    <td><center><?php echo($row['reference']);?></center></td>
                    <td><center><?php echo($row['quantite']);?></center></td>
                    <td><center><?php echo sprintf('%0.2f', $row['prix_vente']);?></center></td>
                
                </tr>
                <?php   } ?>
            