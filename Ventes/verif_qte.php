<?php
        require '../DataSet/db.php'; 
        $ref = $_POST['ref'];
        $qte = $_POST['qte'];
        $sql="SELECT quantite FROM articles WHERE reference='$ref'";
        $req=$pdo->query($sql);
        $row=$req->fetch(PDO::FETCH_ASSOC);
        if ($qte > $row['quantite']){
            echo "Vérifier la Quantité!!";
        }
?>