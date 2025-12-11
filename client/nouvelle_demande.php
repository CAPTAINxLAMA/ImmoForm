<?php include '../includes/header.php';

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
