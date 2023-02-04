<?php
session_start();
if (!isset($_SESSION['role'])) {
  header("location:../index.php");
}else{
include "../DataSet/db.php";
$sql = "SELECT DISTINCT reference, id, prix FROM reference";
$data = $pdo->query($sql);
include '../includes/header.php';
include '../includes/sidebar.php';
include '../includes/topbar.php';
?>
    <!-------------------------------------------- modifier prix modal open -------------------------------------------->

    <div id="modifier_prix" tabindex="-1" role="dialog" class="modal fade colored-header colored-header-dark">
        <div class="modal-dialog modal-sm modal-dialog-centered custom-width">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="btn btn-light close" style="float:right;" data-dismiss="modal"><i class="fas fa-times"></i></button><br>
                    <span id="modal_modification">
                        
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!--------------------------------------------- modifier prix modal close ----------------------------------------->
    <!-------------------------------------------- supprimer reference modal open -------------------------------------------->

    <div id="supprimer_reference" tabindex="-1" role="dialog" class="modal fade colored-header colored-header-dark">
        <div class="modal-dialog modal-sm modal-dialog-centered custom-width">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="btn btn-light close" style="float:right;" data-dismiss="modal"><i class="fas fa-times"></i></button><br>
                    <span id="modal_supression">

                    </span>
                </div>
            </div>
        </div>
    </div>

    <!--------------------------------------------- supprimer reference modal close ----------------------------------------->

    <!-------------------------------------------- ajouter reference modal open -------------------------------------------->

    <div id="ajouter_reference" tabindex="-1" role="dialog" class="modal fade colored-header colored-header-dark">
        <div class="modal-dialog  modal-dialog-centered custom-width">
            <div class="modal-content ">
                <div class="modal-body ui-front">
                    <button type="button" class="btn btn-light close" style="float:right;" data-dismiss="modal"><i class="fas fa-times"></i></button><br>
                    <div class="row">
                        <div class="col-md-3 p-1"><label for="reference">Réference : </label></div>
                        <div class="col-md-7"><input type="text" class="form-control" id="reference"></div>
                    </div>
                    <div class="row p-3">
                        <div class="col-md-2"></div>
                        <div class="col-md-2 px-2 p-1"><label for="prix">Prix : </label></div>
                        <div class="col-md-4"><input type="text" class="form-control" id="prix"></div>
                    </div>
                    <div class="d-flex justify-content-center">
                        <button class="btn btn-space btn-success" onclick="ajouter_reference()">Valider</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--------------------------------------------- ajouter reference modal close ----------------------------------------->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Liste des Réferences</h6>
        <a href="" class="btn btn-primary btn-md float-right" data-target="#ajouter_reference" data-toggle="modal"><i class="fas fa-plus-circle"></i> Nouveau Référence</a> 
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th><center>#</center></th>
                        <th><center>Référence</center></th>
                        <th><center>Prix d'Achat</center></th>
                        <th><center>Action</center></th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($data as $row){ ?>
                    <tr>
                        <td><center><?php echo($row['id']);?></center></td>
                        <td><center><?php echo($row['reference']);?></center></td>
                        <td><center><?php echo number_format($row['prix'],2,","," ");?></center></td>
                        <td class="col-md-2"><center>
                            <button title="Modifier le prix" data-toggle="modal" data-target="#modifier_prix" class="btn btn-sm btn-warning"
                                onclick="modifier_prix('<?php echo($row['reference']);?>')">
                            <i class="fas fa-edit"></i></button>
                            <button title="Supprimer le reference" data-toggle="modal" data-target="#supprimer_reference" class="btn btn-sm btn-danger"
                                onclick="supprimer_reference('<?php echo $row['reference']; ?>');">
                                <i class="fas fa-times-circle"></i></button>
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
$(function () {
    $("#reference").autocomplete({
        source: 'autocomplete_ref.php',
        delay: 30
    });
});
function ajouter_reference(){
    var reference = $('#reference').val();
    var prix = $('#prix').val();
    if(reference == '' || prix == ''){
        alert_error('SVP Remplir Tous les Champs');
    }else{
        $.ajax({
            type: "POST",
            url: 'ajouter_reference.php',
            data: {reference:reference,prix:prix},
            success:function(msg) {
                alert_success(msg);
                setTimeout(function() {
                    window.location.href="changer_prix.php";
                }, 750);
            }
        });
    }
}
function supprimer_reference(ref){
    $.ajax({
        type: "POST",
        url: 'modal_supression.php',
        data: {ref:ref},
        success:function(msg) {
            $('#modal_supression').html(msg);
        }
    });
}
function modifier_prix(ref){
    $.ajax({
        type: "POST",
        url: 'modal_modification.php',
        data: {ref:ref},
        success:function(msg) {
            $('#modal_modification').html(msg);
        }
    });
}
</script>
<?php }
?>