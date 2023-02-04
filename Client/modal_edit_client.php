<?php
$id = $_REQUEST['id'];
// echo $id;

require '../DataSet/db.php';

$client_info = "SELECT * FROM client WHERE id = $id";
$inf = $pdo->query($client_info);

foreach ($inf as $row) { ?>
			<button type="button" class="btn btn-light close" style="float:right;" data-dismiss="modal"><i class="fas fa-times"></i></button><br>
                <div class="row p-2">
                    <div class="col-md-2"></div>
                    <div class="col-md-3 p-1"><label for="edit_nom">Nom :</label></div>
                    <div class="col-md-6"><input type="text" class="form-control" id="edit_nom" value="<?php echo($row['nom']);?>"></div>
                </div>
                <div class="row p-2">
                    <div class="col-md-2"></div>
                    <div class="col-md-3 p-1"><label for="edit_societe">Société :</label></div>
                    <div class="col-md-6"><input type="text" class="form-control" id="edit_societe" value="<?php echo($row['societe']);?>"></div>
                </div>
                <div class="row p-3">
                    <div class="col-md-2"></div>
                    <div class="col-md-3 p-1"><label for="edit_phone">Telephone :</label></div>
                    <div class="col-md-6"><input type="text" class="form-control" id="edit_phone" value="<?php echo($row['gsm']);?>"></div>
                </div>
                <div class="row p-3">
                    <div class="col-md-2"></div>
                    <div class="col-md-3 p-1"><label for="edit_email">Email :</label></div>
                    <div class="col-md-6"><input type="email" class="form-control" id="edit_email" value="<?php echo($row['email']);?>"></div>
                </div>
                <div class="row p-3">
                    <div class="col-md-2"></div>
                    <div class="col-md-3 p-1"><label for="edit_adresse">Adresse :</label></div>
                    <div class="col-md-6"><input type="text" class="form-control" id="edit_adresse" value="<?php echo($row['adresse']);?>"></div>
                </div>
                <div class="d-flex justify-content-center">
                    <button class="btn btn-space btn-success" id="edit_btn" onclick="edit_client(<?php echo $row['id']; ?>)">Valider</button>
                </div>
		<?php } ?>

<script>
	function edit_client(id){
		var nom = $('#edit_nom').val();
		var societe = $('#edit_societe').val();
		var gsm = $('#edit_phone').val();
		var email = $('#edit_email').val();
    	var adresse = $('#edit_adresse').val();
        if (nom == '' || societe == '') {
            alert("S'il Vous Plaît Remplir Nom et Société!!");
        }else{
            $('#edit_btn').prop('disabled', true);
            $('#modal_edit_client').modal('hide');
            $.ajax({
                type: "POST",
                url: 'edit_client.php',
                data: {id:id,nom:nom,societe:societe,gsm:gsm,email:email,adresse:adresse},
                success:function(msg) {
                    alert_success('Modification Effectué Avec Succées');
                    setTimeout(function() {
                        window.location.href="Client.php";
                    }, 750);
                }
            });
        }
	}
</script>