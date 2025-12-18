<?php

include '../includes/header.php';

require '../includes/auth.php';

requireRole('client');

$token = rand(0, 1000000);
$_SESSION['token'] = $token;

include_once "../includes/config.php";

$Id=filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

$pdo = new PDO("mysql:host=" . config::host . ";dbname=" . config::dbname, config::user, config::password);

$req = $pdo->prepare("SELECT * FROM conseil LEFT JOIN formateur ON conseil.Formateur_ID = formateur.Id WHERE Demande_Id = :Id");
$req->bindParam(':Id', $Id);

$req->execute();

$demandes = $req->fetchAll();
?>

<div class="container">
    <h2>Détails :</h2>

    <table>
        <tr>
            <th>Titre </th>
            <th>Description </th>
            <th>Durée</th>
            <th>Date </th>
            <th>Lieu </th>
            <th>Support </th>
            <th>Coût</th>
            <th>Commentaire</th>
            <th>Formateur</th>
        </tr>
        <?php
        foreach ($demandes  as $demande)
        {
            ?>
            <tr>
                <td><?php echo $demande["Titre"] ?></td>
                <td><?php echo $demande["Description"] ?></td>
                <td><?php echo $demande["Duree"] ?> minutes</td>
                <td><?php echo $demande["Date"] ?></td>
                <td><?php echo $demande["Lieu"] ?></td>
                <td><?php echo $demande["Support"] ?></td>
                <td><?php echo $demande["Cout"] ?> €</td>
                <td><?php echo $demande["Commentaire"] ?></td>
                <td><?php echo $demande["Nom"]." ".$demande["Prenom"] ?></td>
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

