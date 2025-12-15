<?php include '../includes/header.php';

require 'includes/auth.php';

requireRole('client');

?>
<div class="container">
<h1>Mes Demandes de conseil</h1>

<?php
include_once "../includes/config.php";

$pdo = new PDO("mysql:host=".config::host.";dbname=".config::dbname, config::user, config::password);
$req = $pdo->prepare("SELECT * FROM demandeconseil WHERE ");
$req->execute();

$conseils = $req->fetchAll();
?>

<table class="table table-stripped">
    <tr>
        <th>Type</th>
        <th>Description</th>
        <th>Date</th>
    </tr>
    <?php
    foreach ($conseils  as $conseil)
    {
        ?>
        <tr>
            <td><?php echo $conseil["Type"] ?></td>
            <td><?php echo $conseil["Description"] ?></td>
            <td><?php echo $conseil["Date"] ?></td>
            <td><?php echo $conseil["Statut"] ?></td>
            <td>
                <a href="/client/modifierDemande.php?id=<?php echo $conseil["id"] ?>"
                   class="btn btn-sm btn-warning">Modifier</a>
            </td>
            <td>
                <a href="/actions/supprimerDemande.php?id=<?php echo $conseil["id"] ?>"
                   class="btn btn-sm btn-danger">Supprimer</a>
            </td>
        </tr>
        <?php
    }
    ?>
</table>
<a href="nouvelle_demande.php" class="btn btn-success">Créer une Demande ou un Conseil</a>
</div>

<?php  include '../includes/footer.php'?>

