<?php

session_start();
$tokenServeur = $_SESSION['token'];
$tokenRecu = filter_input(INPUT_POST, 'token', FILTER_DEFAULT);

//je vérifie la cohérence des tokens
if($tokenRecu != $tokenServeur){
    die("Erreur de token. Va mourir vilain hacker.");//je stoppe tout
}

$email = filter_input(INPUT_POST, 'email', FILTER_DEFAULT);

include_once "../includes/config.php";

// PLUS BESOIN DE PHPMailer pour la version de test
// Décommentez ces lignes quand vous voudrez vraiment envoyer des emails

//use PHPMailer\PHPMailer\PHPMailer;
//use PHPMailer\PHPMailer\Exception;
//require '../vendor/autoload.php';


$pdo = new PDO("mysql:host=".config::host.";dbname=".config::dbname, config::user, config::password);

$reqContact = $pdo->prepare("SELECT * FROM contact WHERE Email = :email");
$reqAdmin = $pdo->prepare("SELECT * FROM formateur WHERE Email = :email");
$reqContact->bindParam(':email', $email);
$reqAdmin->bindParam(':email', $email);
$reqContact->execute();
$reqAdmin->execute();

$userAdmin = $reqAdmin->fetch();
$userContact = $reqContact->fetch();

if ($userAdmin || $userContact)
{
    // Générer un token sécurisé
    $token = rand(0, 1000000);
    $expiry = date('Y-m-d H:i:s', strtotime('+1 hour'));

    if ($userAdmin) {
        $req = $pdo->prepare("UPDATE formateur SET reset_token = :reset_token, reset_token_expiry = :reset_token_expiry WHERE Email = :email");
    }
    else {
        $req = $pdo->prepare("UPDATE contact SET reset_token = :reset_token, reset_token_expiry = :reset_token_expiry WHERE Email = :email");
    }
    $req->bindParam(':reset_token', $token);
    $req->bindParam(':reset_token_expiry', $expiry);
    $req->bindParam(':email', $email);
    $req->execute();

    // Préparer le lien de réinitialisation
    $reset_link = "http://localhost:63342/ImmoForm/includes/reinitialisationMDP.php?token=" . $token;

//    // VERSION TEST : Enregistrer le lien dans un fichier texte au lieu d'envoyer un email
//    // Envoyer l'email avec PHPMailer
//    $mail = new PHPMailer(true);
//
//    try {
//        // Configuration SMTP
//        $mail->isSMTP();
//        $mail->Host = 'smtp.gmail.com'; // Serveur SMTP de Gmail
//        $mail->SMTPAuth = true;
//        $mail->Username = 'mail@gmail.com'; // REMPLACEZ par votre email
//        $mail->Password = 'mdp mail'; // REMPLACEZ par votre mot de passe d'application Gmail
//        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
//        $mail->Port = 587;
//        $mail->CharSet = 'UTF-8';
//
//        // Expéditeur et destinataire
//        $mail->setFrom('mail@gmail.com', 'ImmoForm');
//        $mail->addAddress($email);
//
//        // Contenu de l'email
//        $mail->isHTML(true);
//        $mail->Subject = 'Réinitialisation de votre mot de passe';
//        $mail->Body = "
//            <html>
//            <body style='font-family: Arial, sans-serif;'>
//                <h2>Réinitialisation de mot de passe</h2>
//                <p>Bonjour,</p>
//                <p>Vous avez demandé la réinitialisation de votre mot de passe.</p>
//                <p>Cliquez sur le bouton ci-dessous pour réinitialiser votre mot de passe :</p>
//                <p style='margin: 30px 0;'>
//                    <a href='$reset_link' style='background:#007bff;color:white;padding:12px 24px;text-decoration:none;display:inline-block;border-radius:4px;'>
//                        Réinitialiser mon mot de passe
//                    </a>
//                </p>
//                <p>Ou copiez ce lien dans votre navigateur :</p>
//                <p style='background:#f4f4f4;padding:10px;word-break:break-all;'>$reset_link</p>
//                <p><strong>⚠️ Ce lien expire dans 1 heure.</strong></p>
//                <p style='color:#666;font-size:12px;margin-top:30px;'>
//                    Si vous n'avez pas fait cette demande, ignorez cet email. Votre mot de passe ne sera pas modifié.
//                </p>
//            </body>
//            </html>
//        ";
//
//        // Version texte brut (fallback)
//        $mail->AltBody = "Bonjour,\n\nVous avez demandé la réinitialisation de votre mot de passe.\n\nCliquez sur ce lien : $reset_link\n\nCe lien expire dans 1 heure.\n\nSi vous n'avez pas fait cette demande, ignorez cet email.";
//
//        $mail->send();
        // Cela permet de tester sans configurer SMTP
        $log_message = date('Y-m-d H:i:s') . " | Email: $email | Lien: $reset_link\n";
        file_put_contents(__DIR__ . '/../reset_links.txt', $log_message, FILE_APPEND);

        // Redirection avec message de succès
        header("Location: ./forgetPassword.php?success=1");
        exit;
//    }
//    catch (Exception $e) {
//    // Logger l'erreur (ne pas l'afficher à l'utilisateur pour des raisons de sécurité)
//    error_log("Erreur d'envoi email: {$mail->ErrorInfo}");
//
//    // Redirection avec erreur générique
//    header("Location: ./forgetPassword.php?error=envoi");
//    exit;
//}
}

else {
    // IMPORTANT : Ne pas révéler si l'email existe ou non (sécurité)
    // On redirige avec un message de succès même si l'email n'existe pas
    header("Location: ./forgetPassword.php?success=1");
    exit;
}
