<?php include '../includes/header.php';

?>
<div class="container">
    <h1>Mes Formations</h1>

    <?php
    include_once "../includes/config.php";
    //Php Data Object → fait le lien avec une base de donnée prédéfinie
    $pdo = new PDO("mysql:host=".config::host.";dbname=".config::dbname, config::user, config::password);

    $req = $pdo->prepare("select * from conseil");
    $req->execute(); //exécute le select /\
    $conseils = $req->fetchAll(); //va interpréter chaque ligne de la base de donnée en tant que dictionnaire php
    ?>

    <table class="table table-stripped">
        <tr>
            <th>Titre </th>
            <th>Description </th>
            <th>Durée </th>
            <th>Date </th>
            <th>Lieu </th>
            <th>Support </th>
            <th>Commentaire</th>
        </tr>
        <?php
        foreach ($conseils  as $conseil)
        {
            ?>
            <tr>
                <td><?php echo $conseil["Titre"] ?></td>
                <td><?php echo $conseil["Description"] ?></td>
                <td><?php echo $conseil["Duree"] ?></td>
                <td><?php echo $conseil["Date"] ?></td>
                <td><?php echo $conseil["Lieu"] ?></td>
                <td><?php echo $conseil["Support"] ?></td>
                <td><?php echo $conseil["Commentaire"] ?></td>
                <td>
                    <a href="/actions/modifierDemande.php?id=<?php echo $conseil["id"] ?>"
                       class="btn">Modifier</a>
                    <a href="/actions/supprimerDemande.php?id=<?php echo $conseil["id"] ?>"
                       class="btn">Supprimer</a>
                </td>
            </tr>
            <?php
        }
        ?>
    </table>
    <a href="creation_formationConseil.php" class="btn btn-success">Créer une Nouvelle Formation</a>
    <a href="navbar.php" class='btn' >Accueil</a>
</div>

<?php  include '../includes/footer.php'?>

