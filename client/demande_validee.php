<?php include '../includes/header.php';

require '../includes/auth.php';

requireRole('client');

include_once "../includes/config.php";

$Id=filter_input(INPUT_GET, 'Id', FILTER_VALIDATE_INT);

$pdo = new PDO("mysql:host=" . config::host . ";dbname=" . config::dbname, config::user, config::password);

$req = $pdo->prepare("SELECT * FROM conseil WHERE Demande_Id = :Id ");
$req->bindParam(':Id', $Id);

$req->execute();

$conseils = $req->fetchAll();

?>

<div class="container">
    <h2>Détails :</h2>

    <table>
        <tr>
            <th>Type </th>
            <th>Description </th>
            <th>Durée</th>
            <th>Date </th>
            <th>Lieu </th>
            <th>Support </th>
            <th>Coût</th>
            <th>Commentaire</th>
        </tr>
        <?php
        foreach ($conseils  as $conseil)
        {
            ?>
            <tr>
                <td><?php echo $conseil["Type"] ?></td>
                <td><?php echo $conseil["Description"] ?></td>
                <td><?php echo $conseil["Duree"] ?> minutes</td>
                <td><?php echo $conseil["Date"] ?></td>
                <td><?php echo $conseil["Lieu"] ?></td>
                <td><?php echo $conseil["Support"] ?></td>
                <td><?php echo $conseil["Cout"] ?> €</td>
                <td><?php echo $conseil["Commentaire"] ?></td>
            </tr>
            <?php
        }
        ?>
    </table>
    <tr>
        <td>
            <a href="mes_demandes.php" class="btn3">Retour</a>
        </td>
        <td>
            <a href="navbar.php" class='btn' >Accueil</a>
        </td>
    </tr>
</div>

<?php  include '../includes/footer.php'?>

