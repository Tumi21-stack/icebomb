<?php
require 'send_invoice_email.php';

// Assuming you get the order ID from Paystack's response
$order_id = $_GET['order_id'];

// Fetch the order and transaction details from the database
$stmt = $pdo->prepare("SELECT o.id, o.total, o.status, o.created_at, t.transaction_reference, t.amount, t.email 
                       FROM orders o 
                       LEFT JOIN transactions t ON o.id = t.order_id 
                       WHERE o.id = ?");
$stmt->execute([$order_id]);
$order = $stmt->fetch();

if ($order) {
    // Call the function to send the invoice email
    sendInvoiceEmail($order);

    // Display a success message or redirect
    echo "Payment successful! Invoice has been sent to " . $order['email'];
} else {
    echo "Order not found.";
}
?>
