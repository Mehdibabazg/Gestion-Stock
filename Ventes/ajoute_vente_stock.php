<?php
    require '../DataSet/db.php';
    $id_client=$_POST['id']; 
    $n_bon = $_POST['n_bon'];
    $prixV = $_POST['prix_vente'];
    $N_serie = $_POST['n_serie'];
    $dateV = $_POST['date_vente'];
    if (!empty($n_bon) | !empty($prixV) | !empty($N_serie)) {
        $req = $pdo->query("SELECT N_serie, etat_vente FROM stock WHERE N_serie = '$N_serie'");
        $resultat=$req->fetch(PDO::FETCH_ASSOC);
        $req->closeCursor();
        $count = $req->rowCount();
        if($count>0){
            if ($resultat['etat_vente']=='Oui') {
                echo "Proudit est Vendu Déja";
            }else{
                $query_prix = $pdo->query("SELECT prix FROM reference R INNER JOIN stock S ON S.reference = R.reference WHERE N_serie = '$N_serie'");
                $prix=$query_prix->fetch(PDO::FETCH_ASSOC);
                $prix_ht = $prix['prix'];
                $prix_ttc = $prix['prix']*1.2;
                if ($prixV > $prix_ttc) {
                    $vente_info = "INSERT INTO vente_details (id_client, N_serie, N_bon, prix_vente, date_vente, facture, bl) VALUES ('$id_client', '$N_serie', '$n_bon', '$prixV', '$dateV', 'Non', 'Non')";
                    $inf = $pdo->query($vente_info);
                    $stock_info = "UPDATE stock SET N_bon = '$n_bon', etat_vente = 'Oui', date_vente = '$dateV', prix_vente = '$prixV' WHERE N_serie = '$N_serie'";
                    $inf = $pdo->query($stock_info);
                    if ($vente_info && $inf) {
                        $result = $pdo->query("SELECT date_vente, reference, quantite, prix_vente, total FROM (
                        SELECT COUNT(reference) as quantite, D.N_bon, S.reference AS reference, ROUND(D.prix_vente, 2) as prix_vente, D.date_vente, 
                        ROUND(count(S.reference)*D.prix_vente, 2) as total from vente_details D 
                        inner join stock S on D.n_serie=S.n_serie GROUP BY S.reference, D.prix_vente
                        UNION
                        select sum(V.quantite) as quantite, V.N_bon, reference, ROUND(avg(prix_vente), 2) as prix_vente, V.date_vente, 
                        ROUND(sum((prix_vente*V.quantite)), 2) AS total from vente_article V
                        inner join articles A on A.id = V.id_articles GROUP BY A.reference, V.prix_vente) X where N_bon='$n_bon'");?>
                        <div class="table-responsive">
                            <table class="table table-bordered" width="50%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th><center>Date de Vente</center></th>
                                        <th><center>Quantite</center></th>
                                        <th><center>Référence</center></th>
                                        <th><center>Prix de Vente</center></th>
                                        <th><center>Total</center></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($result as $row){ ?>
                                    <tr>
                                        <td><center><?php echo($row['date_vente']);  ?></center></td>
                                        <td><center><?php echo($row['quantite']);  ?></center></td>
                                        <td><center><?php echo($row['reference']);  ?></center></td>
                                        <td><center><?php echo number_format($row['prix_vente'],2,',',' ');?></center></td>
                                        <td><center><?php echo number_format($row['total'],2,',',' ');?></center></td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    <?php }
                }else{
                    echo "Vérifier le Prix!!";
                }
            }
        }else{
            echo "N° Série n'exsite pas dans le Stock";
        }
    }else{
        echo "Remplis Tous les Champs S'il Vous Plait !!!";
    }
?>