<?php include '../includes/header.php';

session_start();
$tokenServeur = $_SESSION['token'];
$tokenRecu = filter_input(INPUT_POST, 'token', FILTER_DEFAULT);

//Je vérifie la cohérence des tokens
if ($tokenRecu != $tokenServeur) {
    die("Erreur de token. Vas mourir vilain hacker");//je stop tout
}
?>

<main>
    <div class="container">
        <form method="POST">
            <label>Type de demande :</label>
            <input type="text" name="text" required>

            <label>Type de conseil :</label>
            <input type="text" name="text" required>

            <label>Description détaillée de la demande :</label>
            <input type="text" name="text" required>

            <label>Date de la demande :</label>
            <input type="text" name="readonly" readonly>

            <label>Contact de l'agence :</label>
            <input type="text" name="text">

            <label>Agence cliente:</label>
            <input type="text" name="text">


        </form>

    </div>
</main>

<?php  include '../includes/footer.php'?>
