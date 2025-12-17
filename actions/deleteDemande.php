
<?php
session_start();
$tokenServeur= $_SESSION['token'];
$tokenRecu=filter_input(INPUT_POST, 'token', FILTER_DEFAULT);

//je vérifie la cohérence des tokens
if($tokenRecu != $tokenServeur){
    die("Erreur de token. Va mourir vilain hacker.");//je stoppe tout
}

//on récupère les données du POST
$titre=filter_input(INPUT_POST, 'titre', FILTER_DEFAULT);
$description=filter_input(INPUT_POST, 'description', FILTER_DEFAULT);
$id=filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

include "../includes/config.php";
$pdo = new PDO("mysql:host=".config::host.";dbname=".config::dbname, config::user, config::password);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

//on prépare la requête avec des bindParam pour éviter les injections SQL
$req=$pdo->prepare("delete from  demandeconseil where Id=:id");
$req->bindParam(':id', $id);

$req->execute();

//retour à la page d'accueil
header("Location: ../client/mes_demandes.php");
