<?php
include('../includes/header.php');

require '../includes/auth.php';
requireRole('client');

$token = rand(0, 1000000);
$_SESSION['token'] = $token;

$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
if (!$id)
{
    http_response_code(404);
    die("ID manquant ou invalide");
}

// Connexion à la base de données
include_once('../includes/config.php');
$pdo = new PDO("mysql:host=".config::host.";dbname=".config::dbname, config::user, config::password);

// Envoie de la requête SQL
$req=$pdo->prepare("SELECT * FROM demandeconseil WHERE Id = :id");
$req->bindParam(':id', $id);
$req->execute();

$demandeconseil = $req->fetchAll();

// vérification de l'unicité du conseil
if(count($demandeconseil)!=1){
    http_response_code(404);
    die("Pas de demande conseil pour l'id ".$id);
}

?>

<div class="container">
    <h2>Supprimer la demande :</h2>
    <br>
    <form action="../actions/deleteDemande.php" method="post">
        <table>
            <tr>
                <th>Type</th>
                <th>Description</th>
                <th>Date</th>
                <th>Statut</th>
            </tr>
            <tr>
                <td><?php echo htmlentities($demandeconseil[0]["Type"]) ?></td>
                <td><?php echo htmlentities($demandeconseil[0]["Description"]) ?></td>
                <td><?php echo htmlentities($demandeconseil[0]["Date"]) ?></td>
                <td><?php echo htmlentities($demandeconseil[0]["Statut"]) ?></td>
            </tr>
        </table>
        <input type="hidden" name="token" value="<?php echo $token; ?>">
        <input type="hidden" name="id" value="<?php echo $id ?>"/>
        <button type="submit" class="btn2">Supprimer</button>
        <a href="./mes_demandes.php" class="btn">Annuler</a>
    </form>
</div>

<?php include "../includes/footer.php"; ?>
