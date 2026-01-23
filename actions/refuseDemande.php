<?php
session_start();
$tokenServeur = $_SESSION['token'];
$tokenRecu = filter_input(INPUT_POST, 'token', FILTER_VALIDATE_INT);

// Vérification la cohérence des tokens
if($tokenRecu != $tokenServeur)
{
    die("Erreur de token. Va mourir vilain hacker.");
}

$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
$formateur_id = filter_input(INPUT_POST, 'formateur_id', FILTER_VALIDATE_INT);

// Connexion à la base de données
include "../includes/config.php";
$pdo = new PDO("mysql:host=".config::host.";dbname=".config::dbname, config::user, config::password);

// Envoie de la requête SQL
$req = $pdo->prepare('update demande set Statut="Refusé", Formateur_Id=:formateur_id where Id=:id');
$req->bindParam(':id', $id);
$req->bindParam(':formateur_id', $formateur_id);

$req->execute();

header("Location: ../admin/gererDemandes.php");
