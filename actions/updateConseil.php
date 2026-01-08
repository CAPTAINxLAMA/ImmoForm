<?php
session_start();
$tokenServeur= $_SESSION['token'];
$tokenRecu=filter_input(INPUT_POST, 'token', FILTER_DEFAULT);

//je vérifie la cohérence des tokens
if($tokenRecu != $tokenServeur){
    die("Erreur de token. Va mourir vilain hacker.");//je stoppe tout
}

//on récupère les données du POST
$titre = filter_input(INPUT_POST, 'titre', FILTER_DEFAULT);
$description = filter_input(INPUT_POST, 'description', FILTER_DEFAULT);
$duree = filter_input(INPUT_POST, 'duree', FILTER_DEFAULT);
$cout = filter_input(INPUT_POST, 'cout', FILTER_DEFAULT);
$commentaire = filter_input(INPUT_POST, 'commentaire', FILTER_DEFAULT);
$support = filter_input(INPUT_POST, 'support', FILTER_DEFAULT);
$lieu = filter_input(INPUT_POST, 'lieu', FILTER_DEFAULT);
$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

// Connexion à la base de données
include "../includes/config.php";
$pdo = new PDO("mysql:host=".config::host.";dbname=".config::dbname, config::user, config::password);

// Envoie de la requête SQL
$req = $pdo->prepare("UPDATE conseil SET Titre=:titre, Description=:description, Duree=:duree, Cout=:cout, Commentaire=:commentaire, Support=:support, Lieu=:lieu WHERE id=:id");
$req->bindParam(':titre', $titre);
$req->bindParam(':description', $description);
$req->bindParam(':duree', $duree);
$req->bindParam(':cout', $cout);
$req->bindParam(':commentaire', $commentaire);
$req->bindParam(':support', $support);
$req->bindParam(':lieu', $lieu);
$req->bindParam(':id', $id);
$req->execute();

header("Location: ../admin/mes_creations.php");

