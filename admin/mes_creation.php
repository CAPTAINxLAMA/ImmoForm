<?php include '../includes/header.php';

require 'includes/auth.php';

requireRole('admin');

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
        <tr class="tr">
            <th class="th">Titre </th>
            <th class="th">Description </th>
            <th class="th">Durée (en minutes) </th>
            <th class="th">Date </th>
            <th class="th">Lieu </th>
            <th class="th">Support </th>
            <th class="th">Coût (en euros)</th>
            <th class="th">Commentaire</th>
        </tr>
        <?php
        foreach ($conseils  as $conseil)
        {
            ?>
            <tr class="tr">
                <td class="th"><?php echo $conseil["Titre"] ?></td>
                <td class="th"><?php echo $conseil["Description"] ?></td>
                <td class="th"><?php echo $conseil["Duree"] ?></td>
                <td class="th"><?php echo $conseil["Date"] ?></td>
                <td class="th"><?php echo $conseil["Lieu"] ?></td>
                <td class="th"><?php echo $conseil["Support"] ?></td>
                <td class="th"><?php echo $conseil["Cout"] ?></td>
                <td class="th"><?php echo $conseil["Commentaire"] ?></td>
                <td>
                    <a href="modifierConseil.php?id=<?php echo $conseil["id"] ?>" class="btn1">Modifier</a>
                </td>
                <td>
                    <a href="supprimerConseil.php?id=<?php echo $conseil["id"] ?>" class="btn2">Supprimer</a>
                </td>
            </tr>
            <?php
        }
        ?>
    </table>
    <a href="creation_conseil.php" class="btn btn-success">Créer une Nouvelle Formation</a>
    <a href="navbar.php" class='btn' >Accueil</a>
</div>

<?php  include '../includes/footer.php'?>

