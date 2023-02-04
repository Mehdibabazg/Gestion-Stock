<?php
session_start();
if (!isset($_SESSION['role'])) {
  header("location:../index.php");
}else{
include "../DataSet/db.php";
$sql = "SELECT date_devis, X.num_devis, societe, SUM(Total) AS Total FROM (
        SELECT D.num_devis, date_devis, societe, (quantite*prix_ttc) AS Total FROM devis D 
        INNER JOIN client C on C.id = D.id_client 
        INNER JOIN devis_details V on V.num_devis = D.num_devis)X group by X.num_devis, X.societe";
$data = $pdo->query($sql);
$liste_societe = $pdo->query("SELECT * FROM client ORDER BY id DESC");
include '../includes/header.php';
include '../includes/sidebar.php';
include '../includes/topbar.php';
?>

<div id="transferer_devis" tabindex="-1" role="dialog" class="modal fade colored-header colored-header-dark">
    <div class="modal-dialog modal-dialog-centered custom-width">
        <div class="modal-content">
            <div class="modal-body justify-content-center">
                <button type="button" class="btn btn-light close" style="float:right;" data-dismiss="modal"><i class="fas fa-times"></i></button><br>
                <input type="text" id='num' hidden>
                <div class="row">
                    <div class="col-md-2 p-1"><label for="societe">Société : </label></div>
                    <div class="col-md-10">
                        <select class="form-control js-example-placeholder-single" id="societe">
                            <option></option>
                            <?php
                            foreach ($liste_societe as $row){ ?>
                            <option value='<?php echo $row['id'];?>'><?php echo $row['societe'];?></option>
                            <?php   } ?>
                        </select>
                    </div>
                    <div class="d-flex justify-content-center">
                        <button class="btn btn-space btn-success" onclick="ajoute_devis()">Valider</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary mb-2">Liste des Devis</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th><center>Date de devis</center></th>
                        <th><center>N° Devis</center></th>
                        <th><center>Client</center></th>
                        <th><center>Somme Total</center></th>
                        <th><center>Action</center></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        foreach ($data as $row){ ?>
                    <tr>
                        <td><center><?php echo date("d/m/Y", strtotime($row['date_devis']));?></center></td>
                        <td><center><?php echo($row['num_devis']);?></center></td>
                        <td><center><?php echo $row['societe'];?></center></td>
                        <td><center><?php echo number_format($row['Total'],2,"."," ");?></center></td>
                        <td><center>
                            <a href="devis_details.php?societe=<?php echo $row['societe'];?>&num_devis=<?php echo $row['num_devis'];?>" 
                                class="btn btn-sm btn-info"><i class="fas fa-eye"></i></a>
                            <button class="btn btn-sm btn-warning" onclick="imprimer('<?php echo $row['num_devis']; ?>','<?php echo $row['societe'];?>')">
                                <i class="fas fa-print"></i>
                            </button>
                            <button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#transferer_devis"
                                onclick="modal_transferer('<?php echo $row['num_devis']; ?>')"><i class="fas fa-recycle"></i>
                            </button>
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
function imprimer(num_devis, societe){
    $.ajax({
        type: "POST",
        url: '../pdf/maj_devis.php',
        data: {num_devis:num_devis,societe,societe},
        success:function(msg) {
            //alert(msg);
            window.open('../Files/Devis/Devis '+num_devis.replace('/','-')+' '+societe.replace(':','-')+'.pdf');
            window.location.reload();
        }
    });
}
function modal_transferer(num_devis){
    $('#num').val(num_devis);

}
function ajoute_devis(){
    <?php
        $num_devis_req = $pdo->query("CALL Inc_devis()");
        $num_devis = $num_devis_req->fetch(PDO::FETCH_ASSOC);
        $num_devis_req->closeCursor();
        $num_devis = $num_devis['num']; 
    ?>
    var num_devis = $('#num').val();
    var societe = $('#societe :selected').text();
    var id_client = $('#societe :selected').val();
    var new_num_devis = '<?php echo $num_devis; ?>';
    $.ajax({
        type: "POST",
        url: 'trans_devis.php',
        data: {num_devis:num_devis,societe,societe,id_client:id_client,new_num_devis:new_num_devis},
        success:function(msg) {
            if (msg = 'true') {
                alert_success('Transfert a été Effectué Avec Succès');
                setTimeout(function() {
                    window.location.reload();
                }, 750);
            }else{
                alert_error("Une Erreur s'est produite!! Merci d'actualiser la page")
            }
        }
    });
}



</script>
<?php }
?>