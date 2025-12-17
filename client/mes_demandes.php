<?php include '../includes/header.php';

require '../includes/auth.php';

requireRole('client');

include_once "../includes/config.php";

$pdo = new PDO("mysql:host=".config::host.";dbname=".config::dbname, config::user, config::password);
$req = $pdo->prepare("SELECT * FROM demandeconseil ORDER BY demandeconseil.Id ASC");
$req->execute();

$conseils = $req->fetchAll();
?>

<div class="container">
    <h2>Mes Demandes de conseil :</h2>
    <table>
        <tr>
            <th>Type</th>
            <th>Description</th>
            <th>Date</th>
            <th>Statut</th>
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
                    <a href="modifierDemande.php?id=<?php echo $conseil["Id"] ?>" class="btn1">Modifier</a>
                </td>
                <td>
                    <a href="supprimerDemande.php?id=<?php echo $conseil["Id"] ?>" class="btn2">Supprimer</a>
                </td>
            </tr>
            <?php
        }
        ?>
    </table>
    <a href="creerDemande.php" class="btn btn-success">Créer une Demande de Conseil</a>
    <a href="navbar.php" class="btn btn-secondary">Accueil</a>

</div>

<?php  include '../includes/footer.php'?>

