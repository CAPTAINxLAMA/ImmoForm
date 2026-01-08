<?php
include '../includes/header.php';

require '../includes/auth.php';
requireRole('admin');

// Connexion à la base de données
include_once "../includes/config.php";
$pdo = new PDO("mysql:host=" . config::host . ";dbname=" . config::dbname, config::user, config::password);

// Envoie de la requête SQL
$req = $pdo->prepare("SELECT conseil.Id AS conseilId, conseil.Titre, conseil.Description, conseil.Duree, conseil.Date, conseil.Lieu, conseil.Support, conseil.Cout, conseil.Commentaire, formateur.Nom, formateur.Prenom FROM conseil LEFT JOIN formateur ON conseil.formateur_id = formateur.id");
$req->execute();

$conseils = $req->fetchAll();
?>

<div class="container">
    <h2>Mes Conseils :</h2>
    <table>
        <tr>
            <th>Titre</th>
            <th>Description</th>
            <th>Durée</th>
            <th>Date</th>
            <th>Lieu</th>
            <th>Support</th>
            <th>Coût</th>
            <th>Commentaire</th>
            <th>Formateur</th>
        </tr>
        <?php
        foreach ($conseils as $conseil)
        {
            ?>
            <tr>
                <td><?php echo $conseil["Titre"] ?></td>
                <td><?php echo $conseil["Description"] ?></td>
                <td><?php echo $conseil["Duree"] ?> minutes</td>
                <td><?php echo $conseil["Date"] ?></td>
                <td><?php echo $conseil["Lieu"] ?></td>
                <td><?php echo $conseil["Support"] ?></td>
                <td><?php echo $conseil["Cout"] ?> €</td>
                <td><?php echo $conseil["Commentaire"] ?></td>
                <td><?php echo $conseil["Nom"].' '.$conseil["Prenom"] ?></td>
                <td>
                    <a href="./modifierConseil.php?id=<?php echo $conseil["conseilId"] ?>" class="btn1">Modifier</a>
                </td>
                <td>
                    <a href="./supprimerConseil.php?id=<?php echo $conseil["conseilId"] ?>" class="btn2">Supprimer</a>
                </td>
            </tr>
            <?php
        }
        ?>
    </table>
    <tr>
        <td>
            <a href="./navbar.php" class='btn' >Accueil</a>
        </td>
    </tr>
</div>

<?php  include '../includes/footer.php'?>