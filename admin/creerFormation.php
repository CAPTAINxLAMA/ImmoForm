<?php
include "../includes/header.php";

require '../includes/auth.php';
requireRole('admin');

$token = rand(0, 1000000);
$_SESSION['token'] = $token;

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$standard = filter_input(INPUT_GET, 'standard', FILTER_VALIDATE_INT);

if ($standard)
{
    ?>
    <main>
        <div class="container">
            <h2>Une formation standard :</h2>
            <a href="./creerFormation.php?id=<?php echo $id ?>&standard=0" class='btn'>En ligne</a>
            <br>
            <form method="POST" action="../actions/createFormationS.php">
                <label>Titre :</label>
                <input type="text" name="titre" maxlength="50" required>

                <label>Description :</label>
                <input type="text" name="description" required>

                <label>Durée :</label>
                <input type="number" name="duree" placeholder="En heures" required>

                <label>Niveau :</label>
                <select name="niveau" required>
                    <option>-- Définissez un niveau d'expertise --</option>
                    <option value="debutant">débutant</option>
                    <option value="intermediaire">intermédiaire</option>
                    <option value="avance">avancé</option>
                </select>

                <label>Secteur :</label>
                <input type="text" name="secteur" required>

                <label>Date de début :</label>
                <input type="datetime-local" name="datedebut" required>

                <label>Date de fin :</label>
                <input type="datetime-local" name="datefin" required>

                <label>Lieu :</label>
                <input type="text" name="lieu" required>

                <label>Capacité d'accueil :</label>
                <input type="number" name="capacite" required>

                <label>Formateurs (2 ou plus):</label>
                <select name="formateur_id" required multiple>
                    <option>-- Choisissez plusieurs formateurs --</option>
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

                <label>Matériel :</label>
                <input type="text" name="materiel" placeholder="Facultatif">

                <label>Coût :</label>
                <input type="number" name="cout" step="0.01" placeholder="En euro" required>

                <label>Modalité d'inscription :</label>
                <input type="text" name="modalite" placeholder="Facultatif">

                <label>Commentaire :</label>
                <input type="text" name="commentaire" placeholder="Facultatif">

                <label>Support de formation (lien) :</label>
                <input type="text" name="support" placeholder="Facultatif">

                <input type="hidden" name="id" value="<?php echo $id; ?>">

                <input type="hidden" name="token" value="<?php echo $token; ?>">

                <button class="btn3" type="submit" >Créer le conseil</button>
                <a href="./gererDemandes.php" class='btn'>Annuler</a>
            </form>
        </div>
    </main>
<?php
}

else {
?>
    <main>
        <div class="container">
            <h2>Une formation en ligne :</h2>
            <a href="./creerFormation.php?id=<?php echo $id ?>&standard=1" class='btn'>Standard</a>

            <br>
            <form method="POST" action="../actions/createFormationO.php">
                <label>Titre :</label>
                <input type="text" name="titre" maxlength="50" required>

                <label>Description:</label>
                <input type="text" name="description" required>

                <label>Durée :</label>
                <input type="number" name="duree" placeholder="En heures" required>

                <label>Niveau :</label>
                <select name="niveau" required>
                    <option>-- Définissez un niveau d'expertise --</option>
                    <option value="debutant">débutant</option>
                    <option value="intermediaire">intermédiaire</option>
                    <option value="avance">avancé</option>
                </select>

                <label>Date et heure :</label>
                <input type="datetime-local" name="dateheure" required>

                <label>Lien (URL) :</label>
                <input type="url" name="url" required>

                <label>Formateur:</label>
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

                <label>Secteur :</label>
                <input type="text" name="secteur" required>

                <input type="hidden" name="id" value="<?php echo $id; ?>">

                <input type="hidden" name="token" value="<?php echo $token; ?>">

                <button class="btn3" type="submit" >Créer le conseil</button>
                <a href="./gererDemandes.php" class='btn'>Annuler</a>
            </form>
        </div>
    </main>
<?php
}
include '../includes/footer.php'?>
