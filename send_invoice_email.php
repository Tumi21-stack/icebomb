
<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

function sendInvoiceEmail($order) {
    $mail = new PHPMailer(true);

    try {
        // SMTP server configuration
        $mail->isSMTP();
        $mail->Host       = 'smtp.example.com'; // Your SMTP host (e.g., Gmail SMTP)
        $mail->SMTPAuth   = true;
        $mail->Username   = 'your-email@example.com'; // Your SMTP email
        $mail->Password   = 'your-email-password'; // Your SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        // Sender and recipient
        $mail->setFrom('your-email@example.com', 'Ice Bomb'); // Sender email and name
        $mail->addAddress($order['email']); // Recipient (customer email)

        // Email content
        $mail->isHTML(true);
        $mail->Subject = 'Invoice for Your Order #' . $order['id'];
        $mail->Body    = createInvoiceTemplate($order); // Generate invoice template

        // Send email
        $mail->send();
        echo 'Invoice has been sent successfully.';
    } catch (Exception $e) {
        echo "Invoice could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}

function createInvoiceTemplate($order) {
    return "
    <!DOCTYPE html>
    <html lang='en'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Invoice</title>
        <style>
            body { font-family: Arial, sans-serif; color: #333; }
            .container { max-width: 600px; margin: auto; padding: 20px; border: 1px solid #ccc; border-radius: 10px; }
            h2 { text-align: center; color: #333; }
            p { line-height: 1.6; }
            .invoice-details { margin: 20px 0; }
        </style>
    </head>
    <body>
        <div class='container'>
            <h2>Invoice #{$order['id']}</h2>
            <p>Thank you for your purchase!</p>
            <p><strong>Transaction Reference:</strong> {$order['transaction_reference']}</p>
            <p><strong>Amount Paid:</strong> " . number_format($order['amount'], 2) . "</p>
            <p><strong>Status:</strong> {$order['status']}</p>
            <p><strong>Date:</strong> {$order['created_at']}</p>
            <p>If you have any questions, feel free to contact us.</p>
        </div>
    </body>
    </html>";
}
?>
