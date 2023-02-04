<?php
session_start();
if (!isset($_SESSION['role'])) {
  header("location:../index.php");
}else{
include "../DataSet/db.php";
$sql = "SELECT * FROM caisse ORDER BY id DESC";
$data = $pdo->query($sql);
$sql1 = "SELECT ROUND(SUM(montant), 2) AS total FROM caisse";
$data1 = $pdo->query($sql1);
$resultat=$data1->fetch(PDO::FETCH_ASSOC);

include '../includes/header.php';
include '../includes/sidebar.php';
include '../includes/topbar.php';
?>
        <!-- Modal EDIT Stock OPEN -->
        <div id="modal_edit_caisse" tabindex="-1" role="dialog" class="modal fade colored-header colored-header-dark">
            <div class="modal-dialog modal-dialog-centered custom-width">
                <div class="modal-content">
                    <div class="modal-body ui-front justify-content-center">
                        <span id="modal_edit"></span>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal EDIT Stock CLOSE -->

        <!-- Modal DELETE Stock OPEN -->
        <div id="modal_delete_caisse" tabindex="-1" role="dialog" class="modal fade colored-header colored-header-dark">
            <div class="modal-dialog modal-dialog-centered custom-width">
                <div class="modal-content">
                    <div class="modal-body ui-front justify-content-center">
                        <span id="modal_delete"></span>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal DELETE Stock CLOSE -->

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <div class="card bg-gray-200">
            <div class="card">
                <div class="card-header" role="button" id="div_show">
                    <h6 class="text-center font-weight-bold text-primary">
                        <i class="fas fa-search"></i> Recherche Par Date
                        <i class="fas fa-angle-double-down float-right mt-2"  id='show'></i>
                    </h6>
                </div>
                <div class="card-body" id="recherche" style="display:none;">
                    <div class="row pb-2 d-flex justify-content-center">
                        <label class="form-label p-2" for="date">Date</label>
                        <div class="col-xs-3"><input type="text" name="dates" class="form-control" id="dates"></div>
                    </div>
                    <div class="container-fluid table-responsive">
                        <table class="table table-sm table-bordered" id="result_rech">
                            <thead>
                                <tr>
                                    <th><center>Nature</center></th>
                                    <th><center>Montant</center></th>
                                </tr>
                            </thead>
                        </table>
                    </div>

                </div>
            </div>
            <div class="card-header mt-2">
                    <h6 class="text-center font-weight-bold text-primary">
                        <i class="fas fa-keyboard"></i> Saisir la Caisse
                    </h6>
                </div>
            <div class="container-fluid">
                <div class="p-2 row">
                    <div class="row p-2">
                        <label class="form-label p-2" for="date">Date:</label>
                        <div class="col-lg-9"><input type="date" class="form-control" id="date" value="<?php echo date("Y-m-d");?>"></div>
                    </div>
                    <div class="col"></div>
                    <div class="col-lg-3 rounded">
                        <input type="text" class="form-control float-right" value="<?php echo number_format($resultat['total'],2,",","");?>" disabled>
                    </div>
                </div>
                <div class="p-2 row">
                    <label class="form-label p-2" for="objet">Objet:</label>
                    <div class="col-lg-9"><input type="text" class="form-control" id="objet"></div>
                </div>
                <div class="p-2 row">
                    <label class="form-label p-2" for="nature">Nature:</label>
                    <div class="col-lg-2">
                        <input type="text" class="form-control" id="nature">
                    </div>
                    <label class="form-label p-2" for="montant">Montant : </label>
                    <div class="col-lg-3">
                        <input type="number" class="form-control" id="montant">
                    </div>
                    <div class="col float-right">
                        <button type="button" class="btn btn-success" onclick="valider();">Valider</button>
                    </div>
                </div>
            </div>
        </div>
            <h6 class="mt-3 text-center font-weight-bold text-primary">Liste des Objets</h6>
            <a href="exportCaisse.php" class="btn btn-sm btn-success"><i class="fas fa-file-export"></i> Exporter</a>
            <form method="post" id="import_excel_form" class="form-group col-6 mt-1">
                <table>
                    <tr>
                        <td><input type="file" class="input-group-text" name="import_excel" /></td>
                        <td><input type="submit" name="import" id="import" class="btn btn-primary ml-1" value="Import" /></td>
                    </tr>
                </table>
            </form>
        <div class="card-body">
            <div class="table-responsive" id="caisse_list">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th width='2%'>#</th>
                            <th>Date</th>
                            <th>Objet</th>
                            <th>Nature</th>
                            <th>Montant</th>
                            <th width='10%'>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        foreach ($data as $row){ ?>
                        
                            <tr>
                                <td width='2%'><center><?php echo $row['id'];?></center></td>
                                <td><center><?php echo date("d/m/Y", strtotime($row['date']));?></center></td>
                                <td><center><?php echo $row['objet'];?></center></td>
                                <td><center><?php echo $row['nature'];?></center></td>
                                <td><center><?php echo number_format($row['montant'],2,","," ");?></center></td>
                                <td width='10%'><center>
                                        <button data-toggle="modal" data-target="#modal_edit_caisse" 
                                            class="btn btn-sm rounded btn-warning" onclick="modal_edit_caisse(<?php echo $row['id']; ?>);">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button data-toggle="modal" data-target="#modal_delete_caisse" 
                                            class="btn btn-sm rounded btn-danger" onclick="modal_delete_caisse(<?php echo $row['id']; ?>);">
                                            <i class="fas fa-times-circle"></i>
                                        </button> 
                                    </center>
                                </td> 
                            </tr>
                        <?php } ?>
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php include '../includes/footer.php'; ?>
<script>
$(function () {
    $("#nature").autocomplete({
        source: 'autocomplete_nature.php',
        delay: 30
    });
});
function valider(){
    var date = $("#date").val();
    var objet = $("#objet").val();
    var montant = $("#montant").val();
    var nature = $("#nature").val();
    if (objet == '' || date == '' || montant == '' || nature == '') {
        alert_error('Remplis Tous Les Champs SVP');
    }else{
        $.ajax({
            type: "POST",
            url: 'valide_caisse.php',
            data: {objet:objet,date:date,montant:montant,nature:nature},
            success:function(msg) {
                if (msg = 'Enregistrement Effectué') {
                    alert_success(msg);
                    setTimeout(function() {
                        window.location.href="Caisse.php";
                    }, 750);
                }else if (msg = 'false') {
                    alert_error("Une erreur c'est Produite !! Actualiser la Page S'il Vous Plaît.");
                }
            }
        });
    }
}
function modal_edit_caisse(id){
        $.ajax({
            type: "POST",
            url: 'modal_edit_caisse.php',
            data: {id:id},
            success:function(msg) {
                $('#modal_edit').html(msg);
            }
        });
    }
    function modal_delete_caisse(id){
        $.ajax({
            type: "POST",
            url: 'modal_delete_caisse.php',
            data: {id:id},
            success:function(msg) {
                $('#modal_delete').html(msg);
            }
        });
    }
$('#div_show').click(function() {
    if ($('#recherche').css('display') == 'none') {
        $('#recherche').toggle('slow');
        $("#show").removeClass("fa-angle-double-down").addClass("fa-angle-double-up");
    }else{
        $('#recherche').hide(500)
        $("#show").removeClass("fa-angle-double-up").addClass("fa-angle-double-down");
    }
});
$('input[name="dates"]').on('apply.daterangepicker', function (ev, picker) {
    var msg = $('#dates').val();
    var date = msg.split("-");
    let date_start = date[0].trim().split("/").reverse().join("-");
    let date_end = date[1].trim().split("/").reverse().join("-");
    $.ajax({
        type: "POST",
        url: 'rech_caisse.php',
        data: {date_start:date_start,date_end:date_end},
        success: function(msg) {
            $('#result_rech').html(msg);
        }
    });
});
$(document).ready(function(){
    $('#import_excel_form').on('submit', function(event){
        event.preventDefault();
        $.ajax({
            url:"importCaisse.php",
            method:"POST",
            data:new FormData(this),
            contentType:false,
            cache:false,
            processData:false,
            beforeSend:function(){
                $('#import').attr('disabled', 'disabled');
                $('#import').val('Importing...');
            },
            success:function(data){
                if(data == 'Données importées avec succès'){
                    alert_success(data);
                    setTimeout(function() {window.location.reload();}, 750);
                }else{
                    alert_error(data);
                    $('#import_excel_form')[0].reset();
                    $('#import').attr('disabled', false);
                    $('#import').val('Import');
                }
            }
        })
    });
});
</script>
<?php }
?>