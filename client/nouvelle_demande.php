<?php
include '../includes/header.php';

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
// Récupérer l'agence du contact
// =====================
// Remplace 2 par l'ID du contact connecté, par exemple $_SESSION['contact_id']
$contact_id = 2;

$stmt = $pdo->prepare("
    SELECT a.Id AS agence_id, a.Nom AS nom_agence
    FROM contact c
    JOIN agence a ON c.Agence_id = a.Id
    WHERE c.Id = :contact_id
");
$stmt->execute([':contact_id' => $contact_id]);

$agence = $stmt->fetch(PDO::FETCH_ASSOC);

if ($agence === false) {
    // Aucun résultat trouvé, définir des valeurs par défaut
    $agence_nom = "Agence non trouvée";
    $agence_id_val = 0;
} else {
    $agence_nom = $agence['nom_agence'];
    $agence_id_val = $agence['agence_id'];
}


// =====================
// Traitement du formulaire
// =====================
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $type_demande = $_POST['type_demande'];
    $type_conseil = $_POST['type_conseil'];
    $description = $_POST['description'];
    $date_demande = $_POST['date_demande'];
    $agence_id_post = $_POST['agence_id']; // envoyé par le champ hidden

    $contact_id_post = 0; // par défaut
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
            <label>Type de demande :</label>
            <input type="text" name="type_demande" required>

            <label>Type de conseil :</label>
            <input type="text" name="type_conseil" required>

            <label>Description détaillée de la demande :</label>
            <input type="text" name="description" required>

            <label>Date de la demande :</label>
            <input type="date" name="date_demande" value="<?php echo date('Y-m-d'); ?>" readonly>

            <label>Contact de l'agence :</label>
            <input type="text" name="contact_agence">

            <label>Agence cliente :</label>
            <input type="text" name="agence_nom" value="<?php echo htmlspecialchars($agence_nom); ?>" readonly>
            <input type="hidden" name="agence_id" value="<?php echo $agence_id_val; ?>">

            <label>Statut :</label>
            <input type="text" name="statut" value="En attente" readonly>

            <br><br>
            <input type="submit" value="Envoyer">
        </form>
    </div>
</main>

<?php include '../includes/footer.php'; ?>
