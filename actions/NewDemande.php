<?php
session_start();
$tokenServeur = $_SESSION['token'];
$tokenRecu = filter_input(INPUT_POST, 'token', FILTER_DEFAULT);

//Je vérifie la cohérence des tokens
if ($tokenRecu != $tokenServeur) {
    die("Erreur de token. Vas mourir vilain hacker");//je stop tout
}

//on récupère les données du POST
$type=filter_input(INPUT_POST,'type',FILTER_DEFAULT);
$description=filter_input(INPUT_POST,'description',FILTER_DEFAULT);
$agence_id=filter_input(INPUT_POST,'agence_id',FILTER_VALIDATE_INT);
$contact_id=filter_input(INPUT_POST,'contact_id',FILTER_VALIDATE_INT);
$contact_id=filter_input(INPUT_POST,'date_demande',FILTER_VALIDATE_INT);

include "../includes/config.php";
$pdo = new PDO('mysql:host=' . config::host . ';dbname=' . config::dbname , config::user, config::password);


//on prépare la requète avec des bindParam pour éviter les injections SQL
$req=$pdo->prepare("INSERT INTO demandeconseil (Type,Description,Contact_Id,Agence_Id) VALUES (:Type, :Description, :Contact_Id, :Agence_Id)");
$req->bindParam(':Type', $type);
$req->bindParam(':Description', $description);
$req->bindParam(':Agence_Id', $agence_id, PDO::PARAM_INT);
$req->bindParam(':Contact_Id', $contact_id, PDO::PARAM_INT);

$req->execute();

//retour à la page d'accueil
header("Location: ../client/navbar.php");