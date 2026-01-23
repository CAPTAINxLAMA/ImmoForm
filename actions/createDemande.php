<?php
session_start();
$tokenServeur = $_SESSION['token'];
$tokenRecu = filter_input(INPUT_POST, 'token', FILTER_VALIDATE_INT);

// Vérification la cohérence des tokens
if($tokenRecu != $tokenServeur)
{
    die("Erreur de token. Va mourir vilain hacker.");
}

//on récupère les données du POST
$type = filter_input(INPUT_POST,'type',FILTER_DEFAULT);
$description = filter_input(INPUT_POST,'description',FILTER_DEFAULT);
$agence_id = filter_input(INPUT_POST,'agence_id',FILTER_VALIDATE_INT);
$contact_id = filter_input(INPUT_POST,'contact_id',FILTER_VALIDATE_INT);
$date = date('Y-m-d');

// Connexion à la base de données
include "../includes/config.php";
$pdo = new PDO("mysql:host=".config::host.";dbname=".config::dbname, config::user, config::password);

// Envoie de la requête SQL
$req = $pdo->prepare("INSERT INTO demandes (Type, Description, Contact_Id, Agence_Id, Date, Statut) VALUES (:type, :description, :contact_Id, :agence_Id, :date, 'En attente')");
$req->bindParam(':type', $type);
$req->bindParam(':description', $description);
$req->bindParam(':agence_Id', $agence_id);
$req->bindParam(':contact_Id', $contact_id);
$req->bindParam(':date', $date);
$req->execute();

header("Location: ../client/navbar.php");