<?php
include('../includes/header.php');

// vérification des autorisations
require '../includes/auth.php';

requireRole('client');

include_once('../includes/config.php');

$token = rand(0, 1000000);
$_SESSION['token'] = $token;

$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

if (!$id) {
    http_response_code(404);
    die("ID manquant ou invalide");
}

// Connexion à la base de données
$pdo = new PDO("mysql:host=".config::host.";dbname=".config::dbname, config::user, config::password);

$req=$pdo->prepare("SELECT * FROM demandeconseil WHERE Id=:id");
$req->bindParam(':id', $id);
$req->execute();

$demandeconseil=$req->fetchAll();

// vérification que j'en ai bien récupéré une seule
if(count($demandeconseil)!=1){
    http_response_code(404);
    die("Pas de demande conseil pour l'id ".$id);
}

?>

<div class="container">
    <h2>Modifier la demande :</h2>
    <br>
    <form action="../actions/updateDemande.php" method="post">
        <label>Type :</label>
        <input type="text" value="<?php echo htmlentities($demandeconseil[0]["Type"]) ?>" name="Type" required maxlength="50">

        <label>Description :</label>
        <textarea name="Description" rows="4"><?php echo htmlentities($demandeconseil[0]["Description"]) ?></textarea>

        <input type="hidden" name="Id" value="<?php echo $id ?>"/>
        <input type="hidden" name="token" value="<?php echo $token; ?>">

        <button type="submit" class="btn3">Enregistrer</button>
        <a href="mes_demandes.php" class="btn">Annuler</a>
    </form>
</div>

<?php include "../includes/footer.php"; ?>
