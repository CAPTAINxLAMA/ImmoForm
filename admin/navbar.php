<?php include '../includes/header.php';

session_start(); //permet d'initialiser un session pour enregistrer côté serveur le token envoyé à l'utilisateur

$token = rand(0, 1000000); //génération d'un token aléatoire
$_SESSION['token'] = $token; //stockage d'u token généré

?>

<main>
    <div class="container">
        <a class='btn' href="gerer_demandes.php">Gérer les Demandes</a>
        <form method="POST" action="creation_formationConseil.php">
            <input type="hidden" name="token" value="<?php echo $token; ?>">
            <button class='btn' type="submit">Créer une Formation ou un Conseil</button>
        </form>
        <a class='btn' href="mes_creation.php">Voir mes Formations et mes Conseils</a>
    </div>
</main>

<?php include '../includes/footer.php'?>
