<?php
session_start();
$id = $_REQUEST['id'];
require '../DataSet/db.php';

$client_info = "SELECT * FROM client WHERE id = $id";
$inf = $pdo->query($client_info);

		foreach ($inf as $row){ ?>
<center>
<span class="card-subtitle" style="font-size: 15px;">Voulez Vous Supprimer <strong><?php echo $row['societe']; ?> </strong> ?</span>
<?php } ?>
<label class="control-label ">&nbsp;</label><br>
<button class="btn btn-danger" onclick="supprimer(<?php echo $id; ?>);">oui</button> 
<button class="btn btn-secondary" data-dismiss="modal">Non</button>
</center>
<script>
	function supprimer(id){
		$.ajax({
			type: "POST",
			url: 'delete_client.php',
			data: {id:id},
			success:function(msg) {
				alert_success('Suppression Effectué Avec Succés');
				setTimeout(function() {
					window.location.href="Client.php";
				}, 750);
		}
		});
	}
</script>


