<?php include "../includes/header.php";

session_start();

$tokenServeur = $_SESSION['token'];
$tokenRecu = filter_input(INPUT_POST, 'token', FILTER_DEFAULT);

//Je vérifie la cohérence des tokens
if ($tokenRecu != $tokenServeur) {
    die("Erreur de token. Vas mourir vilain hacker");
}

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
            <input type="date" name="readonly">

            <label>Coût :</label>
            <input type="text" name="text">

            <label>Commentaire :</label>
            <input type="text" name="text" placeholder="Factultatif">

            <label>Support :</label>
            <input type="text" name="text" placeholder="Factultatif">

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
