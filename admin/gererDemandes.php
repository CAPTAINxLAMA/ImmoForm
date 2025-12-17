<?php include '../includes/header.php';

require '../includes/auth.php';

requireRole('admin');

include_once "../includes/config.php";

$pdo = new PDO("mysql:host=" . config::host . ";dbname=" . config::dbname, config::user, config::password);

$req = $pdo->prepare("SELECT * FROM demandeconseil");
$req->execute();

$conseils = $req->fetchAll();

?>

<div class="container">
    <h1>Demandes des Clients :</h1>

    <table>
        <tr>
            <th>Type</th>
            <th>Description</th>
            <th>Date</th>
            <th>Statut</th>
            <th>Prise en charge</th>
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
                <td><?php echo $conseil["Formateur_Id"]; if ($conseil["Formateur_Id"] == Null) { echo "Non assigné"; }?></td>
                <td>
                    <a href="creerConseil.php?id="<?php echo $conseil["Id"] ?> class="btn3">Créer un Nouveau Conseil</a>
                    <a href="../actions/acceptDemande.php?id="<?php echo $conseil["Id"] ?> class="btn3">Prendre en charge</a>
                    <a href="../actions/refuseDemande.php?id="<?php echo $conseil["Id"] ?> class="btn2">Rejeter</a>
                </td>
            </tr>
            <?php
        }
        ?>
    </table>

    <a href="navbar.php" class='btn' >Accueil</a>
</div>

<?php  include '../includes/footer.php'?>