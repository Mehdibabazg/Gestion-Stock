<?php
include('../DataSet/db.php');
$date_start = $_POST['date_start'];
$date_end = $_POST['date_end'];
$sql = "SELECT DISTINCT nature, SUM(montant) as total from caisse WHERE date BETWEEN '$date_start' AND '$date_end' group by nature";
$data = $pdo->query($sql);?>
<table class="table table-bordered" width="100%" cellspacing="0">
    <thead>
        <tr>
            <th><center>Nature</center></th>
            <th><center>Montant</center></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($data as $row){ ?>
            <tr>
                <td><center><?php echo $row['nature'];?></center></td>
                <td><center><?php echo number_format($row['total'],2,","," ");?></center></td>
            </tr>
        <?php } ?>
    </tbody>
</table>