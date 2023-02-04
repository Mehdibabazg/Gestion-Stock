<?php
session_start();
$ref = $_REQUEST['ref'];
require '../DataSet/db.php';
$ref_info = "SELECT prix FROM reference WHERE reference = '$ref'";
$inf = $pdo->query($ref_info);
$row = $inf->fetch(PDO::FETCH_ASSOC)
?>
<div class="justify-content-center">
    <label for="prix">Prix :</label>
    <input type="text" id="prix" class="form-control" value="<?php echo number_format($row['prix'],2,"."," "); ?>">
    <button class="btn btn-success mt-2" onclick="modifier('<?php echo $ref; ?>')">Valider</button>
</div>

<script>
	function modifier(ref){
		var prix = $('#prix').val();
		$.ajax({
			type: "POST",
			url: 'modifier_prix.php',
			data: {ref:ref,prix:prix},
			success:function(msg) {
				alert_success('Modification Effectué Avec Succés');
                    setTimeout(function() {
                        window.location.href="changer_prix.php";
                    }, 750);
			}
		});
	}
</script>