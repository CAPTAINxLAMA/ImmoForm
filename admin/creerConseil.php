<?php
include "../includes/header.php";

require '../includes/auth.php';
requireRole('admin');

$token = rand(0, 1000000);
$_SESSION['token'] = $token;

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
?>

<main>
    <div class="container">
        <h2>Un conseil :</h2>
        <br>
        <form method="POST" action="../actions/createConseil.php">
            <label>Titre :</label>
            <input type="text" name="titre" maxlength="50" required>

            <label>Description détaillée :</label>
            <input type="text" name="description" required>

            <label>Durée :</label>
            <input type="number" name="duree" placeholder="En heures" required>

            <label>Coût :</label>
            <input type="number" step="0.01" name="cout" placeholder="En euro" required>

            <label>Commentaire :</label>
            <input type="text" name="commentaire" placeholder="Factultatif">

            <label>Support :</label>
            <input type="text" name="support" placeholder="Factultatif">

            <label>Lieu :</label>
            <input type="text" name="lieu" required>

            <label>Formateur :</label>
            <select name="formateur_id" required>
                <option>-- Choisissez un formateur --</option>
                <?php
                // Connexion à la base de données
                include_once "../includes/config.php";
                $pdo = new PDO("mysql:host=".config::host.";dbname=".config::dbname, config::user, config::password);

                // Envoie de la requête SQL
                $req = $pdo->prepare("SELECT * FROM formateur");
                $req->execute();

                $formateur = $req->fetchAll();

                for ($i = 0; $i < count($formateur); $i++) {
                    echo '<option value="' . $formateur[$i]['Id'] . '">' . htmlentities($formateur[$i]['Nom']) . ' ' . htmlentities($formateur[$i]['Prenom']) . '</option>';
                }
                ?>
            </select>

            <input type="hidden" name="id" value="<?php echo $id; ?>">

            <input type="hidden" name="token" value="<?php echo $token; ?>">

            <button class="btn3" type="submit" >Créer le conseil</button>
            <a href="./gererDemandes.php" class='btn'>Annuler</a>
        </form>
    </div>
</main>

<?php  include '../includes/footer.php'?>
