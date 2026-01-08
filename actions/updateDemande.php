<?php
session_start();
$tokenServeur = $_SESSION['token'];
$tokenRecu = filter_input(INPUT_POST, 'token', FILTER_DEFAULT);

// Vérification la cohérence des tokens
if($tokenRecu != $tokenServeur)
{
    die("Erreur de token. Va mourir vilain hacker.");
}

//on récupère les données du POST
$id=filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
$type=filter_input(INPUT_POST, 'type', FILTER_DEFAULT);
$description=filter_input(INPUT_POST, 'description', FILTER_DEFAULT);

// Connexion à la base de données
include "../includes/config.php";
$pdo = new PDO("mysql:host=".config::host.";dbname=".config::dbname, config::user, config::password);

// Envoie de la requête SQL
$req = $pdo->prepare("UPDATE demandeconseil SET type=:type, description=:description WHERE id=:id");
$req->bindParam(':type', $type);
$req->bindParam(':description', $description);
$req->bindParam(':id', $id);
$req->execute();

header("Location: ../client/mes_demandes.php");
