<?php
session_start();
if (!isset($_SESSION['role'])) {
  header("location:../index.php");
}else{
$societe = $_GET['societe'];
$num_devis = $_GET['num_devis'];
include "../DataSet/db.php";
$sql = "SELECT * FROM devis_details WHERE num_devis = '$num_devis'";
$data = $pdo->query($sql);
include '../includes/header.php';
include '../includes/sidebar.php';
include '../includes/topbar.php';
?>
<div id="modal_edit_devis" tabindex="-1" role="dialog" class="modal fade colored-header colored-header-dark">
    <div class="modal-dialog modal-dialog-centered custom-width">
        <div class="modal-content">
            <div class="modal-body ui-front justify-content-center">
                <input type="text" id='id_devis' hidden>
                <button type="button" class="btn btn-light close" style="float:right;" data-dismiss="modal"><i class="fas fa-times"></i></button><br>
                <div class="row p-2">
                    <div class="col-md-2"></div>
                    <div class="col-md-3 p-1"><label for="quantite">Quantité :</label></div>
                    <div class="col-md-6"><input type="number" class="form-control" id="quantite"></div>
                </div>
                <div class="row p-2">
                    <div class="col-md-2"></div>
                    <div class="col-md-3 p-1"><label for="prix">Prix :</label></div>
                    <div class="col-md-6"><input type="number" class="form-control" id="prix"></div>
                </div>
                <div class="d-flex justify-content-center">
                    <button class="btn btn-space btn-success" id="ajoute_btn" onclick="edit_devis()">Valider</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="modal_delete_devis" tabindex="-1" role="dialog" class="modal fade colored-header colored-header-dark">
    <div class="modal-dialog modal-dialog-centered custom-width">
        <div class="modal-content">
            <div class="modal-body ui-front justify-content-center">
                <input type="text" id='id_devis' hidden>
                <button type="button" class="btn btn-light close" style="float:right;" data-dismiss="modal"><i class="fas fa-times"></i></button><br>
                <center>
                <span class="card-subtitle">Voulez Vous Supprimer <strong id='reference'></strong> ?</span>
                <label class="control-label ">&nbsp;</label><br>
                <button class="btn btn-danger" onclick="delete_devis()">oui</button> 
                <button class="btn btn-secondary" data-dismiss="modal">Non</button>
            </div>
        </div>
    </div>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary mb-2">Devis N° <?php echo($num_devis);?> De La <?php echo($societe);?></h6>
        <a href="liste_devis.php" class="btn btn-primary btn-sm float-right"><i class="fas fa-undo mt-1"></i> Liste des Devis</a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th><center>Référence</center></th>
                        <th><center>Type</center></th>
                        <th><center>Quantité</center></th>
                        <th><center>Prix TTC</center></th>
                        <th><center>Action</center></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        foreach ($data as $row){ ?>
                    <tr>
                        <td><center><?php echo $row['reference'];?></center></td>
                        <td><center><?php echo $row['type'];?></center></td>
                        <td><center><?php echo $row['quantite'];?></center></td>
                        <td><center><?php echo number_format($row['prix_ttc'],2,"."," ");?></center></td>
                        <td><center>
                            <i role='button' class="fas fa-edit text-warning" data-toggle="modal" data-target="#modal_edit_devis"
                             onclick="edit(<?php echo $row['id'];?>,'<?php echo $row['quantite'];?>','<?php echo $row['prix_ttc'];?>')"></i>
                            <i role='button' class="fas fa-trash-alt ml-2 text-danger" data-toggle="modal" data-target="#modal_delete_devis"
                             onclick="modal_delete_devis(<?php echo $row['id'];?>,'<?php echo $row['reference'];?>')"></i>
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
function edit(id, qte, prix){
    $('#quantite').val(qte);
    $('#prix').val(prix);
    $('#id_devis').val(id);
}
function modal_delete_devis(id,ref){
    $('#id_devis').val(id);
    $('#reference').html(ref);
}
function edit_devis(){
    var qte = $('#quantite').val();
    var prix = $('#prix').val();
    var id = $('#id_devis').val();
    if (qte == '' || prix == '') {
        alert_error('Merci de Remplir les Deux Champs');
    }else{
        $.ajax({
            type: "POST",
            url: 'edit_devis.php',
            data: {id:id,qte:qte,prix:prix},
            success:function(msg) {
                if (msg = 'true') {
                    alert_success('Modification Effectué Avec Succés');
                    setTimeout(function() {
                        location.reload();
                    }, 750);
                }else{
                    alert_error("Une erreur c'est Produite !!");
                }
                
            }
        });
    }
}
function delete_devis(){
    var id = $('#id_devis').val();
    $.ajax({
        type: "POST",
        url: 'delete_devis.php',
        data: {id:id},
        success:function(msg) {
            if (msg = 'true') {
                alert_success('Suppression Effectué Avec Succés');
                setTimeout(function() {
                    location.reload();
                }, 750);
            }else{
                alert_error("Une erreur c'est Produite !!");
            }
            
        }
    });
}
</script>
<?php }
?>