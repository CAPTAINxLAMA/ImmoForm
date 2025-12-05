<?php include '../includes/header.php';?>

<h1>Mes Demandes de Formation</h1>

<?php
include "includes/config.php";
////Php Data Object → fait le lien avec une base de donnée prédéfinie
//$pdo = new PDO("mysql:host=".config::HOST.";dbname=".config::DBNAME, config::USER, config::PASSWORD);
//
//$req = $pdo->prepare("select * from categories");
//$req->execute(); //exécute le select /\
//$categories = $req->fetchAll(); //va interpréter chaque ligne de la base de donnée en tant que dictionnaire php
//?>

<table class="table table-stripped">
    <tr>
        <th>Titre</th>
        <th>Description</th>
        <th>Actions</th>
    </tr>
    <?php
    foreach ($categories as $categorie)
    {
        ?>
        <tr>
            <td><?php echo $categorie["titre"] ?></td>
            <td><?php echo $categorie["description"] ?></td>
            <td>
                <a href="/actions/modifierDemande.php?id=<?php echo $categorie["id"] ?>"
                   class="btn btn-sm btn-warning">Modifier</a>
                <a href="/actions/supprimerDemande.php?id=<?php echo $categorie["id"] ?>"
                   class="btn btn-sm btn-danger">Supprimer</a>
            </td>
        </tr>
        <?php
    }
    ?>
</table>
<a href="nouvelle_demande.php" class="btn btn-success">Faire une Nouvelle Demande de Formation</a>

<?php  include '../includes/footer.php'?>
