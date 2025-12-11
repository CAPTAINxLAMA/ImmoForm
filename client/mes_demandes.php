<?php include '../includes/header.php';

?>
<div class="container">
<h1>Mes Demandes de Formation</h1>

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
                <a href="/actions/modifierDemande.php?id=<?php echo $conseil["id"] ?>"
                   class="btn btn-sm btn-warning">Modifier</a>
                <a href="/actions/supprimerDemande.php?id=<?php echo $conseil["id"] ?>"
                   class="btn btn-sm btn-danger">Supprimer</a>
            </td>
        </tr>
        <?php
    }
    ?>
</table>
<a href="nouvelle_demande.php" class="btn btn-success">Faire une Nouvelle Demande de Formation</a>
</div>

<?php  include '../includes/footer.php'?>

