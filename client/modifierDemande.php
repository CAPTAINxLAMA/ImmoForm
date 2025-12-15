<?php
session_start();


include('../includes/header.php');
include_once('../includes/config.php');


// Création du token CSRF
$token = rand(0, 1000000);
$_SESSION['token'] = $token;


//on récupère l'id
$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
if (!$id) {
    http_response_code(404);
    die("ID manquant ou invalide");
}


//je vais chercher la catégorie à modifier
// Connexion à la base de données
$pdo = new PDO("mysql:host=".config::host.";dbname=".config::dbname, config::user, config::password);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$req=$pdo->prepare("select * from demandeconseil where id=:id");
$req->bindParam(':id', $id);
$req->execute();
$demandeconseil=$req->fetchAll();
//je vérifie que j'en ai bien récupéré une seule
if(count($demandeconseil)!=1){
    //on renvoie une erreur 404
    http_response_code(404);
    die("pas de demande conseil pour l'id ".$id);
}
$demandeconseil=$demandeconseil[0];//je récupère la catégorie à modifier
?>

<h1>Modifier la demande</h1>

<form action="../actions/updateDemande.php" method="post" class="mt-3">
    <input type="hidden" name="id" value="<?php echo $id ?>" />
    <div class="mb-3">
        <label for="titre" class="form-label">Titre</label>
        <input
            id="titre"
            value="<?php echo htmlentities($demandeconseil["Type"]) ?>"
            type="text" required maxlength="50" name="titre" class="form-control">
    </div>
    <div class="mb-3">
        <label for="Description" class="form-label">Description</label>
        <textarea id="Description" name="Description" class="form-control" rows="4"><?php echo htmlentities($demandeconseil["Description"]) ?></textarea>
    </div>
    <!--j'envoie le token dans l'HTML du formulaire-->
    <input type="hidden" name="token" value="<?php echo $token; ?>">
    <button type="submit" class="btn btn-primary">Enregistrer</button>
    <a href="../index.php" class="btn btn-secondary">Annuler</a>
</form>

<?php
include "../includes/footer.php";
?>
