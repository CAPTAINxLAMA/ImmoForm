<?php
include('../includes/header.php');

// vérification des autorisations
require '../includes/auth.php';

requireRole('admin');

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

$req=$pdo->prepare("SELECT * FROM conseil WHERE Id=:id");
$req->bindParam(':id', $id);
$req->execute();

$conseil=$req->fetchAll();

// vérification que j'en ai bien récupéré une seule
if(count($conseil)!=1){
    http_response_code(404);
    die("Pas de conseil pour l'id ".$id);
}

?>

<div class="container">
    <h2>Modifier le conseil :</h2>
    <br>
    <form action="../actions/updateConseil.php" method="post">

        <main>
            <div class="container">
                <h2>Un conseil :</h2>
                <br>
                <form method="POST" action="../actions/createConseil.php">
                    <label>Titre :</label>
                    <input type="text" name="titre" maxlength="50" required value="<?php echo htmlentities($conseil[0]["Titre"]) ?>">

                    <label>Description détaillée :</label>
                    <input type="text" name="description" required value="<?php echo htmlentities($conseil[0]["Description"]) ?>">

                    <label>Durée :</label>
                    <input type="number" name="duree" placeholder="En heure" required value="<?php echo htmlentities($conseil[0]["Duree"]) ?>">

                    <!--récupération de la date du jour-->

                    <label>Coût :</label>
                    <input type="number" step="0.01" name="cout" placeholder="En euro" required value="<?php echo htmlentities($conseil[0]["Cout"]) ?>">

                    <label>Commentaire :</label>
                    <input type="text" name="commentaire" placeholder="Factultatif" value="<?php echo htmlentities($conseil[0]["Commentaire"]) ?>">

                    <label>Support :</label>
                    <input type="text" name="support" placeholder="Factultatif" value="<?php echo htmlentities($conseil[0]["Support"]) ?>">

                    <label>Lieu :</label>
                    <input type="text" name="lieu" required value="<?php echo htmlentities($conseil[0]["Lieu"]) ?>">

                    <input type="hidden" name="id" value="<?php echo $id ?>"/>
                    <input type="hidden" name="token" value="<?php echo $token; ?>">

                    <button type="submit" class="btn3">Enregistrer</button>
                    <a href="mes_demandes.php" class="btn">Annuler</a>
                </form>

            </div>
        </main>
    </form>
</div>

<?php include "../includes/footer.php"; ?>

