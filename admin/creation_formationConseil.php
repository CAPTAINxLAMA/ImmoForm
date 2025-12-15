<?php include '../includes/header.php';

session_start(); //permet d'initialiser un session pour enregistrer côté serveur le token envoyé à l'utilisateur

$token = rand(0, 1000000); //génération d'un token aléatoire
$_SESSION['token'] = $token; //stockage d'u token généré

?>

<main>
    <div class="container">
        <form method="POST">
            <label>Titre :</label>
            <input type="text" name="text" required>

            <label>Description Détaillée :</label>
            <input type="text" name="text" required>

            <label>Durée :</label>
            <input type="text" name="text" required>

            <label>Date :</label>
            <input type="text" name="readonly" readonly>

            <label>Coût :</label>
            <input type="text" name="text">

            <label>Commentaire :</label>
            <input type="text" name="text">

            <label>Support :</label>
            <input type="text" name="text">

            <label>Lieu :</label>
            <input type="text" name="text">

            <button type="submit">Créer la formation</button>
            <br>
            <br>
        </form>
        <a href="navbar.php" class='btn'>Accueil</a>
    </div>
</main>

<?php  include '../includes/footer.php'?>
