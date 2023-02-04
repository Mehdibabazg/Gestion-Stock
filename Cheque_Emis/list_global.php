<?php 

require '../DataSet/db.php';

$sql = "SELECT * FROM cheques ORDER BY id DESC";
$data = $pdo->query($sql);
?>
<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
    <thead>
        <tr>
            <th><center>Select</center></th>
            <th><center>Type</center></th>
            <th><center>Numero</center></th>
            <th><center>Montant</center></th>
            <th><center>Emis</center></th>
            <th><center>Echeance</center></th>
            <th><center>Fournisseur</center></th>
            <th><center>Nature</center></th>
            <th><center>id</center></th>
        </tr>
    </thead>
    <tbody style="color:black;">
        <form name="listC" id="listC">
        <?php
            foreach ($data as $row){ ?>
        <tr>
            <td><center>
                <input class="form-check-input " type="checkbox" id="check" name="check" onclick="check_payant();"
                    value="<?php echo $row['id'];?>">
                </center>
            </td>
            <td><center><?php echo($row['type']);?></center></td>
            <td><center><?php echo($row['numero']);?></center></td>
            <td><center><?php echo number_format($row['montant'],2,","," ");?></center></td>
            <td><center><?php echo date("d/m/Y", strtotime($row['emis']));?></center></td>
            <td><center><?php echo date("d/m/Y", strtotime($row['echeance']));?></center></td>
            <td><center><?php echo($row['fournisseur']);?></center></td>
            <td><center><?php echo($row['nature']);?></center></td>
            <td><center><?php echo($row['id']);?></center></td>
        </tr>
        <?php   } ?>
        </form>
    </tbody>
</table>