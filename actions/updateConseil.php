
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
$Date = date("Y-m-d-H-m-s");
$Cout = filter_input(INPUT_POST, 'cout', FILTER_DEFAULT);
$Commentaire = filter_input(INPUT_POST, 'commentaire', FILTER_DEFAULT);
$Support = filter_input(INPUT_POST, 'support', FILTER_DEFAULT);
$Lieu = filter_input(INPUT_POST, 'lieu', FILTER_DEFAULT);
$id=filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

include "../includes/config.php";
$pdo = new PDO("mysql:host=".config::host.";dbname=".config::dbname, config::user, config::password);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

//on prépare la requête avec des bindParam pour éviter les injections SQL
$req=$pdo->prepare("INSERT INTO conseil (Titre, Description, Duree, Date, Cout, Commentaire, Support, Lieu, id) VALUES (:Titre, :Description, :Duree, :Date, :Cout, :Commentaire, :Support, :Lieu, :id)");
$req->bindParam(':Titre', $Titre);
$req->bindParam(':Description', $Description);
$req->bindParam(':Duree', $Duree);
$req->bindParam(':Date', $Date);
$req->bindParam(':Cout', $Cout);
$req->bindParam(':Commentaire', $Commentaire);
$req->bindParam(':Support', $Support);
$req->bindParam(':Lieu', $Lieu);
$req->bindParam(':id', $id);
$req->execute();

//retour à la page d'accueil
header("Location: ../admin/navbar.php");

