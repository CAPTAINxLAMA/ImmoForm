<?php include '../includes/header.php';

?>

<main>
    <div class="container">
        <form method="POST">
            <label>Type de demande :</label>
            <input type="text" name="type_demande" required>

            <label>Type de conseil :</label>
            <input type="text" name="type_conseil" required>

            <label>Description détaillée de la demande :</label>
            <input type="text" name="description" required>

            <label>Date de la demande :</label>
            <input type="date" name="date_demande" value="<?php echo date('Y-m-d'); ?>" readonly>


            <label>Contact de l'agence :</label>
            <input type="text" name="text">

            <label>Agence cliente :</label>
            <input type="text" name="text">

            <label>Statut :</label>
            <input type="text" name="text">


        </form>

    </div>
</main>

<?php  include '../includes/footer.php'?>
