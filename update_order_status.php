<?php
session_start();
require 'vendor/autoload.php'; // PHPMailer autoload
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;
include 'db.php'; // Database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['invoice_number'])) {
    $invoice_number = $_POST['invoice_number'];

    // Check if the request is to delete the invoice
    if (isset($_POST['delete']) && $_POST['delete'] === 'true') {
        // Prepare the delete statement
        $sql = "DELETE FROM invoices WHERE invoice_number = ? LIMIT 1";
        $stmt = $conn->prepare($sql);

        if ($stmt) { // Check if the statement was prepared successfully
            // Bind the invoice number and execute the statement
            $stmt->bind_param("s", $invoice_number); // Assuming invoice_number is a string
            $stmt->execute();

            // Check if the deletion was successful
            if ($stmt->affected_rows === 1) {
                echo "Invoice deleted successfully.";

                // Remove the invoice from the session
                if (isset($_SESSION['invoices'])) {
                    foreach ($_SESSION['invoices'] as $key => $invoice) {
                        if ($invoice['invoice_number'] === $invoice_number) {
                            unset($_SESSION['invoices'][$key]);
                            break; // Stop the loop once the invoice is found and removed
                        }
                    }
                }
            } else {
                echo "Invoice not found or no changes made.";
            }

            $stmt->close(); // Close the statement only if it was successful

            // Redirect back to orders overview page
            header("Location: admin_orders.php");
            exit;
        } else {
            echo "Error preparing statement: " . htmlspecialchars($conn->error);
            exit;
        }
    }

    // If delete is not set, proceed to update the status
    if (isset($_POST['new_status'])) {
        $new_status = $_POST['new_status'];

        // Prepare and execute the update statement using the invoice number
        $sql = "UPDATE invoices SET status = ? WHERE invoice_number = ? LIMIT 1";
        $stmt = $conn->prepare($sql);

        if ($stmt) { // Check if the statement was prepared successfully
            // Bind parameters and execute the statement
            $stmt->bind_param("ss", $new_status, $invoice_number); // Assuming invoice_number is a string
            $stmt->execute();

            // Check for errors or successful update
            if ($stmt->affected_rows === 1) {
                echo "Status updated successfully.";

                // Update the invoice status in the session
                if (isset($_SESSION['invoices'])) {
                    foreach ($_SESSION['invoices'] as &$invoice) {
                        if ($invoice['invoice_number'] === $invoice_number) {
                            $invoice['status'] = $new_status; // Update status in session
                            break; // Stop the loop once the invoice is found and updated
                        }
                    }
                }

                // Send email notification if the status is changed to 'shipped'
                if ($new_status === 'SHIPPED') {
                    $customer_email = ''; // Retrieve the customer's email from the database based on the invoice number
                    $sql = "SELECT customer_email FROM invoices WHERE invoice_number = ?";
                    $stmt = $conn->prepare($sql);
                    if ($stmt) { // Check if the statement was prepared successfully
                        $stmt->bind_param("s", $invoice_number);
                        $stmt->execute();
                        $stmt->bind_result($customer_email);
                        $stmt->fetch();
                        $stmt->close(); // Close the statement after use
                    }

                    if (!empty($customer_email)) {
                        // Create a new PHPMailer instance
                        $mail = new PHPMailer(true);
                        try {
                            // Server settings
                            $mail->isSMTP();
                            $mail->Host       = 'smtp.gmail.com'; // Set the SMTP server to send through
                            $mail->SMTPAuth   = true;
                            $mail->Username   = 'icebombs01@gmail.com'; // SMTP username
                            $mail->Password   = 'cgdtgudfopunqrmq'; // SMTP password
                            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Enable TLS encryption
                            $mail->Port       = 587; // TCP port to connect to

                            // Recipients
                            $mail->setFrom('no-reply@icebomb.com', 'Ice Bombs');
                            $mail->addAddress($customer_email); // Add a recipient

                            // Content
                            $mail->isHTML(true); // Set email format to HTML
                            $mail->Subject = 'Your Order Has Been Shipped';
                            $mail->Body    = "Dear Customer,<br><br>Your order with invoice number <strong>$invoice_number</strong> has been shipped. You will receive more details from the courier.<br><br>Thank you for shopping with us! Best regards,<br>Ice Bombs";

                            $mail->send();
                            echo 'Email has been sent.';
                        } catch (Exception $e) {
                            echo "Email could not be sent. Mailer Error: {$mail->ErrorInfo}";
                        }
                    } else {
                        echo "Customer email not found.";
                    }
                }
            } else {
                echo "No changes made or invoice not found.";
            }

           

            // Redirect back to orders overview page
            header("Location: admin_orders.php");
            exit;
        } else {
            echo "Error preparing statement: " . htmlspecialchars($conn->error);
            exit;
        }
    }
} else {
    echo "Invalid request.";
    exit;
}$stmt->close(); // Close the statement only if it was successful
?>
