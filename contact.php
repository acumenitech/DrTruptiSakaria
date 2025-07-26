
<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

session_start();

if ($_POST['captcha'] != $_SESSION['captcha']) {
    echo "Captcha is incorrect!";
    exit;
}

$name = htmlspecialchars($_POST['name'] ?? '');
$email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
$website = htmlspecialchars($_POST['website'] ?? '');
$location = htmlspecialchars($_POST['location'] ?? '');
$subject = htmlspecialchars($_POST['subject'] ?? '');
$message = htmlspecialchars($_POST['message'] ?? '');

if (!$email) {
    echo "Invalid email format.";
    exit;
}

$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'your_email@gmail.com';
    $mail->Password = 'your_app_password';
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    $mail->setFrom($email, $name);
    $mail->addAddress('truptisakaria@gmail.com');
    $mail->Subject = "New Contact Form Submission: $subject";
    $mail->Body = "
		Name: $name
		Email: $email
		Website: $website
		Location: $location
		Message: $message
		";

    $mail->send();

    $mail->clearAddresses();
    $mail->addAddress($email);
    $mail->Subject = "Thank you for contacting us!";
    $mail->Body = "
			Dear $name,

			Thank you for your message. I have received your query and will respond as soon as possible.

			Best regards,  
			Dr. Trupti Sakaria
			";
    $mail->send();

    echo "success";
} catch (Exception $e) {
    echo "Mailer Error: {$mail->ErrorInfo}";
}
?>
