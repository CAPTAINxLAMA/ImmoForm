
<?php include '../includes/header.php';

session_start(); //permet d'initialiser un session pour enregistrer côté serveur le token envoyé à l'utilisateur

$token = rand(0, 1000000); //génération d'un token aléatoire
$_SESSION['token'] = $token; //stockage d'u token généré

?>

<main>
    <div class="container">
        <a class='btn' href="creation_formationConseil.php">Gérer les demandes de formations</a>
        <a class='btn' href="mes_creation.php">Mes formations</a>
        <a class='btn' href="creation_formationConseil.php">Créer une formation</a>
    </div>
</main>

<?php include '../includes/footer.php'?>
