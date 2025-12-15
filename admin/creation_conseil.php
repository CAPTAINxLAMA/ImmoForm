<?php include "../includes/header.php";

require '../includes/auth.php';

requireRole('admin');

?>

<main>
    <div class="container">
        <h2>Un conseil :</h2>
        <br>
        <form method="POST" action="../actions/">
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

            <input type="hidden" name="token" value="<?php echo $token; ?>">
            <button type="submit">Créer le conseil</button>
            <br>
        </form>
        <a href="navbar.php" class='btn'>Accueil</a>
    </div>
</main>

<?php  include '../includes/footer.php'?>
