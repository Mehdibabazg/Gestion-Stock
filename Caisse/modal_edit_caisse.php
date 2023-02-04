<?php
$id = $_REQUEST['id'];
// echo $id;

require '../DataSet/db.php';

$caisse_info = "SELECT * FROM caisse WHERE id = $id";
$inf = $pdo->query($caisse_info);

foreach ($inf as $row) { ?>
			<button type="button" class="btn btn-light close" style="float:right;" data-dismiss="modal"><i class="fas fa-times"></i></button><br>
                <div class="row p-2">
                    <div class="col-md-2"></div>
                    <div class="col-md-3 p-1"><label for="edit_date">Date :</label></div>
                    <div class="col-md-6"><input type="date" class="form-control" value="<?php echo $row['date']; ?>" id="edit_date"></div>
                </div>
                <div class="row p-2">
                    <div class="col-md-2"></div>
                    <div class="col-md-3 p-1"><label for="edit_objet">Objet :</label></div>
                    <div class="col-md-6"><input type="text" class="form-control"  value="<?php echo $row['objet']; ?>"  id="edit_objet"></div>
                </div>
                <div class="row p-3">
                    <div class="col-md-2"></div>
                    <div class="col-md-3 p-1"><label for="edit_nature">Nature :</label></div>
                    <div class="col-md-6"><input type="nature" class="form-control" value="<?php echo $row['nature']; ?>" id="edit_nature"></div>
                </div>
                <div class="row p-3">
                    <div class="col-md-2"></div>
                    <div class="col-md-3 p-1"><label for="edit_montant">Montant :</label></div>
                    <div class="col-md-6"><input type="number" step="0.01" value="<?php echo number_format($row['montant'],2,'.',''); ?>" class="form-control" id="edit_montant"></div>
                </div>
                <div class="d-flex justify-content-center">
                    <button class="btn btn-space btn-success" id="edit_btn" onclick="edit_caisse(<?php echo $row['id']; ?>)">Valider</button>
                </div>
		<?php } ?>

<script>
	function edit_caisse(id){
		var date = $('#edit_date').val();
		var objet = $('#edit_objet').val();
		var nature = $('#edit_nature').val();
		var montant = $('#edit_montant').val();
        if (date == '' || objet == '' || nature == '' || montant == '') {
            alert_error("S'il Vous Plait Remplis Tous les Champs!!");
        }else{
            $('#edit_btn').prop('disabled', true);
            $('#modal_edit_caisse').modal('hide');
            $.ajax({
                type: "POST",
                url: 'edit_caisse.php',
                data: {id:id,date:date,objet:objet,nature:nature,montant:montant},
                success:function(msg) {
                    if (msg = 'Modification Effectué Avec Succées') {
                        alert_success(msg);
                        setTimeout(function() {
                            window.location.href="Caisse.php";
                        }, 750);
                    }
                }
            });
        }
	}
    $(function () {
    $("#edit_nature").autocomplete({
        source: 'autocomplete_nature.php',
        delay: 30
    });
});
</script>