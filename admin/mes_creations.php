<?php include '../includes/header.php';

require '../includes/auth.php';

requireRole('admin');

include_once "../includes/config.php";
$pdo = new PDO("mysql:host=" . config::host . ";dbname=" . config::dbname, config::user, config::password);

$req = $pdo->prepare("SELECT * FROM conseil");
$req->execute();

$conseils = $req->fetchAll();

?>

<div class="container">
    <h2>Mes Formations :</h2>

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
        </tr>
        <?php
        foreach ($conseils  as $conseil)
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
                <td>
                    <a href="modifierConseil.php?id=<?php echo $conseil["Id"] ?>" class="btn1">Modifier</a>
                </td>
                <td>
                    <a href="supprimerConseil.php?id=<?php echo $conseil["Id"] ?>" class="btn2">Supprimer</a>
                </td>
            </tr>
            <?php
        }
        ?>
    </table>
    <a href="creerConseil.php" class="btn">Créer une Nouvelle Formation</a>
    <a href="navbar.php" class='btn' >Accueil</a>
</div>

<?php  include '../includes/footer.php'?>

