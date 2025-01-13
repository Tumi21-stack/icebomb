<?php
session_start();
include 'db.php'; // Database connection
include 'mail-config.php'; // Include the mail configuration
require 'dompdf/autoload.inc.php'; // Include DOMPDF

use Dompdf\Dompdf;
use Dompdf\Options;

// Ensure payment data is available
if (!isset($_SESSION['payment_data'])) {
    echo "Payment data is missing.";
    exit;
}

// Retrieve payment data from session
$payment_data = $_SESSION['payment_data'];
$invoice_number = $payment_data['invoice_number'];
$total = $payment_data['total'];
$customer_email = $payment_data['customer_email'];
$customer_first_name = $payment_data['customer_first_name'];
$customer_last_name = $payment_data['customer_last_name'];
$customer_address = $payment_data['customer_address'];
$customer_city = $payment_data['customer_city'];
$customer_postal_code = $payment_data['customer_postal_code'];
$customer_province = $payment_data['customer_province'];
$customer_country = $payment_data['customer_country'];
$item_list = $payment_data['item_list'];

// Retrieve phone number and country code
$customer_phone = $payment_data['customer_phone'];
$customer_phone_code = $payment_data['customer_phone_code'];

// Generate a unique order ID
// Generate a unique order ID with date and a random number
$order_id = 'ORDER-' . date('Ymd') . '-' . rand(1000, 9999); // Example: ORDER-20241004-1234
$status = 'PAID'; // Set the status to 'Paid' after successful payment


// Update invoice status in the database
try {
    // Prepare the SQL statement to include the additional fields
    $stmt = $conn->prepare("INSERT INTO invoices (invoice_number, customer_email, amount, status, order_id, customer_phone, shipping_address, shipping_city, shipping_postal_code, shipping_country, item_list, province) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssdsssssssss", $invoice_number, $customer_email, $total, $status, $order_id, $customer_phone, $customer_address, $customer_city, $customer_postal_code, $customer_country, $item_list, $customer_province);

    // Execute the statement
    if (!$stmt->execute()) {
        throw new Exception("Failed to insert invoice: " . $stmt->error);
    }

    // Fetch the invoice details
    $stmt = $conn->prepare("SELECT invoice_number, customer_email, amount FROM invoices WHERE order_id = ?");
    $stmt->bind_param("s", $order_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $invoice = $result->fetch_assoc();
        $invoice_number = $invoice['invoice_number'];
        $customer_email = $invoice['customer_email'];
        $total = $invoice['amount'];

        // Generate the email body for customer
        $message = "
        <html>
        <head>
            <title>Invoice - $invoice_number</title>
        </head>
        <body>
            <h1>Invoice: $invoice_number</h1>
            <p><strong>Order ID:</strong> $order_id</p>
            <p><strong>Amount:</strong> R" . number_format($total, 2) . "</p>
            <p><strong>Status:</strong> Paid</p>
            <p><strong>Items:</strong> $item_list</p>
            <p><strong>Shipping Address:</strong> $customer_address, $customer_city, $customer_postal_code, $customer_province, $customer_country</p>
            <p>We will notify you once your order has been shipped.</p>
            <p>Best regards,<br>Ice Bombs</p>
        </body>
        </html>";

        // Send the invoice email to customer
        sendEmail($customer_email, "Your Invoice - $invoice_number", $message);

        // Retrieve the admin's email from the database
        $admin_stmt = $conn->prepare("SELECT email FROM admins WHERE id = 1"); // Assuming admin ID is 1
        $admin_stmt->execute();
        $admin_result = $admin_stmt->get_result();
        $admin_email = '';
        if ($admin_result->num_rows > 0) {
            $admin = $admin_result->fetch_assoc();
            $admin_email = $admin['email'];
        }

        // Send notification to admin about the new order
        $admin_message = "
        <html>
        <head>
            <title>New Order - $invoice_number</title>
        </head>
        <body>
            <h1>New Order Placed!!</h1>
            <p>Hi Admin, an order has been placed with the following details:</p>
            <p><strong>Invoice Number:</strong> $invoice_number</p>
            <p><strong>Order ID:</strong> $order_id</p>
            <p><strong>Items:</strong> $item_list</p>
            <p><strong>Total Amount:</strong> R" . number_format($total, 2) . "</p>
             <p>Head over to the Admin Dashboard for more details</p>
            <p>Best regards,<br>Ice Bombs</p>
        </body>
        </html>";

        // Send email to admin
        sendEmail($admin_email, "New Order Notification - $invoice_number", $admin_message);
    } 
    else {
        throw new Exception('Failed to retrieve invoice details.')
    ;}

    // Clear the cart
    unset($_SESSION['cart']);

    // Display success message and redirect
    echo '
   <html>
    <head>
        <title>Payment Success</title>
        <meta http-equiv="refresh" content="5;url=cart.php?status=success">
        <style>
            body {
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100vh;
                margin: 0;
                font-family: Arial, sans-serif;
            }
            .message-container {
                text-align: center;
            }
            h1 {
                font-weight: bold;
            }
            p {
                font-weight: bold;
            }
        </style>
    </head>
    <body>
        <div class="message-container">
            <h1>Payment Successful!</h1>
            <p>Your invoice has been generated and sent to <strong><?php echo htmlspecialchars($customer_email); ?></strong>.</p>
            <p>You will be redirected to your cart in 5 seconds.</p>
        </div>
    </body>
</html>';

    // Store order in the session after a successful payment
    $_SESSION['orders'][$order_id] = [
        'invoice_number' => $invoice_number,
        'customer_email' => $customer_email,
        'customer_phone' => $customer_phone,
        'total' => $total,
        'status' => $status,
        'item_list' => $item_list,
        'customer_address' => $customer_address,
        'customer_city' => $customer_city,
        'customer_postal_code' => $customer_postal_code,
        'customer_province' => $customer_province,
        'customer_country' => $customer_country
    ];

} catch (Exception $e) {
    error_log("Error: " . $e->getMessage());
    echo "An error occurred while processing your payment.";
}

?>
