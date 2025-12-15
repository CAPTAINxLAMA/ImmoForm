<?php
global $pdo;
include '../includes/header.php';

session_start();
$token = rand(0, 1000000);
$_SESSION['token'] = $token;

include "../includes/config.php";
?>
<main>
    <div class="container">
        <form action="../actions/NewDemande.php" method="POST">
            <!-- Champ pour le type de demande -->
            <label>Type de demande :</label>
            <input type="text" required maxlength="100" name="Type">


            <!-- Champ pour la description -->
            <label>Description détaillée de la demande :</label>
            <textarea name="Description" rows="5" cols="50" required></textarea>


            <!-- Affichage automatique du contact de l'agence -->
            <label>Contact de l'agence :</label>
            <input type="text" name="contact_agence" value="<?php echo 'epsiadmin'; ?>" readonly>
            <input type="hidden" name="contact_id" value="<?php echo 1 ; ?>">

            <!-- Affichage automatique du nom de l'agence -->
            <label>Agence cliente :</label>
            <select name="agence_id" required>
                <option value="">-- Choisissez une agence --</option>
                <?php
                // Récupérer toutes les agences depuis la base
                $result = $pdo->query("SELECT Id, Nom FROM agence");
                while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                    echo '<option value="' . $row['Id'] . '">' . htmlspecialchars($row['Nom']) . '</option>';
                }
                ?>
            </select>

            <!-- Champs cachés pour la date et le statut -->
            <input type="hidden" name="date_demande" value="<?php echo date('Y-m-d'); ?>">
            <input type="hidden" name="statut" value="En attente">

            <input type="hidden" name="token" value="<?php echo $token; ?>">

            <br><br>
            <input CLASS="btn" type="submit" value="Envoyer">
        </form>
    </div>
</main>

<?php include '../includes/footer.php'; ?>
