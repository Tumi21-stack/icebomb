<?php
include 'db.php'; // Database connection

// Retrieve data from PayFast
$pfData = file_get_contents('php://input');
$data = [];
parse_str($pfData, $data);

// Verify PayFast signature and data
$pfOutput = '';
foreach ($data as $key => $value) {
    if (!empty($value)) {
        $pfOutput .= $key . '=' . urlencode(trim($value)) . '&';
    }
}
$passphrase = 'vvqrjybe8hkki';
$pfOutput = rtrim($pfOutput, '&');
$signature = md5($pfOutput . '&passphrase=' . $passphrase);

if ($signature == $data['signature']) {
    // Check payment status and update your database accordingly
    if ($data['payment_status'] == 'COMPLETE') {
        // Update order status in the database
        $order_id = $data['m_payment_id'];
        $query = "UPDATE orders SET status = 'Paid' WHERE order_id = '$order_id'";
        mysqli_query($conn, $query);
    }
}
?>
