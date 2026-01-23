<?php
session_start();
$tokenServeur = $_SESSION['token'];
$tokenRecu = filter_input(INPUT_POST, 'token', FILTER_VALIDATE_INT);

// Vérification la cohérence des tokens
if($tokenRecu != $tokenServeur)
{
    die("Erreur de token. Va mourir vilain hacker.");
}

// Connexion à la base de données
include "../includes/config.php";
$pdo = new PDO("mysql:host=".config::host.";dbname=".config::dbname, config::user, config::password);

$titre = filter_input(INPUT_POST, 'titre', FILTER_DEFAULT);
$description = filter_input(INPUT_POST, 'description', FILTER_DEFAULT);
$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
$duree = filter_input(INPUT_POST, 'duree', FILTER_VALIDATE_INT);
$date = date("Y-m-d-H-m-s");
$formateur_Id = filter_input(INPUT_POST, 'formateur_id', FILTER_VALIDATE_INT);
$cout = filter_input(INPUT_POST, 'cout', FILTER_DEFAULT);
$commentaire = filter_input(INPUT_POST, 'commentaire', FILTER_DEFAULT);
$support = filter_input(INPUT_POST, 'support', FILTER_DEFAULT);
$lieu = filter_input(INPUT_POST, 'lieu', FILTER_DEFAULT);

// Envoie de la requête SQL
$req = $pdo->prepare("INSERT INTO conseil (Titre, Description, Demande_id, Duree, Date, Cout, Commentaire, Support, Lieu) VALUES (:titre, :description, :demande_Id, :duree, :date, :cout, :commentaire, :support, :lieu)");
$req->bindParam(':titre', $titre);
$req->bindParam(':description', $description);
$req->bindParam(':demande_Id', $id);
$req->bindParam(':duree', $duree);
$req->bindParam(':date', $date);
$req->bindParam(':cout', $cout);
$req->bindParam(':commentaire', $commentaire);
$req->bindParam(':support', $support);
$req->bindParam(':lieu', $lieu);
$req->execute();

$conseil_Id = $pdo->lastInsertId();

$req = $pdo->prepare("INSERT INTO formateur_conseil (Formateur_id, Conseil_id) VALUES (:formateur_Id, )");
$req->bindParam(':formateur_Id', $formateur_Id);
$req->bindParam(':conseil_Id', $conseil_Id);
$req->execute();


header("Location: ../admin/mes_creations.php");
