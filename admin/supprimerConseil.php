<?php
include('../includes/header.php');

require '../includes/auth.php';

requireRole('admin');

include_once('../includes/config.php');

$token = rand(0, 1000000);
$_SESSION['token'] = $token;

$Id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

if (!$Id) {
    http_response_code(404);
    die("ID manquant ou invalide");
}

// Connexion à la base de données
$pdo = new PDO("mysql:host=".config::host.";dbname=".config::dbname, config::user, config::password);

$req=$pdo->prepare("SELECT * FROM conseil WHERE Id=:Id");
$req->bindParam(':Id', $Id);
$req->execute();

$conseil=$req->fetchAll();

// vérification que j'en ai bien récupéré une seule
if(count($conseil)!=1){
    http_response_code(404);
    die("Pas de demande conseil pour l'id ".$Id);
}

?>

<div class="container">
    <h2>Supprimer le conseil :</h2>
    <br>
    <form action="../actions/deleteConseil.php" method="post">

        <label><b>Titre :</b> <?php echo htmlentities($conseil[0]["Titre"]) ?></label>
        <label><b>Description :</b> <?php echo htmlentities($conseil[0]["Description"]) ?></label>
        <label><b>Durée :</b> <?php echo htmlentities($conseil[0]["Duree"]) ?></label>
        <label><b>Date :</b> <?php echo htmlentities($conseil[0]["Date"]) ?></label>
        <label><b>Lieu :</b> <?php echo htmlentities($conseil[0]["Lieu"]) ?></label>
        <label><b>Support :</b> <?php echo htmlentities($conseil[0]["Support"]) ?></label>
        <label><b>Coût :</b> <?php echo htmlentities($conseil[0]["Cout"]) ?></label>
        <label><b>Commentaire :</b> <?php echo htmlentities($conseil[0]["Commentaire"]) ?></label>

        <br> <input type="hidden" name="Id" value="<?php echo $Id ?>"/>
        <input type="hidden" name="token" value="<?php echo $token; ?>">

        <button type="submit" class="btn2">Supprimer</button>
        <a href="mes_creations.php" class="btn">Annuler</a>
    </form>
</div>

<?php include "../includes/footer.php"; ?>
