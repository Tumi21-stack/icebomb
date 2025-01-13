<?php
require 'vendor/autoload.php'; // PHPMailer autoload
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;
// Database connection
$conn = new mysqli('localhost', 'root', '', 'icebombs_db');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    // Fetch subscribers
    $result = $conn->query("SELECT email FROM subscribers");

    $mail = new PHPMailer(true); // Enable exceptions

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com'; // Replace with your SMTP server
        $mail->SMTPAuth   = true;
        $mail->Username   = 'icebombs01@gmail.com'; // Your email address
        $mail->Password   = 'cgdtgudfopunqrmq'; // Your email password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        $mail->setFrom('no-reply@icebomb.com', 'Ice Bombs');
        $mail->isHTML(true);

        // Send emails to all subscribers
        while ($row = $result->fetch_assoc()) {
            $mail->clearAddresses(); // Reset addresses for each email
            $mail->addAddress($row['email']);
            $mail->Subject = $subject;
            $mail->Body    = $message;

            // Send the email
            $mail->send();
        }

        echo "Newsletter sent successfully!";
        header("Location: admin_dashboard.php"); // Redirection after success
        exit(); // Always call exit after a header redirect

    } catch (Exception $e) {
        echo "Newsletter could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
?>
