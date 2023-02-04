<?php
session_start();
if (!isset($_SESSION['role'])) {
  header("location:../index.php");
}else{
include "../DataSet/db.php";
include '../includes/header.php';
include '../includes/sidebar.php';
include '../includes/topbar.php';
?>
<div id="modal_reference_prix" tabindex="-1" role="dialog" class="modal fade colored-header colored-header-dark">
    <div class="modal-dialog modal-dialog-centered custom-width">
        <div class="modal-content">
            <div class="modal-body justify-content-center">
                <button type="button" class="btn btn-light close mb-2" style="float:right;" data-dismiss="modal"><i class="fas fa-times"></i></button><br>
                <div class="col-md table-responsive justify-content-center"id='reference_details'>

                </div>
            </div>
        </div>
    </div>
</div>
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <div class="card bg-gray-200">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12 d-flex justify-content-center">
                        <fieldset class="border border-dark rounded mb-2 p-2">
                            <legend class="float-none w-auto p-2">Recherche Par:</legend>
                            <div class="row">
                                <div class="col ml-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="critere" value="reference" id="reference" checked>
                                        <label class="form-check-label" for="reference">
                                            Référence
                                        </label>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="critere" value="type" id="type">
                                        <label class="form-check-label" for="type">
                                            Type
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <input type="text" class="form-control" id="rech" value="">    
                        </fieldset>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive" id="table">
            
        </div>
    </div>
</div>
<?php include '../includes/footer.php'; ?>
<script>
$(function(){
    $("#rech").on('keyup keydown', function(event) { 
        var reference = document.getElementById("reference");
        var type = document.getElementById("type");
        var rech = $('#rech').val();
        var condition = '';
        if (reference.checked == true) {
            condition = 'reference';
        }else if (type.checked == true) {
            condition = 'type';
        }
        $.ajax({
            type: "POST",
            url: 'valide_recherche.php',
            data: {rech:rech,condition:condition},
            success:function(msg) {
                $('#table').html(msg);
                $(document).ready(function() {
                    $('#dataTable').DataTable( {
                        "language": {
                            "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/French.json"
                        }
                    });
                });
            }
        });
    });
});
</script>
<?php } ?>