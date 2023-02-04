<?php
        require '../DataSet/db.php';
        $id_client=$_POST['id']; 
        $ref = $_POST['ref'];
        $sql="SELECT id, quantite, prix_achat FROM articles WHERE reference='$ref'";
        $req=$pdo->query($sql);
        $row=$req->fetch(PDO::FETCH_ASSOC);
        $id_article = $row['id'];
        $n_bon = $_POST['bon'];
        $qte = $_POST['qte'];
        $prixV = $_POST['prixV'];
        $dateV = $_POST['dateV'];
        if ($qte> $row['quantite']){
                echo "Vérifier la Quantité!!";
        }elseif($prixV < $row['prix_achat']*1.2) {
                echo "Vérifier le Prix!!";
        }else{
        $vente_info = "INSERT INTO vente_article (id_client, id_articles, N_bon, quantite, prix_vente, date_vente, facture, bl) VALUES ('$id_client', '$id_article', '$n_bon', '$qte', '$prixV', '$dateV', 'Non', 'Non')";
        $vente = $pdo->query($vente_info);
        $article_info = "UPDATE articles SET quantite = quantite - $qte WHERE id = $id_article";
        $inf = $pdo->query($article_info);
        if ($vente && $inf) {
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

}

?>