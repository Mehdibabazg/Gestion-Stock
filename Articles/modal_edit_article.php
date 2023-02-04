<?php
$id = $_REQUEST['id'];
// echo $id;

require '../DataSet/db.php';

$article_info = "SELECT * FROM articles WHERE id = $id";
$inf = $pdo->query($article_info);

foreach ($inf as $row) { ?>
			<button type="button" class="btn btn-light close" style="float:right;" data-dismiss="modal"><i class="fas fa-times"></i></button><br>
                <div class="row p-2">
                    <div class="col-md-2"></div>
                    <div class="col-md-3 p-1"><label for="reference">Réference :</label></div>
                    <div class="col-md-6"><input type="text" class="form-control" value="<?php echo $row['reference']; ?>" id="edit_ref"></div>
                </div>
                <div class=" row p-2">
                    <div class="col-md-2"></div>
                    <div class="col-md-3 p-1"><label for="type">Type :</label></div>
                    <div class="col-md-6"><input type="text" class="form-control"  value="<?php echo $row['type']; ?>"  id="edit_type"></div>
                </div>
                <div class="row p-3">
                    <div class="col-md-2"></div>
                    <div class="col-md-3 p-1"><label for="qte">Quantite :</label></div>
                    <div class="col-md-6"><input type="number" class="form-control" value="<?php echo $row['quantite']; ?>" id="edit_qte"></div>
                </div>
                <div class="row p-3">
                    <div class="col-md-2"></div>
                    <div class="col-md-3 p-1"><label for="prix_achat">Prix Achat :</label></div>
                    <div class="col-md-6"><input type="number" step="0.01" value="<?php echo number_format($row['prix_achat'],2,'.',''); ?>" class="form-control" id="edit_prix"></div>
                </div>
                <div class="row p-3">
                    <div class="col-md-2"></div>
                    <div class="col-md-3 p-1"><label for="tva">TVA :</label></div>
                    <div class="col-md-6"><input type="text" value="<?php echo $row['TVA']; ?>" class="form-control" id="edit_tva"></div>
                </div>
                <div class="row p-3">
                    <div class="col-md-2"></div>
                    <div class="col-md-3 p-1"><label for="fournisseur">Fournisseur :</label></div>
                    <div class="col-md-6"><input type="text" value="<?php echo $row['fournisseur']; ?>" class="form-control" id="edit_fourn"></div>
                </div>
                <div class="d-flex justify-content-center">
                    <button class="btn btn-space btn-success" id="edit_btn" onclick="edit_article(<?php echo $row['id']; ?>)">Valider</button>
                </div>
		<?php } ?>

<script>
	function edit_article(id){
		var ref = $('#edit_ref').val();
		var type = $('#edit_type').val();
		var qte = $('#edit_qte').val();
		var prix = $('#edit_prix').val();
		var tva = $('#edit_tva').val();
		var fourn = $('#edit_fourn').val();
        if (ref == '' || type == '' || qte == '' || prix == '' || tva == '' || fourn == '') {
            alert("S'il Vous Plait Remplis Tous les Champs!!");
        }else{
            $('#edit_btn').prop('disabled', true);
            $('#modal_edit_article').modal('hide');
            $.ajax({
                type: "POST",
                url: 'edit_article.php',
                data: {id:id,ref:ref,type:type,qte:qte,prix:prix,tva:tva,fourn:fourn},
                success:function(msg) {
                    alert_success('Modification Effectué Avec Succées');
                    setTimeout(function() {
                        window.location.href="Articles.php";
                    }, 750);
                }
            });
        }
	}
</script>