<?php
session_start();
$ref = $_REQUEST['ref'];
require '../DataSet/db.php';
?>
<center>
<div class="card-subtitle" style="font-size: 15px;">Voulez Vous Supprimer <strong><?php echo $ref ?> </strong> ?</div>
<label class="control-label ">&nbsp;</label><br>
<button class="btn btn-danger" onclick="supprimer('<?php echo $ref; ?>');">oui</button> 
<button class="btn btn-secondary" data-dismiss="modal">Non</button>
</center>
<script>
	function supprimer(ref){
		$.ajax({
			type: "POST",
			url: 'supprimer_reference.php',
			data: {ref:ref},
			success:function(msg) {
				alert_success('Suppression Effectué Avec Succés');
                    setTimeout(function() {
                        window.location.href="changer_prix.php";
                    }, 750);
			}
		});
	}
</script>