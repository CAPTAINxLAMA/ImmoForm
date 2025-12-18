
<?php
session_start();
$tokenServeur= $_SESSION['token'];
$tokenRecu=filter_input(INPUT_POST, 'token', FILTER_DEFAULT);

//je vérifie la cohérence des tokens
if($tokenRecu != $tokenServeur){
    die("Erreur de token. Va mourir vilain hacker.");//je stoppe tout
}

//on récupère les données du POST
$Titre = filter_input(INPUT_POST, 'titre', FILTER_DEFAULT);
$Description = filter_input(INPUT_POST, 'description', FILTER_DEFAULT);
$Duree = filter_input(INPUT_POST, 'duree', FILTER_DEFAULT);
$Cout = filter_input(INPUT_POST, 'cout', FILTER_DEFAULT);
$Commentaire = filter_input(INPUT_POST, 'commentaire', FILTER_DEFAULT);
$Support = filter_input(INPUT_POST, 'support', FILTER_DEFAULT);
$Lieu = filter_input(INPUT_POST, 'lieu', FILTER_DEFAULT);
$id=filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

include "../includes/config.php";
$pdo = new PDO("mysql:host=".config::host.";dbname=".config::dbname, config::user, config::password);

$req=$pdo->prepare("UPDATE conseil SET Titre=:Titre, Description=:Description, Duree=:Duree, Cout=:Cout, Commentaire=:Commentaire, Support=:Support, Lieu=:Lieu WHERE id=:id");
$req->bindParam(':Titre', $Titre);
$req->bindParam(':Description', $Description);
$req->bindParam(':Duree', $Duree);
$req->bindParam(':Cout', $Cout);
$req->bindParam(':Commentaire', $Commentaire);
$req->bindParam(':Support', $Support);
$req->bindParam(':Lieu', $Lieu);
$req->bindParam(':id', $id);
$req->execute();

header("Location: ../admin/mes_creations.php");

