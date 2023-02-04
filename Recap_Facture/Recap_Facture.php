<?php
session_start();
if (!isset($_SESSION['role'])) {
  header("location:../index.php");
}else{
include "../DataSet/db.php";
$sql = "SELECT num_facture, date_facture, societe, Total FROM (
    SELECT F.num_facture as num_facture, date_facture, societe, mt_total as Total from vente_details D
    INNER JOIN client C on C.id = D.id_client 
    INNER JOIN facture F on D.num_facture = F.num_facture
    UNION
    SELECT F.num_facture as num_facture, date_facture, societe, mt_total as Total from vente_article V 
    INNER JOIN client C on C.id = V.id_client 
    INNER JOIN facture F on V.num_facture = F.num_facture)X";
$data = $pdo->query($sql);
include '../includes/header.php';
include '../includes/sidebar.php';
include '../includes/topbar.php';
?>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary mb-2">Liste des Factures</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th><center>N°Facture</center></th>
                        <th><center>Date Facture</center></th>
                        <th><center>Société</center></th>
                        <th><center>Total</center></th>
                        <th><center>Action</center></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        foreach ($data as $row){ ?>
                    <tr>
                        <td><center><?php echo($row['num_facture']);?></center></td>
                        <td><center><?php echo date("d/m/Y", strtotime($row['date_facture']));?></center></td>
                        <td><center><?php echo($row['societe']);?></center></td>
                        <td><center><?php echo number_format($row['Total'],2,',','');?></center></td>
                        <td><center><button class="btn btn-danger btn-sm" 
                                        onclick="imprimer('<?php echo($row['num_facture']);?>', '<?php echo($row['societe']);?>');">
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
function imprimer(num_facture, societe){
    $.ajax({
        type: "POST",
        url: '../pdf/maj_facture.php',
        data: {num_facture:num_facture,societe,societe},
        success:function(msg) {
            window.open('../Files/Facture/Facture '+num_facture.replace('/','-')+' '+societe.replace(':','-')+'.pdf');
            window.location.reload();
        }
    });
}
</script>
<?php }
?>