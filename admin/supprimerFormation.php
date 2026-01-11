<?php
include('../includes/header.php');

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
    // Envoie de la requête SQL
    $req = $pdo->prepare("SELECT * FROM standard WHERE Id = :id");
    $req->bindParam(':id', $id);
    $req->execute();

    $standard = $req->fetchAll();

    // vérification de l'unicité de la formation
    if(count($standard)!=1){
        http_response_code(404);
        die("Pas de demande de formation pour l'id ".$id);
    }
    ?>
    <div class="container">
        <h2>Supprimer la formation :</h2>
        <br>
        <form action="../actions/deleteFormation.php" method="POST">

            <label><b>Titre</b> <?php echo htmlentities($standard[0]["Titre"]) ?></label><br><br>
            <label><b>Description</b> <?php echo htmlentities($standard[0]["Description"]) ?></label><br><br>
            <label><b>Durée</b> <?php echo htmlentities($standard[0]["Duree"]) ?></label><br><br>
            <label><b>Niveau</b> <?php echo htmlentities($standard[0]["Niveau"]) ?></label><br><br>
            <label><b>Secteur</b> <?php echo htmlentities($standard[0]["Secteur"]) ?></label><br><br>
            <label><b>Date de début</b> <?php echo htmlentities($standard[0]["PlanningDebut"]) ?></label><br><br>
            <label><b>Date de fin</b> <?php echo htmlentities($standard[0]["PlanningFin"]) ?></label><br><br>
            <label><b>Lieu</b> <?php echo htmlentities($standard[0]["Lieu"]) ?></label><br><br>
            <label><b>Capacité d'accueil</b> <?php echo htmlentities($standard[0]["Capacite"]) ?></label><br><br>
            <label><b>Formateurs</b>
                <?php
                $reqLink = $pdo->prepare("SELECT formateur.Nom, formateur.Prenom FROM association_standard JOIN formateur ON association_standard.Formateur_id = formateur.Id WHERE association_standard.Standard_id = :Standard_id");
                $reqLink->bindParam( ':Standard_id', $id);
                $reqLink->execute();

                $formateurs = $reqLink->fetchAll();
                foreach ($formateurs as $formateur)
                {
                    echo htmlentities($formateur["Nom"]).' '.htmlentities($formateur["Prenom"]);
                }
                ?>
            </label><br><br>
            <label><b>Matériels</b> <?php echo htmlentities($standard[0]["Materiel"]) ?></label><br><br>
            <label><b>Coûts</b> <?php echo htmlentities($standard[0]["Cout"]) ?></label><br><br>
            <label><b>Modalité d'inscription</b> <?php echo htmlentities($standard[0]["Modalite"]) ?></label><br><br>
            <label><b>Commentaire</b> <?php echo htmlentities($standard[0]["Commentaire"]) ?></label><br><br>
            <label><b>Support de formation</b> <?php echo htmlentities($standard[0]["Support"]) ?></label><br><br>

            <br> <input type="hidden" name="id" value="<?php echo $id ?>"/>
            <br> <input type="hidden" name="standard" value="1"/>
            <input type="hidden" name="token" value="<?php echo $token; ?>">

            <button type="submit" class="btn2">Supprimer</button>
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

    $req = $pdo->prepare("SELECT Nom, Prenom FROM formateur WHERE Id = :formateur_id");
    $req->bindParam(':formateur_id', $online[0]["Formateur_Id"]);
    $req->execute();

    $formateur = $req->fetchAll();
    ?>
    <div class="container">
        <h2>Supprimer la formation :</h2>
        <br>
        <form action="../actions/deleteFormation.php" method="POST">

            <label><b>Titre</b> <?php echo htmlentities($online[0]["Titre"]) ?></label><br><br>
            <label><b>Description</b> <?php echo htmlentities($online[0]["Description"]) ?></label><br><br>
            <label><b>Durée</b> <?php echo htmlentities($online[0]["Duree"]) ?></label><br><br>
            <label><b>Niveau</b> <?php echo htmlentities($online[0]["Niveau"]) ?></label><br><br>
            <label><b>Secteur</b> <?php echo htmlentities($online[0]["Secteur"]) ?></label><br><br>
            <label><b>Horaire</b> <?php echo htmlentities($online[0]["DateHeure"]) ?></label><br><br>
            <label><b>Lien</b> <?php echo htmlentities($online[0]["URL"]) ?></label><br><br>
            <label><b>Formateur</b> <?php echo htmlentities($formateur[0]["Nom"]).' '.htmlentities($formateur[0]["Prenom"]); ?></label><br><br>

            <br> <input type="hidden" name="id" value="<?php echo $id ?>"/>
            <br> <input type="hidden" name="standard" value="0"/>
            <input type="hidden" name="token" value="<?php echo $token; ?>">

            <button type="submit" class="btn2">Supprimer</button>
            <a href="./mes_creations.php" class="btn">Annuler</a>
        </form>
    </div>
    <?php
}
?>

<?php include "../includes/footer.php"; ?>

