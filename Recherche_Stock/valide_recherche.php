<?php
session_start();
require '../DataSet/db.php';
$rech=$_POST['rech'];
$condition=$_POST['condition'];

if ($condition == 'type') {
    $query = $pdo->query("SELECT type, quantite FROM (
                            SELECT DISTINCT type, quantite AS quantite FROM articles GROUP BY type
                            UNION 
                            SELECT DISTINCT type, COUNT(reference) AS quantite FROM stock GROUP BY type)X WHERE type LIKE '%$rech%'");
                            ?>
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th><center>Types</center></th>
                    <th><center>Quantité</center></th>
                </tr>
            </thead>
            <tbody style="color:black;">
                <?php foreach ($query as $row){ ?>
                <tr>
                    <td><center><?php echo ucwords($row['type']); ?></center></td>
                    <td width='10%'><center><?php echo ucwords($row['quantite']); ?></center></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
<?php
}else if ($condition = 'reference') {
    $query = $pdo->query("SELECT type, reference,  quantite FROM (
                            SELECT DISTINCT reference, type, quantite AS quantite FROM articles GROUP BY reference
                            UNION 
                            SELECT DISTINCT reference, type, COUNT(reference) AS quantite FROM stock GROUP BY reference)X WHERE reference LIKE '%$rech%'");
}
?>
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th><center>Types</center></th>
                    <th><center>Référence</center></th>
                    <th width='10%'><center>Quantité</center></th>
                    <th><center>Prix</center></th>
                </tr>
            </thead>
            <tbody style="color:black;">
                <?php foreach ($query as $row){ ?>
                <tr>
                    <td width='20%'><center><?php echo ucwords($row['type']); ?></center></td>
                    <td><center><?php echo ucwords($row['reference']); ?></center></td>
                    <td width='10%'><center><?php echo ucwords($row['quantite']); ?></center></td>
                    <td width='5%'><center>
                        <button title="Afficher les details" data-toggle="modal" data-target="#modal_reference_prix" class="btn btn-sm btn-secondary"
                            onclick="open_model_reference('<?php echo $row['reference']; ?>');">
                        <i class="far fa-eye"></i></button>
                    </center></td>  
                </tr>
                <?php } ?>
            </tbody>
        </table>
        <script>
            function open_model_reference(reference) {
                $.ajax({
                    type: "POST",
                    url: 'reference_prix.php',
                    data: {reference:reference},
                    success:function(msg) {
                        $('#reference_details').html(msg);
                    }
                });
            }
        </script>
