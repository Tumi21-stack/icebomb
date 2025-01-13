<?php
session_start();
include 'db.php'; // Database connection

// PayFast Live Configuration
$payfast_url = 'https://sandbox.payfast.co.za/eng/process'; // Change to the live URL when ready
$merchant_id = 'your_live_payfast_merchant_id'; // Live PayFast Merchant ID
$merchant_key = 'your_live_payfast_merchant_key'; // Live PayFast Merchant Key
$passphrase = 'your_passphrase'; // PayFast passphrase

// Collect billing information from the POST request
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $email_address = $_GET['email'];
    $total = $_GET['total'];
    $item_name = "Your Product Name"; // Replace with dynamic item name if needed

    // Prepare PayFast payment data
    $data = array(
        'merchant_id' => $merchant_id,
        'merchant_key' => $merchant_key,
        'return_url' => 'http://yourdomain.com/success.php',
        'cancel_url' => 'http://yourdomain.com/cancel.php',
        'failed_url' => 'http://yourdomain.com/failed.php',
        'amount' => number_format($total, 2, '.', ''),
        'item_name' => $item_name,
        'email_address' => $email_address,
        'signature' => md5("merchant_id={$merchant_id}&merchant_key={$merchant_key}&amount={$total}&item_name={$item_name}&passphrase={$passphrase}")
    );

    // Redirect to PayFast payment page
    header("Location: $payfast_url?" . http_build_query($data));
    exit();
} else {
    // Handle invalid access
    echo "Invalid request.";
}
?>
