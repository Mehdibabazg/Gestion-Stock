<?php
session_start();
require '../DataSet/db.php';
$reference=$_POST['reference'];

$query = $pdo->query("SELECT prix as prix_achat_ht, prix*1.2 as prix_achat_ttc, prix*0.15+prix as prix_installateur_ht, 
                            (prix*0.15+prix)*1.2 as prix_installateur_ttc, prix*0.40+prix as prix_public_ht, 
                            (prix*0.40+prix)*1.2 as prix_public_ttc FROM reference WHERE reference = '$reference'");
?>
<table class="table table-bordered table-condensed table-hover">
    <thead>
        <tr>
            <td>&nbsp;</td>
            <td>Prix Achat</td>
            <td>Prix Installateur</td>
            <td>Prix Public</td>
        </tr>
        <tr>
            <td>Prix HT</td>
            <?php foreach($query as $prix){ ?>
            <td><?php echo sprintf('%0.2f', $prix['prix_achat_ht']); ?></td>
            <td><?php echo sprintf('%0.2f', $prix['prix_installateur_ht']); ?></td>
            <td><?php echo sprintf('%0.2f', $prix['prix_public_ht']); ?></td>
        </tr>
        <tr>
            <td>Prix TTC</td>
            <td><?php echo sprintf('%0.2f', $prix['prix_achat_ttc']); ?></td>
            <td><?php echo sprintf('%0.2f', $prix['prix_installateur_ttc']); ?></td>
            <td><?php echo sprintf('%0.2f', $prix['prix_public_ttc']); ?></td>
        <?php } ?>
        </tr>
    </thead>
</table>