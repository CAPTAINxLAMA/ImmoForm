<?php
global $pdo;
include '../includes/header.php';

session_start();
$token = rand(0, 1000000);
$_SESSION['token'] = $token;

include_once "../includes/config.php";

$pdo = new PDO("mysql:host=".config::host.";dbname=".config::dbname, config::user, config::password);

$req = $pdo->prepare("SELECT Nom, Prenom, Id FROM contact WHERE Email = :email");
$req->bindparam(':email', $_SESSION['user']['email']);
$req->execute();

$row = $req->fetchAll();

?>

<main>
    <div class="container">
        <h2>Un conseil :</h2>
        <br>
        <form action="../actions/NewDemande.php" method="POST">
            <label>Type de demande :</label>
            <input type="text" required maxlength="100" name="type">

            <label>Description de la demande :</label>
            <textarea name="description" rows="5" cols="50" required></textarea>

            <label>Contact de l'agence :</label>
            <input type="text" name="contact_agence" value="<?php echo $row['0']['Nom'] . " " . $row['0']['Prenom']; ?>" readonly>
            <input type="hidden" name="contact_id" value="<?php echo $row['0']['Id']; ?>">

            <label>Agence cliente :</label>
            <select name="agence_id" required>
                <option value="">-- Choisissez une agence --</option>
                <?php
                // Récupérer toutes les agences depuis la base de donnnée
                $req = $pdo->prepare("SELECT Id, Nom FROM agence");
                $req->execute();

                $row = $req->fetchAll();
                for ($i=0; $i < count($row); $i++) {
                    echo '<option value="' . $row[$i]['Id'] . '">' . htmlentities($row[$i]['Nom']) . '</option>';
                }
                ?>
            </select>

            <input type="hidden" name="date_demande" value="<?php echo date('Y-m-d'); ?>">

            <input type="hidden" name="token" value="<?php echo $token; ?>">
            <br>
            <br>
            <input CLASS="btn" type="submit" value="Envoyer">
        </form>
    </div>
</main>

<?php include '../includes/footer.php'; ?>
