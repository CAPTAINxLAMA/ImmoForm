<?php

include '../includes/header.php';

require '../includes/auth.php';

requireRole('client');

$token = rand(0, 1000000);
$_SESSION['token'] = $token;

include_once "../includes/config.php";

$pdo = new PDO("mysql:host=".config::host.";dbname=".config::dbname, config::user, config::password);

$req = $pdo->prepare("SELECT Nom, Prenom, Id FROM contact WHERE Email = :email");
$req->bindparam(':email', $_SESSION['user']['email']);
$req->execute();

$contact = $req->fetchAll();

?>

<main>
    <div class="container">
        <h2>Une demande de conseil :</h2>
        <br>
        <form action="../actions/createDemande.php" method="POST">
            <label>Type de demande :</label>
            <input type="text" required maxlength="100" name="type">

            <label>Description détaillée de la demande (Sujet, Type, Commentaire éventuel...) :</label>
            <textarea name="description" rows="5" cols="50" required></textarea>

            <label>Contact de l'agence :</label>
            <input type="text" name="contact_agence" value="<?php echo $contact['0']['Nom'] . " " . $contact['0']['Prenom']; ?>" readonly>
            <input type="hidden" name="contact_id" value="<?php echo $contact['0']['Id']; ?>">

            <label>Agence cliente :</label>
            <select name="agence_id" required>
                <option>-- Choisissez une agence --</option>
                <?php
                // Récupérer toutes les agences depuis la base de donnnée
                $req = $pdo->prepare("SELECT Id, Nom FROM agence");
                $req->execute();

                $agences = $req->fetchAll();
                for ($i = 0; $i < count($agences); $i++) {
                    echo '<option value="' . $agences[$i]['Id'] . '">' . htmlentities($agences[$i]['Nom']) . '</option>';
                }
                ?>
            </select>

            <input type="hidden" name="token" value="<?php echo $token; ?>">
            <br>
            <br>
            <input class="btn3" type="submit" value="Envoyer">
            <a href="navbar.php" class="btn">Accueil</a>
        </form>

    </div>
</main>

<?php include '../includes/footer.php'; ?>
