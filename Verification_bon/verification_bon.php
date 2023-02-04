<?php
session_start();
if (!isset($_SESSION['role'])) {
  header("location:../index.php");
}else{
include "../DataSet/db.php";
$sql = "SELECT date_vente, societe, N_bon, sum(B.total) AS 'Total', facture FROM (
    SELECT DISTINCT (D.date_vente), societe, S.N_bon, sum(D.prix_vente) AS total, facture FROM vente_details D 
    INNER JOIN stock S on D.N_serie = S.N_serie INNER JOIN client C on D.id_client = C.id
    GROUP BY D.date_vente, S.N_bon 
    UNION 
    SELECT DISTINCT (V.date_vente), societe, V.N_bon, sum(V.prix_vente * V.quantite) AS total, facture FROM vente_article V 
    INNER JOIN client C ON c.id = V.id_client 
    GROUP BY V.date_vente, N_bon) B GROUP BY B.date_vente, B.N_bon order by B.date_vente DESC";
$data = $pdo->query($sql);
include '../includes/header.php';
include '../includes/sidebar.php';
include '../includes/topbar.php';
?>
    <!-------------------------------------------- BON details modal open -------------------------------------------->
<div id="modal_bon_details" tabindex="-1" role="dialog" class="modal fade colored-header colored-header-dark">
    <div class="modal-dialog modal-dialog-centered custom-width">
        <div class="modal-content">
            <div class="modal-body justify-content-center">
                <button type="button" class="btn btn-light close mb-2" style="float:right;" data-dismiss="modal"><i class="fas fa-times"></i></button><br>
                <div class="col-md table-responsive justify-content-center">
                    <table class="table table-bordered table-condensed table-hover">
                        <thead>
                            <tr>
                                <th><center>Référence</center></th>
                                <th><center>Quantité</center></th>
                                <th><center>Prix de Vente</center></th>
                            </tr>
                        </thead>
                        <tbody id="details_bon">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
    <!--------------------------------------------- BON details modal close ----------------------------------------->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary mb-2">Liste des Bon</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th><center>Date de vente</center></th>
                        <th><center>Société</center></th>
                        <th><center>N°Bon</center></th>
                        <th><center>Total</center></th>
                        <th><center>Facture</center></th>
                        <th><center>Affichage</center></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        foreach ($data as $row){ ?>
                    <tr>
                        <td><center><?php echo date("d/m/Y", strtotime($row['date_vente']));?></center></td>
                        <td><center><?php echo($row['societe']);?></center></td>
                        <td><center><?php echo($row['N_bon']);?></center></td>
                        <td><center><?php echo number_format($row['Total'],2,","," ");?></center></td>
                        <td><center><?php echo($row['facture']);?></center></td>
                        <td><center>
                            <button title="Afficher les details" data-toggle="modal" data-target="#modal_bon_details" class="btn btn-space btn-secondary"
                                onclick="open_model_bon('<?php echo $row['N_bon']; ?>');">
                            <i class="far fa-eye"></i></button>
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
        function open_model_bon(n_bon) {
            $.ajax({
                type: "POST",
                url: '../Client/details_bon.php',
                data: {n_bon:n_bon},
                success:function(msg) {
                    $('#details_bon').html(msg);
                }
            });
        }
</script>
<?php } ?>