<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'Exception.php';
require 'PHPMailer.php';
require 'SMTP.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nom = htmlspecialchars($_POST['name']);
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $message = htmlspecialchars($_POST['message']);

    if (!$email) {
        echo "Adresse email invalide.";
        exit;
    }

    $mail = new PHPMailer(true);

    try {
        // Config serveur SMTP
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // à adapter selon ton fournisseur SMTP
        $mail->SMTPAuth = true;
        $mail->Username = 'tonadresse@gmail.com'; // Ton adresse email
        $mail->Password = 'ton_mot_de_passe'; // Ton mot de passe d'application (si Gmail)
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Expéditeur et destinataire
        $mail->setFrom($email, $nom);
        $mail->addAddress('contact@altfquatre.com', 'AltF4 Studio');

        // Contenu du mail
        $mail->isHTML(true);
        $mail->Subject = "Message de $nom via le formulaire AltF4";
        $mail->Body = "<strong>Nom :</strong> $nom<br><strong>Email :</strong> $email<br><strong>Message :</strong><br>" . nl2br($message);

        $mail->send();
        echo "Message envoyé avec succès. Merci !";
    } catch (Exception $e) {
        echo "Erreur lors de l'envoi : " . $mail->ErrorInfo;
    }
} else {
    echo "Méthode non autorisée.";
}
?>