<?php
session_start();
if (!isset($_SESSION['role'])) {
  header("location:../index.php");
}else{
include "../DataSet/db.php";
$sql = "SELECT num_bl, date_bl, societe, Total FROM (
    SELECT B.num_bl as num_bl, date_bl, societe, mt_total as Total from vente_details D
    INNER JOIN client C on C.id = D.id_client 
    INNER JOIN bl B on D.num_bl = B.num_bl
    UNION
    SELECT B.num_bl as num_bl, date_bl, societe, mt_total as Total from vente_article V 
    INNER JOIN client C on C.id = V.id_client 
    INNER JOIN bl B on V.num_bl = B.num_bl)X";
$data = $pdo->query($sql);
include '../includes/header.php';
include '../includes/sidebar.php';
include '../includes/topbar.php';
?>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary mb-2">Liste des Bons de Livraison</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th><center>N°BL</center></th>
                        <th><center>Date BL</center></th>
                        <th><center>Société</center></th>
                        <th><center>Total</center></th>
                        <th><center>Action</center></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        foreach ($data as $row){ ?>
                    <tr>
                        <td><center><?php echo($row['num_bl']);?></center></td>
                        <td><center><?php echo date("d/m/Y", strtotime($row['date_bl']));?></center></td>
                        <td><center><?php echo($row['societe']);?></center></td>
                        <td><center><?php echo number_format($row['Total'],2,',','');?></center></td>
                        <td><center><button class="btn btn-danger btn-sm" 
                                        onclick="imprimer('<?php echo($row['num_bl']);?>', '<?php echo($row['societe']);?>');">
                                        <i class="fas fa-print"></i>
                                    </button>
                        </center></td>
                    </tr>
                    <?php   } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php include '../includes/footer.php'; ?>
<script>
function imprimer(num_bl, societe){
    $.ajax({
        type: "POST",
        url: '../pdf/maj_bl.php',
        data: {num_bl:num_bl,societe,societe},
        success:function(msg) {
            //alert(msg);
            window.open('../Files/BL/BL '+num_bl.replace('/','-')+' '+societe.replace(':','-')+'.pdf');
            window.location.reload();
        }
    });
}
</script>
<?php }
?>