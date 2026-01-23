<?php


require '../includes/auth.php';
requireRole('client');

$tokenServeur = $_SESSION['token'];
$tokenRecu = filter_input(INPUT_POST, 'token', FILTER_DEFAULT);

// Vérification la cohérence des tokens
if($tokenRecu != $tokenServeur)
{
    die("Erreur de token. Va mourir vilain hacker.");
}


$id = filter_input(INPUT_POST, 'Id', FILTER_VALIDATE_INT );
$nom = filter_input(INPUT_POST, 'Nom', FILTER_DEFAULT );
$prenom = filter_input(INPUT_POST, 'Prenom', FILTER_DEFAULT );
$numero = filter_input(INPUT_POST, 'Numéro', FILTER_DEFAULT );
$email = filter_input(INPUT_POST, 'Email', FILTER_DEFAULT );
$fonction = filter_input(INPUT_POST, 'Fonction', FILTER_DEFAULT );
$preferenceContact = filter_input(INPUT_POST, 'PreferenceContact', FILTER_DEFAULT );
$commentaire = filter_input(INPUT_POST, 'Commentaire', FILTER_DEFAULT );
$agenceId = filter_input(INPUT_POST, 'Agence_Id', FILTER_VALIDATE_INT );


include "../includes/config.php";
$pdo = new PDO("mysql:host=".config::host.";dbname=".config::dbname, config::user, config::password);

$req = $pdo->prepare("UPDATE contact SET  Nom = :nom, Prenom = :prenom, Numero = :numero, Email = :email, Fonction = :fonction, PreferenceContact = :preferenceContact, Commentaire = :commentaire WHERE Id = :id");
$req->bindParam(':id', $id);
$req->bindParam(':nom', $nom);
$req->bindParam(':prenom', $prenom);
$req->bindParam(':numero', $numero);
$req->bindParam(':email', $email);
$req->bindParam(':fonction', $fonction);
$req->bindParam(':preferenceContact', $preferenceContact);
$req->bindParam(':commentaire', $commentaire);
$req->execute();

$req = $pdo->prepare("UPDATE contact_agence SET  Agence_id = :agenceId WHERE Contact_id = :id");
$req->bindParam(':agenceId', $agenceId);
$req->bindParam(':id', $id);
$req->execute();


header('Location: ../client/navbar.php');