<?php
include '../includes/header.php';

session_start();

if (!isset($_SESSION['user'])) { // si la session utilisateur n'est pas définie, il l'éjecte
    header('Location: ../includes/connexion.php');
    exit;
}

// =====================
// Connexion à la base de données
// =====================
$host = '127.0.0.1';
$db   = 'immoform1';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

try {
    $pdo = new PDO($dsn, $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

// =====================
// ID du contact connecté (à adapter si tu as une session)
// =====================
$contact_id = 2; // par exemple $_SESSION['contact_id']

// =====================
// Récupérer l'agence de ce contact
// =====================
$stmt = $pdo->prepare("
    SELECT a.Id AS agence_id, a.Nom AS nom_agence
    FROM contact c
    JOIN agence a ON c.Agence_id = a.Id
    WHERE c.Id = :contact_id
");
$stmt->execute([':contact_id' => $contact_id]);
$agence = $stmt->fetch(PDO::FETCH_ASSOC);

if ($agence === false) {
    // Aucun résultat trouvé, valeurs par défaut
    $agence_nom = "Agence non trouvée";
    $agence_id_val = 0;
} else {
    $agence_nom = $agence['nom_agence'];
    $agence_id_val = $agence['agence_id'];
}

// =====================
// Récupérer le contact principal de l'agence
// =====================
$stmt_contact = $pdo->prepare("
    SELECT Id, Nom, Prenom
    FROM contact
    WHERE Agence_id = :agence_id
    LIMIT 1
");
$stmt_contact->execute([':agence_id' => $agence_id_val]);
$contact = $stmt_contact->fetch(PDO::FETCH_ASSOC);

if ($contact === false) {
    $contact_nom_prenom = "Contact non trouvé";
    $contact_id_val = 0;
} else {
    $contact_nom_prenom = $contact['Nom'] . ' ' . $contact['Prenom'];
    $contact_id_val = $contact['Id'];
}

// =====================
// Traitement du formulaire
// =====================
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $type_demande = $_POST['type_demande'];
    $type_conseil = $_POST['type_conseil'];
    $description = $_POST['description'];
    $date_demande = $_POST['date_demande'];
    $agence_id_post = $_POST['agence_id'];      // ID envoyé via champ hidden
    $contact_id_post = $_POST['contact_id'];    // ID du contact envoyé via champ hidden

    $formateur_id = 0;
    $statut = 'En attente';

    $stmt = $pdo->prepare("
        INSERT INTO demandeconseil 
        (Type, Description, Date, Agence_id, Contact_id, Statut, Formateur_id) 
        VALUES 
        (:type, :description, :date, :agence_id, :contact_id, :statut, :formateur_id)
    ");

    $stmt->execute([
            ':type' => $type_demande,
            ':description' => $description,
            ':date' => $date_demande,
            ':agence_id' => $agence_id_post,
            ':contact_id' => $contact_id_post,
            ':statut' => $statut,
            ':formateur_id' => $formateur_id
    ]);

    echo "<p style='color:green;'>Demande ajoutée avec succès !</p>";
}
?>
<main>
    <div class="container">
        <form method="POST">
            <!-- Champ pour le type de demande -->
            <label>Type de demande:</label>
            <input type="text" name="type_demande" required>


            <!-- Champ pour la description -->
            <label>Description détaillée de la demande :</label>
            <textarea name="description" rows="5" cols="50" required></textarea>


            <!-- Affichage automatique du contact de l'agence -->
            <label>Contact de l'agence :</label>
            <input type="text" name="contact_agence" value="<?php echo htmlspecialchars($contact_nom_prenom); ?>" readonly>
            <input type="hidden" name="contact_id" value="<?php echo $contact_id_val; ?>">

            <!-- Affichage automatique du nom de l'agence -->
            <label>Agence cliente :</label>
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

            <br><br>
            <input type="submit" value="Envoyer">
        </form>
    </div>
</main>

<?php include '../includes/footer.php'; ?>
