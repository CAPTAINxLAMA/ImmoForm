<?php
include('../includes/header.php');

// vérification des autorisations
require '../includes/auth.php';

requireRole('client');

include_once('../includes/config.php');

$token = rand(0, 1000000);
$_SESSION['token'] = $token;

$id = $_SESSION['user']['id'];

if (!$id) {
    http_response_code(404);
    die("ID manquant ou invalide");
}

// Connexion à la base de données
$pdo = new PDO("mysql:host=".config::host.";dbname=".config::dbname, config::user, config::password);

$req=$pdo->prepare("SELECT * FROM contact WHERE Id=:id");
$req->bindParam(':id', $id);
$req->execute();

$client=$req->fetchAll();

// vérification que j'en ai bien récupéré une seule
if(count($client)!=1){
    http_response_code(404);
    die("Pas de client pour l'id ".$id);
}

$client = $client[0]
?>

<div class="container">
    <h2>Informations Personnelles :</h2>
    <br>
    <form action="../actions/updateInfoClient.php" method="POST">
        <label>Nom :</label>
        <input type="text" name="Nom" value="<?php echo htmlentities($client['Nom']); ?>"  maxlength="100" required>
        <br>
        <label>Prénom :</label>
        <input type="text" name="Prenom" value="<?php echo htmlentities($client['Prenom']); ?>" required maxlength="100">
        <br>
        <label>Numéro :</label>
        <input type="text" name="Numero" value="<?php echo htmlentities($client['Numero']); ?>" maxlength="20">
        <br>
        <label>Email :</label><br>
        <input type="email" name="Email" value="<?php echo htmlentities($client['Email']); ?>" readonly maxlength="150">
        <br>
        <label>Fonction :</label>
        <input type="text" name="Fonction" value="<?php echo htmlentities($client['Fonction']); ?>" maxlength="100">
        <br>
        <label>Préférence de contact :</label>
        <select name="PreferenceContact">
            <option value="Email" <?php echo ($client['PreferenceContact'] == 'Email') ? 'selected' : ''; ?>>Email</option>
            <option value="Téléphone" <?php echo ($client['PreferenceContact'] == 'Téléphone') ? 'selected' : ''; ?>>Téléphone</option>
            <option value="SMS" <?php echo ($client['PreferenceContact'] == 'SMS') ? 'selected' : ''; ?>>SMS</option>
        </select>
        <br>
        <label>Commentaire :</label>
        <textarea name="Commentaire" rows="5" maxlength="500"><?php echo htmlentities($client['Commentaire']); ?></textarea>

        <input type="hidden" name="Id" value="<?php echo htmlentities($client['Id']); ?>">
        <input type="hidden" name="token" value="<?php echo $token; ?>">

        <button type="submit" class="btn3">Enregistrer</button>
        <a href="navbar.php" class="btn">Annuler</a>

    </form>
</div>

<?php include "../includes/footer.php"; ?>
