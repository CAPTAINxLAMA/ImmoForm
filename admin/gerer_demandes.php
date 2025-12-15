<?php include '../includes/header.php';

require '../includes/auth.php';

requireRole('admin');

?>
<div class="container">
    <h1>Demandes de Clients</h1>

    <?php
    include_once "../includes/config.php";
    //Php Data Object → fait le lien avec une base de donnée prédéfinie
    $pdo = new PDO("mysql:host=".config::host.";dbname=".config::dbname, config::user, config::password);

    $req = $pdo->prepare("select * from demandeconseil");
    $req->execute(); //exécute le select /\
    $conseils = $req->fetchAll(); //va interpréter chaque ligne de la base de donnée en tant que dictionnaire php
    ?>

    <table class="table table-stripped">
        <tr>
            <th>Type | </th>
            <th>Description | </th>
            <th>Date | </th>
            <th>Statut |</th>
            <th>Gérer par</th>
        </tr>
        <?php
        foreach ($conseils  as $conseil)
        {
            ?>
            <tr>
                <td><?php echo $conseil["Type"] ?></td>
                <td><?php echo $conseil["Description"] ?></td>
                <td><?php echo $conseil["Date"] ?></td>
                <td><?php echo $conseil["Statut"] ?></td
                <td><?php echo $conseil["Formateur_id"] ?></td>
                <td>
                    <a href="/actions/accepterDemande.php?id=<?php echo $conseil["id"] ?>"
                       class="btn btn-sm btn-warning">Prendre en charge</a>
                    <a href="/actions/refuserDemande.php?id=<?php echo $conseil["id"] ?>"
                       class="btn btn-sm btn-danger">Refuser</a>
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