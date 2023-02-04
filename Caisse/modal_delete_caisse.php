<?php
session_start();
$id = $_REQUEST['id'];
require '../DataSet/db.php';

$caisse_info = "SELECT * FROM caisse WHERE id = $id";
$inf = $pdo->query($caisse_info);

    foreach ($inf as $row){ ?>
<center>
    <span class="card-subtitle" style="font-size: 15px;">Voulez Vous Supprimer <strong> <?php echo $row['objet']; ?></strong> ?</span>

    <?php } ?>

    <label class="control-label ">&nbsp;</label><br>
    <button class="btn btn-danger" id="btn-delete" onclick="supprimer(<?php echo $id; ?>);">oui</button> 
    <button class="btn btn-secondary" data-dismiss="modal">Non</button>
</center>
<script>
function supprimer(id){
    $.ajax({
        type: "POST",
        url: 'delete_caisse.php',
        data: {id:id},
        success:function(msg) {
            if (msg = 'Suppression Efféctué Avec Succées') {
                alert_success(msg);
                setTimeout(function() {
                    window.location.href="Caisse.php";
                }, 750);
            }
            
        }
    });
}
</script>
