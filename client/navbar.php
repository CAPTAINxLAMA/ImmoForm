<?php include '../includes/header.php';

session_start(); //permet d'initialiser un session pour enregistrer côté serveur le token envoyé à l'utilisateur

$token = rand(0, 1000000); //génération d'un token aléatoire
$_SESSION['token'] = $token; //stockage d'u token généré

?>

<main>
    <div class="container">
        <a class='btn' href="nouvelle_demande.php">Faire une Demande de Formation</a>
        <a class='btn' href="mes_demandes.php">Mes Demandes</a>
    </
    </div>
</main>

<?php  include '../includes/footer.php'?>