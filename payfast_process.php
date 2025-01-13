<?php
session_start();
include 'db.php'; // Database connection
include 'mail-config.php'; // Include the mail configuration

// PayFast sandbox credentials
$merchant_id = '11632290';
$merchant_key = 's4pdautd2bc1h';
$return_url = 'http://localhost/icebomb/success.php';
$cancel_url = 'http://localhost/icebomb/cancel.php';
$notify_url = 'http://localhost/icebomb/notify.php';

// Passphrase (if using passphrase in PayFast account)
$passphrase = 'Ant0n3llaD3s1'; // Your sandbox passphrase

// Calculate total and generate item list
$total = 0;
$item_list = '';
if (isset($_SESSION["cart"]) && is_array($_SESSION["cart"])) {
    foreach ($_SESSION["cart"] as $item) {
        $total += $item["price"] * $item["quantity"];
        $item_list .= $item["name"] . ' (x' . $item["quantity"] . '), ';
    }
}

// Remove the trailing comma from the item list
$item_list = rtrim($item_list, ', ');

// Check if customer information is stored in session
if (isset($_SESSION['customer'])) {
    $customer_email = $_SESSION['customer']['email'];
    $customer_first_name = $_SESSION['customer']['first_name'];
    $customer_last_name = $_SESSION['customer']['last_name'];
    $customer_address = $_SESSION['customer']['address'];
    $customer_city = $_SESSION['customer']['city'];
    $customer_postal_code = $_SESSION['customer']['postal_code'];
    $customer_province = $_SESSION['customer']['province'];
    $customer_country = $_SESSION['customer']['country'];
    
    // Retrieve phone number and country code
    $customer_phone = $_SESSION['customer']['phone'];
    $customer_phone_code = $_SESSION['customer']['phone_code'];
    
} else {
    // Redirect back to cart if customer data is missing
    header('Location: cart.php');
    exit;
}


/// Store payment data in session to be used in success.php
$_SESSION['payment_data'] = [
    'invoice_number' => 'INV-' . time(),
    'total' => $total,
    'customer_email' => $customer_email,
    'customer_first_name' => $customer_first_name,
    'customer_last_name' => $customer_last_name,
    'customer_address' => $customer_address,
    'customer_city' => $customer_city,
    'customer_postal_code' => $customer_postal_code,
    'customer_province' => $customer_province,
    'customer_country' => $customer_country,
    // Add phone number and country code to the session
    'customer_phone' => $customer_phone,
    'customer_phone_code' => $customer_phone_code,
    'item_list' => $item_list
];
// PayFast payment data
$data = [
    'merchant_id' => $merchant_id,
    'merchant_key' => $merchant_key,
    'return_url' => $return_url,
    'cancel_url' => $cancel_url,
    'notify_url' => $notify_url,
    'name_first' => $customer_first_name,
    'name_last' => $customer_last_name,
    'email_address' => $customer_email,
    // Include phone number with country code
    'cell_number' => $customer_phone_code . $customer_phone, // Combining country code and phone number
    'm_payment_id' => $_SESSION['payment_data']['invoice_number'], // Using session-stored invoice number
    'amount' => number_format($total, 2, '.', ''),
    'item_name' => $item_list,
    'item_description' => 'Purchase of products: ' . $item_list,
    'email_confirmation' => '1',
    'confirmation_address' => $customer_email,
];


// Add passphrase for signature generation
if (!empty($passphrase)) {
    $data['passphrase'] = $passphrase;
}

// Generate the signature
$signature_string = '';
foreach ($data as $key => $value) {
    if (!empty($value)) {
        $signature_string .= $key . '=' . urlencode(trim($value)) . '&';
    }
}
$signature_string = rtrim($signature_string, '&');
$signature = md5($signature_string);
$data['signature'] = $signature;

// PayFast form submission
echo '<form id="payfast-form" action="https://www.payfast.co.za/eng/process" method="POST">';
foreach ($data as $key => $value) {
    echo '<input type="hidden" name="' . $key . '" value="' . $value . '">';
}
echo '</form>';
?>
<script type="text/javascript">
// Automatically submit the form to PayFast
document.getElementById('payfast-form').submit();
</script>
