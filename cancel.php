<?php
session_start();
echo "<h1>Payment Canceled</h1>";
// Optionally, redirect to the cart or homepage
header("Location: cart.php");
exit();
?>
