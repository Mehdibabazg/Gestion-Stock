<?php
session_start();
if (!isset($_SESSION['role'])) {
  header("location:../index.php");
}else{
include "../DataSet/db.php";
$sql = "SELECT * FROM client ORDER BY id DESC";
$data = $pdo->query($sql);
include '../includes/header.php';
include '../includes/sidebar.php';
include '../includes/topbar.php';
?>
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Liste des Clients</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th><center>Id</center></th>
                        <th><center>Nom</center></th>
                        <th><center>Societe</center></th>
                        <th><center>Téléphone</center></th>
                        <th><center>Email</center></th>
                        <th><center>Adresse</center></th>
                        <th><center>Action</center></th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    foreach ($data as $row){ ?>
                    <tr>
                        <td><center><?php echo($row['id']); ?></center></td>
                        <td><center><?php echo ucwords($row['nom']); ?></center></td>
                        <td><center><?php echo ucwords($row['societe']); ?></center></td>
                        <td><center><?php echo ucwords($row['gsm']); ?></center></td>
                        <td><center><?php echo ucwords($row['email']); ?></center></td>
                        <td><center><?php echo ucwords($row['adresse']); ?></center></td>
                        <td class="col-md-2"><center>
                        <a href="open_vente_details.php?id_client=<?php echo($row['id']);?>"
                            class="btn btn-sm btn-success"><i class="fas fa-cart-plus"></i></a>
                        </center></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php include '../includes/footer.php'; ?>
<script>
   function open_vente_model(id)
{
  $.ajax({
    type: "POST",
    url: 'open_vente_details.php',
    data: {id:id},
    success:function(msg) {
      $('#vente').html(msg);
    }
  });
} 
</script>
<?php }
?>