<?php
include '../includes/header.php';

require '../includes/auth.php';
requireRole('admin');

$token = rand(0, 1000000);
$_SESSION['token'] = $token;

$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
$standard_oupas = filter_input(INPUT_GET, "standard", FILTER_VALIDATE_INT);
if (!$id)
{
    http_response_code(404);
    die("ID manquant ou invalide");
}

// Connexion à la base de données
include_once('../includes/config.php');
$pdo = new PDO("mysql:host=".config::host.";dbname=".config::dbname, config::user, config::password);

if ($standard_oupas)
{
    $req = $pdo->prepare("SELECT * FROM standard WHERE Id = :id");
    $req->bindParam( ':id', $id);
    $req->execute();

    $formationS = $req->fetchAll();

    $form_id = $formationS["Id"];

    $reqLink = $pdo->prepare("SELECT formateur.Nom, formateur.Prenom FROM formateur JOIN formateur_standard ON formateur.Id = formateur_standard.Formateur_id JOIN standard ON formateur_standard.Standard_id = standard.Id WHERE formateur_standard.Standard_id = :Standard_id");
    $reqLink->bindParam( ':Standard_id', $form_id);
    $reqLink->execute();

    $formateurs = $reqLink->fetchAll();

    // vérification de l'unicité du conseil
    if(count($formationS)!=1){
        http_response_code(404);
        die("Pas de formation pour l'id ".$id);
    }

    ?>

    <div class="container">
        <form action="../actions/updateFormation.php" method="post">
            <h2>Modifier le conseil :</h2>
            <br>
            <label>Titre :</label>
            <input type="text" name="titre" maxlength="50" required value="<?php echo htmlentities($formationS[0]["Titre"]) ?>">

            <label>Description :</label>
            <input type="text" name="description" required value="<?php echo htmlentities($formationS[0]["Description"]) ?>">

            <label>Durée :</label>
            <input type="number" name="duree" placeholder="En heures" required value="<?php echo htmlentities($formationS[0]["Duree"]) ?>">

            <label>Niveau :</label>
            <select name="niveau" required value="<?php echo htmlentities($formationS[0]["Niveau"]) ?>">
                <option>-- Définissez un niveau d'expertise --</option>
                <option value="debutant" <?php if ($formationS[0]["Niveau"] == "debutant") { echo "selected"; }?>>débutant</option>
                <option value="intermediaire" <?php if ($formationS[0]["Niveau"] == "intermediaire") { echo "selected"; }?>>intermédiaire</option>
                <option value="avance" <?php if ($formationS[0]["Niveau"] == "avance") { echo "selected"; }?>>avancé</option>
            </select>

            <label>Secteur :</label>
            <input type="text" name="secteur" required value="<?php echo htmlentities($formationS[0]["Secteur"]) ?>">

            <label>Date de début :</label>
            <input type="datetime-local" name="datedebut" required value="<?php echo htmlentities($formationS[0]["PlanningDebut"]) ?>">

            <label>Date de fin :</label>
            <input type="datetime-local" name="datefin" required value="<?php echo htmlentities($formationS[0]["PlanningFin"]) ?>">

            <label>Lieu :</label>
            <input type="text" name="lieu" required value="<?php echo htmlentities($formationS[0]["Lieu"]) ?>">

            <label>Capacité d'accueil :</label>
            <input type="number" name="capacite" required value="<?php echo htmlentities($formationS[0]["Capacite"]) ?>">

            <label>Formateurs (2 ou plus): </label>
            <br>
            <i><small>Maintenez CTRL (ou CMD sur Mac) pour sélectionner plusieurs formateurs</small></i>

            <select name="formateur_id[]" required multiple>
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
            <input type="text" name="materiel" placeholder="Facultatif" value="<?php echo htmlentities($formationS[0]["Materiel"]) ?>">

            <label>Coût :</label>
            <input type="number" name="cout" step="0.01" placeholder="En euro" required value="<?php echo htmlentities($formationS[0]["Cout"]) ?>">

            <label>Modalité d'inscription :</label>
            <input type="text" name="modalite" placeholder="Facultatif" value="<?php echo htmlentities($formationS[0]["Modalite"]) ?>">

            <label>Commentaire :</label>
            <input type="text" name="commentaire" placeholder="Facultatif" value="<?php echo htmlentities($formationS[0]["Commentaire"]) ?>">

            <label>Support de formation (lien) :</label>
            <input type="text" name="support" placeholder="Facultatif" value="<?php echo htmlentities($formationS[0]["Support"]) ?>">

            <input type="hidden" name="standard" value="1">

            <input type="hidden" name="id" value="<?php echo $id ?>"/>
            <input type="hidden" name="token" value="<?php echo $token; ?>">

            <button type="submit" class="btn3">Enregistrer</button>
            <a href="./mes_creations.php" class="btn">Annuler</a>
        </form>
    </div>
    <?php
}
else
{
    // Envoie de la requête SQL
    $req = $pdo->prepare("SELECT * FROM online WHERE Id = :id");
    $req->bindParam(':id', $id);
    $req->execute();

    $online = $req->fetchAll();

    // vérification de l'unicité de la formation
    if(count($online)!=1){
        http_response_code(404);
        die("Pas de demande de formation pour l'id ".$id);
    }

    $req = $pdo->prepare("SELECT * FROM formateur WHERE Id = :formateur_id");
    $req->bindParam(':formateur_id', $online["Formateur_Id"]);
    $req->execute();

    $formateur = $req->fetchAll();

    ?>

    <div class="container">
        <form action="../actions/updateFormation.php" method="post">
            <h2>Modifier la formation :</h2>
            <br>
            <label>Titre :</label>
            <input type="text" name="titre" maxlength="50" required value="<?php echo htmlentities($online[0]["Titre"]) ?>">

            <label>Description:</label>
            <input type="text" name="description" required value="<?php echo htmlentities($online[0]["Description"]) ?>">

            <label>Durée :</label>
            <input type="number" name="duree" placeholder="En heures" required value="<?php echo htmlentities($online[0]["Duree"]) ?>">

            <label>Niveau :</label>
            <select name="niveau" required>
                <option>-- Définissez un niveau d'expertise --</option>
                <option value="debutant" <?php if ($online[0]["Niveau"] == "debutant") { echo "selected"; }?>>débutant</option>
                <option value="intermediaire" <?php if ($online[0]["Niveau"] == "intermediaire") { echo "selected"; }?>>intermédiaire</option>
                <option value="avance" <?php if ($online[0]["Niveau"] == "avance") { echo "selected"; }?>>avancé</option>
            </select>

            <label>Date et heure :</label>
            <input type="datetime-local" name="dateheure" required value="<?php echo htmlentities($online[0]["DateHeure"]) ?>">

            <label>Lien (URL) :</label>
            <input type="url" name="url" required value="<?php echo htmlentities($online[0]["URL"]) ?>">

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
                    if ($formateur[$i]['Id'] == $online[0]["Formateur_Id"]) { $form = "selected"; } else { $form = ""; }

                    echo '<option '.$form.' value="' . $formateur[$i]['Id'] . '">' . htmlentities($formateur[$i]['Nom']) . ' ' . htmlentities($formateur[$i]['Prenom']) . '</option>';
                }
                ?>
            </select>

            <label>Secteur :</label>
            <input type="text" name="secteur" required value="<?php echo htmlentities($online[0]["Secteur"]) ?>">
            <input type="hidden" name="standard" value="0">

            <input type="hidden" name="id" value="<?php echo $id ?>"/>
            <input type="hidden" name="token" value="<?php echo $token; ?>">

            <button type="submit" class="btn3">Enregistrer</button>
            <a href="./mes_creations.php" class="btn">Annuler</a>
        </form>
    </div>
    <?php
}
?>

<?php include "../includes/footer.php"; ?>

