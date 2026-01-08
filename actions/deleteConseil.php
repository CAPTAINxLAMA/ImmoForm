<?php
session_start();
$tokenServeur = $_SESSION['token'];
$tokenRecu = filter_input(INPUT_POST, 'token', FILTER_DEFAULT);

// Vérification la cohérence des tokens
if($tokenRecu != $tokenServeur)
{
    die("Erreur de token. Va mourir vilain hacker.");
}

// Récupération les données du POST
$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

// Connexion à la base de données
include "../includes/config.php";
$pdo = new PDO("mysql:host=".config::host.";dbname=".config::dbname, config::user, config::password);

// Envoie de la requête SQL
$req = $pdo->prepare("delete from conseil where Id=:id");
$req->bindParam(':id', $id);
$req->execute();

header("Location: ../Admin/mes_creations.php");
