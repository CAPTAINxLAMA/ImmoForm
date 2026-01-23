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
$priseEnCharge = filter_input(INPUT_POST, 'formateur_id', FILTER_DEFAULT);

// Connexion à la base de données
include "../includes/config.php";
$pdo = new PDO("mysql:host=".config::host.";dbname=".config::dbname, config::user, config::password);

// Envoie de la requête SQL
$req = $pdo->prepare('UPDATE demandes SET Statut="Accepté", Formateur_Id=:priseEnCharge WHERE Id=:id');
$req->bindParam(':id', $id);
$req->bindParam(':priseEnCharge', $priseEnCharge);
$req->execute();

header("Location: ../admin/gererDemandes.php");