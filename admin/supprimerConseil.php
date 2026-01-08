<?php
include('../includes/header.php');

require '../includes/auth.php';
requireRole('admin');

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
$req = $pdo->prepare("SELECT * FROM conseil WHERE Id = :id");
$req->bindParam(':id', $id);
$req->execute();

$conseil = $req->fetchAll();

// vérification de l'unicité du conseil
if(count($conseil)!=1){
    http_response_code(404);
    die("Pas de demande conseil pour l'id ".$id);
}

?>

<div class="container">
    <h2>Supprimer le conseil :</h2>
    <br>
    <form action="../actions/deleteConseil.php" method="POST">

        <label><b>Titre :</b> <?php echo htmlentities($conseil[0]["Titre"]) ?></label><br><br>
        <label><b>Description :</b> <?php echo htmlentities($conseil[0]["Description"]) ?></label><br><br>
        <label><b>Durée :</b> <?php echo htmlentities($conseil[0]["Duree"]) ?></label><br><br>
        <label><b>Date :</b> <?php echo htmlentities($conseil[0]["Date"]) ?></label><br><br>
        <label><b>Lieu :</b> <?php echo htmlentities($conseil[0]["Lieu"]) ?></label><br><br>
        <label><b>Support :</b> <?php echo htmlentities($conseil[0]["Support"]) ?></label><br><br>
        <label><b>Coût :</b> <?php echo htmlentities($conseil[0]["Cout"]) ?></label><br><br>
        <label><b>Commentaire :</b> <?php echo htmlentities($conseil[0]["Commentaire"]) ?></label><br><br>

        <br> <input type="hidden" name="id" value="<?php echo $id ?>"/>
        <input type="hidden" name="token" value="<?php echo $token; ?>">

        <button type="submit" class="btn2">Supprimer</button>
        <a href="./mes_creations.php" class="btn">Annuler</a>
    </form>
</div>

<?php include "../includes/footer.php"; ?>
