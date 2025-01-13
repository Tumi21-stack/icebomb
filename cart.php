<?php
session_start();
include 'db.php'; // Database connection
 
// Calculate total and item list
$total = 0;
if (isset($_SESSION["cart"])) {
    foreach ($_SESSION["cart"] as $item) {
        $total += $item["price"] * $item["quantity"];
    }
}
 
// Remove product from cart
if (isset($_POST["remove_from_cart"])) {
    $product_id = $_POST["product_id"];
    if (isset($_SESSION["cart"])) {
        foreach ($_SESSION["cart"] as $key => $item) {
            if ($item["product_id"] == $product_id) {
                unset($_SESSION["cart"][$key]);
                $_SESSION["cart"] = array_values($_SESSION["cart"]); // Re-index the array
                echo json_encode(["status" => "success", "message" => "Product removed"]);
                exit;
            }
        }
    }
    echo json_encode(["status" => "error", "message" => "Product not found in cart"]);
    exit;
}
 
if (isset($_POST["update_quantity"])) {
    $product_id = $_POST["product_id"];
    $quantity = intval($_POST["quantity"]);
    // Check if quantity is 0
     // Ensure quantity starts at 1 if it's less than 1
     if ($quantity < 1) {
        $quantity = 1; // Set to 1 if the quantity is less than 1
    }

    if (isset($_SESSION["cart"])) {
        foreach ($_SESSION["cart"] as $key => $item) {
            if ($item["product_id"] == $product_id) {
                $_SESSION["cart"][$key]["quantity"] = $quantity;
                echo json_encode(["status" => "success", "message" => "Quantity updated"]);
                exit;
            }
        }
    }
    echo json_encode(["status" => "error", "message" => "Product not found in cart"]);
    exit;
}
 
// Store email and customer details in session when the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['email'])) {
    $_SESSION['customer']['email'] = $_POST['email'];
    $_SESSION['customer']['first_name'] = $_POST['first_name'];
    $_SESSION['customer']['last_name'] = $_POST['last_name'];
    $_SESSION['customer']['address'] = $_POST['address'];
    $_SESSION['customer']['city'] = $_POST['city'];
    $_SESSION['customer']['postal_code'] = $_POST['postal_code'];
    $_SESSION['customer']['province'] = $_POST['province'];
    $_SESSION['customer']['country'] = $_POST['country'];
     // Add phone number and country code to the session
     $_SESSION['customer']['phone'] = $_POST['phone'];
     $_SESSION['customer']['phone_code'] = $_POST['phone_code'];

    // Redirect to payment process page
    header('Location: payfast_process.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
    <link rel="stylesheet" href="styles.css">
    
</head>
<body>
    
<style>
     
   
     /* Body and Typography */
body {
font-family: Arial, sans-serif;
background-color: #fff;
color: #333;
}

/* Header */
.header {
display: flex;
justify-content: space-between;
align-items: center;
padding: 20px;
background-color: #fff;
border-bottom: 1px solid #ddd;
}

.logo img {
width: 150px;
}

/* Navigation */
.nav ul {
display: flex;
list-style: none;
padding: 0;
margin: 0;
}

.nav ul li {
margin: 15px 30px;
}

.nav ul li a {
text-decoration: none;
color: #333;
font-weight: bold;
}

/* Hide the close icon by default */
.close-icon {
display: none;
position: absolute;
top: 20px;
right: 20px;
font-size: 30px;
cursor: pointer;
z-index: 1100;
color: #333;
}

/* When the nav menu is active, show the close icon */
.nav ul.active ~ .close-icon {
display: block;
}

/* Styling for the X icon */
.close-icon span {
font-size: 40px;
color: #333;
}

/* Hide the menu icon by default */
.menu-icon {
display: none;
cursor: pointer;
z-index: 1100;
}

.menu-icon img {
width: 30px;
height: 30px;
}

/* Move the hero section down when the menu is open */
.hero {
transition: margin-top 0.3s ease;
}

/* Media Queries for Mobile Responsiveness */
@media (max-width: 768px) {
.nav ul {
    display: none; /* Hide navigation links initially */
    flex-direction: column;
    position: absolute;
    top: 60px; /* Adjust for header height */
    left: 0;
    width: 100%;
    background-color: #fff;
    border-top: 1px solid #ddd;
    z-index: 1;
}

.nav ul.active {
    display: flex; /* Show when toggled */
}

.menu-icon {
    display: block; /* Show hamburger menu on mobile */
}
}

/* Very Small Screens (Phones in Portrait Mode) */
@media (max-width: 480px) {
.hero img {
    height: auto;
}

.video-section iframe {
    height: 250px;
}

.newsletter input[type="email"] {
    width: 100%;
}

.action-button {
    font-size: 14px;
    padding: 8px 16px;
}
}

/* General Reset */
/* General Reset */
* {
margin: 0;
padding: 0;
box-sizing: border-box;
}

/* Body and Typography */
body {
font-family: Arial, sans-serif;
background-color: #fff;
color: #333;
}

/* Header */
.header {
display: flex;
justify-content: space-between;
align-items: center;
padding: 20px;
background-color: #fff;
border-bottom: 1px solid #ddd;
}

.logo img {
width: 150px;
}

/* Navigation */
.nav .active {
position: absolute;
top: 60px;
left: 0;
width: 100%;
background-color: #fff;
z-index: 1000;
border-top: 1px solid #ddd;
padding: 0;
margin: 0;
text-align: center;
}

.nav ul {
display: flex;
list-style: none;
padding: 0;
margin: 0;
}

.nav ul li {
margin: 15px 30px;
width: 100%;
}

.nav ul li a {
text-decoration: none;
color: #333;
font-weight: bold;
text-align: center;
}

/* Hide the close icon by default */
.close-icon {
display: none;
position: absolute;
top: 20px;
right: 20px;
font-size: 30px;
cursor: pointer;
z-index: 1100;
color: #333;
}

/* When the nav menu is active, show the close icon */
.nav ul.active ~ .close-icon {
display: block;
}

/* Styling for the X icon */
.close-icon span {
font-size: 40px;
color: #333;
cursor: pointer;
}

/* Move the hero section down when the menu is open */
.nav ul.active ~ .hero {
margin-top: 150px;
}

/* Reset the hero section's margin when the menu is closed */
.hero {
transition: margin-top 0.3s ease;
}

.hero img {
width: 100%;
height: auto;
border-radius: 15px;
}

.menu-icon {
display: none;
cursor: pointer;
z-index: 1100;
}

.menu-icon img {
width: 30px;
height: 30px;
}

/* Contact Info */
.contact-info {
text-align: center;
padding: 20px;
}

.social-icons {
margin-top: 20px;
}

.social-icons img {
width: 40px; /* Adjust size as needed */
height: 40px;
margin: 0 10px;
vertical-align: middle;
}

/* Footer */
footer {
    background-color: #333;
    color: #fff;
    padding: 20px;
    text-align: center;
}

footer ul {
    list-style: none;
    display: flex;
    justify-content: center;
    margin: 10px 0;
    text-decoration: none;
}

footer ul li {
    margin: 0 15px;   text-decoration: none;
}

footer ul li a {
    color: #fff;
    text-decoration: none;
    list-style: none;
}


footer ul li a:hover {
    text-decoration: none; /* No underline on hover */
    color: #fff; /* No color change on hover */
}


footer p {
    font-size: 14px;
    margin-top: 10px;
    list-style: none;   text-decoration: none;
}.alert {
    padding: 10px 15px;
    margin-bottom: 20px;
    border: 1px solid transparent;
    border-radius: 5px;
}

.alert-warning {
    color: #856404;
    background-color: #fff3cd;
    border-color: #ffeeba;
}


/* Media Queries for Mobile Responsiveness */
@media (max-width: 768px) {
    .grid-container {
        grid-template-columns: 1fr;
    }

    .nav ul {
        display: none; /* Hide navigation links initially */
        flex-direction: column;
        position: absolute;
        top: 60px; /* Adjust for header height */
        left: 0;
        width: 100%;
        background-color: #fff;
        border-top: 1px solid #ddd;
        z-index: 1;
    }

    .nav ul.active {
        display: flex; /* Show when toggled */
    }

    .menu-icon {
        display: block; /* Show hamburger menu on mobile */
    }

    .about-section {
        flex-direction: column;
    }

    .about-content p {
        max-width: 100%;
    }
}

.newsletter input[type="email"] {
    width: 100%;
    margin-bottom: 20px;
}

.video-section iframe {
    height: 300px;
}

footer ul {
    flex-direction: column;
}

footer ul li {
    margin: 10px 0;
}

/* Very Small Screens (Phones in Portrait Mode) */
@media (max-width: 480px) {
    .hero img {
        height: auto;
    }

    .video-section iframe {
        height: 250px;
    }

    .newsletter input[type="email"] {
        width: 100%;
    }

    .action-button {
        font-size: 14px;
        padding: 8px 16px;
    }
}.payment-gateway-logo {
    max-width: 200px; /* Adjust size as necessary */
    height: auto; /* Maintain aspect ratio */
    margin: 0 auto; /* Center horizontally */
    display: block; /* Make it a block element */
}
        </style>
    <header class="header">
        <div class="logo">
            <a href="index.php"><img src="images/Ice Bomb Logo.8ed06360.png" alt="Ice Bomb Logo" style="width: 150px;"></a>
        </div>
        <nav class="nav">
            <ul id="nav-list" class="nav-list">
                <li><a href="Shop.php">Shop</a></li>
                <li><a href="About.html">About</a></li>
                <li><a href="Stocklist.html">Stockists</a></li>
                <li><a href="Wholesale.html">Wholesale</a></li>
                <li><a href="Events.html">Events</a></li>
                <li><a href="ContactUs.html">Contact</a></li>
                <li><a href="Cart.php">Cart</a></li>
            </ul>
            <div id="close-menu" class="close-icon">
                <span>&times;</span>
            </div>
            <div id="menu-toggle" class="menu-icon">
                <img src="images/menu.png" alt="Menu">
            </div>
            </nav>
            </header>

    <script>
        const menuToggle = document.getElementById('menu-toggle');
        const navList = document.getElementById('nav-list');
        const closeMenu = document.getElementById('close-menu');
        const heroSection = document.querySelector('.hero');

        menuToggle.addEventListener('click', function() {
            navList.classList.toggle('active');
            closeMenu.style.display = 'block';
            if (navList.classList.contains('active')) {
                heroSection.style.marginTop = '150px';
            }
        });

        closeMenu.addEventListener('click', function() {
            navList.classList.remove('active');
            closeMenu.style.display = 'none';
            heroSection.style.marginTop = '0';
        });
    </script>
<!<!-- Improved Cart Design -->
<section class="cart py-5">
    <div class="container">
        <h2 class="text-center">Your Shopping Cart</h2>
        
        <?php if (isset($_SESSION["cart"]) && !empty($_SESSION["cart"])): ?>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th>Product Image</th>
                            <th>Product Name</th>
                            <th>Price (R)</th>
                            <th>Quantity</th>
                            <th>Total (R)</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    $total = 0;
                    foreach ($_SESSION["cart"] as $item):
                        $item_price = floatval($item['price']); // Cast price to float
                        $item_quantity = intval($item['quantity']); // Cast quantity to int
                        $item_total = $item_price * $item_quantity; // Calculate total
                        $total += $item_total;
                    ?>
                        <tr>
                            <td>
                                <img src="<?php echo $item['image']; ?>" alt="<?php echo $item['name']; ?>" style="width: 150px; height: 100px;">
                            </td>
                            <td><?php echo $item["name"]; ?></td>
                            <td>R<?php echo number_format($item_price, 2); ?></td>
                            <td>
                                <div class="input-group">
                                    <input type="number" class="form-control" value="<?php echo $item_quantity; ?>" min="1" onchange="updateCart(<?php echo $item['product_id']; ?>, this.value)">
                                </div>
                            </td>
                            <td>R<?php echo number_format($item_total, 2); ?></td>
                            <td>
                                <button class="btn btn-danger btn-sm" onclick="removeFromCart(<?php echo $item['product_id']; ?>)">Remove</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                        <tr>
                            <td colspan="4" class="text-right"><strong>Total</strong></td>
                            <td><strong>R<?php echo number_format($total, 2); ?></strong></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td colspan="4" class="text-right"><strong>Total with Delivery Fee</strong></td>
                            <td><strong>R<?php echo number_format($total); ?></strong></td>
                            <td></td>
                        </tr>

                       
                    </tbody>
                </table>
            </div>

            <!-- Billing Form -->
            <form action="" method="POST">
                <div class="row">
                    <div class="col-md-6">
                        <!-- Existing form fields -->
                        <div class="form-group">
                            <label for="first_name">First Name</label>
                            <input type="text" class="form-control" id="first_name" name="first_name" required>
                        </div>
                        <div class="form-group">
                            <label for="last_name">Last Name</label>
                            <input type="text" class="form-control" id="last_name" name="last_name" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="address">Address</label>
                            <input type="text" class="form-control" id="address" name="address" required>
                        </div>
                        <div class="form-group">
                            <label for="city">City</label>
                            <input type="text" class="form-control" id="city" name="city" required>
                        </div>
                        <div class="form-group">
                            <label for="postal_code">Postal Code</label>
                            <input type="text" class="form-control" id="postal_code" name="postal_code" required>
                        </div>
                        <div class="form-group">
                            <label for="province">Province</label>
                            <input type="text" class="form-control" id="province" name="province" required>
                        </div>
                      
                        <!-- New Phone Number Section -->
                        <div class="form-group">
                            <label for="phone">Phone Number</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <select class="form-control" id="country_code" name="country_code" required>
                                        <option value="">Select Code</option>
                                        <option value="+27">South Africa (+27)</option>
                                        <option value="+268">Eswatini (+268)</option>
                                        <option value="+264">Namibia (+264)</option>
                                        <option value="+267">Botswana (+267)</option>
                                        <option value="+266">Lesotho (+266)</option>
                                        <option value="+260">Zambia (+260)</option>
                                        <option value="+263">Zimbabwe (+263)</option>
                                        <option value="+258">Mozambique (+258)</option>
                                        <option value="+265">Malawi (+265)</option>
                                        <option value="+231">Angola (+231)</option>
                                        <option value="+242">Congo-Brazzaville (+242)</option>
                                        <option value="+243">Congo-Kinshasa (+243)</option>
                                    </select>
                                </div>
                                <input type="text" class="form-control" id="phone" name="phone" placeholder="Enter phone number" required>
                            </div>
                        </div>

                        <!-- Modified Country Section -->
                        <div class="form-group">
                            <label for="country">Country</label>
                            <select class="form-control" id="country" name="country" required>
                                <option value="">Select Country</option>
                                <option value="South Africa">South Africa</option>
                                <option value="Eswatini">Eswatini</option>
                                <option value="Namibia">Namibia</option>
                                <option value="Botswana">Botswana</option>
                                <option value="Lesotho">Lesotho</option>
                                <option value="Zambia">Zambia</option>
                                <option value="Zimbabwe">Zimbabwe</option>
                                <option value="Mozambique">Mozambique</option>
                                <option value="Malawi">Malawi</option>
                                <option value="Angola">Angola</option>
                                <option value="Congo-Brazzaville">Congo-Brazzaville</option>
                                <option value="Congo-Kinshasa">Congo-Kinshasa</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Proceed to Payment Button -->
                <div class="text-center">
                <?php
                        // Check if total is less than or equal to zero
                        if ($total <= 0) {
                            echo '<tr>';
                            echo '<td colspan="6" class="text-center">';
                            echo '<div class="alert alert-warning" role="alert">';
                            echo 'Please increase the quantity of items in your cart to proceed to payment.';
                            echo '</div>';
                            echo '</td>';
                            echo '</tr>';
                        } else {
                            // Proceed to payment
                            echo '<tr>';
                            echo '<td colspan="6" class="text-center">';
                            echo '<form action="payment.php" method="post">'; // Change to your payment processing file
                            echo '<button type="submit" class="btn btn-success btn-lg mt-3">Proceed to Payment</button>';
                            echo '</form>';
                            echo '</td>';
                            echo '</tr>';
                        }
                        ?>
            
                </div>
                <img src="images/R.png" alt="Payfast" class="payment-gateway-logo">
            </form>
        <?php else: ?>
            <p class="text-center">Your cart is currently empty.</p>
        <?php endif; ?>
    </div>
</section>

<script>
// Ajax functions to update or remove items in the cart
function updateCart(product_id, quantity) {
    $.ajax({
        url: 'cart.php',
        type: 'POST',
        data: {
            update_quantity: true,
            product_id: product_id,
            quantity: quantity
        },
        dataType: 'json',
        success: function(response) {
            if (response.status === "success") {
                window.location.reload(); 
            } else {
                alert(response.message);
            }
        }
    });
}

function removeFromCart(product_id) {
    $.ajax({
        url: 'cart.php',
        type: 'POST',
        data: {
            remove_from_cart: true,
            product_id: product_id
        },
        dataType: 'json',
        success: function(response) {
            if (response.status === "success") {
                window.location.reload(); 
            } else {
                alert(response.message);
            }
        }
    });
}
</script>

    <footer>
        <p>&copy; 2023 Ice Bomb. All rights reserved.</p>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="About.html">About us</a></li>
            <li><a href="ContactUs.html">Contact</a></li>
            <li><a href="Terms.html">Terms</a></li>
            <li><a href="Privacy.html">Privacy</a></li>
        </ul>
    </footer>
    <script>
$(document).ready(function() {
    $('form').on('submit', function(event) {
        // Assuming the quantity input has the name 'quantity'
        var quantity = parseInt($('input[name="quantity"]').val());

        // Check if quantity is 0 or NaN
        if (isNaN(quantity) || quantity <= 0) {
            event.preventDefault(); // Prevent the form from submitting
            alert('Please select a quantity greater than 0.'); // Alert the user
        }
    });
});
</script>
<script>
$(document).ready(function() {
    // Define the expected phone number lengths for each country code
    const phoneLengths = {
        '+27': 10,  // South Africa
        '+268': 7,  // Eswatini
        '+264': 7,  // Namibia
        '+267': 7,  // Botswana
        '+266': 7,  // Lesotho
        '+260': 10, // Zambia
        '+263': 9,  // Zimbabwe
        '+258': 9,  // Mozambique
        '+265': 9,  // Malawi
        '+231': 7,  // Angola
        '+242': 7,  // Congo-Brazzaville
        '+243': 9   // Congo-Kinshasa
    };

    // Listen for changes on the country code dropdown
    $('#country_code').change(function() {
        const selectedCode = $(this).val();
        const expectedLength = phoneLengths[selectedCode];

        // Reset the error message
        $('#phone_error').hide().text('');

        // Validate the phone number input on change
        $('#phone').off('input').on('input', function() {
            const phoneNumber = $(this).val().replace(/\D/g, ''); // Remove non-digit characters

            if (phoneNumber.length > 0 && phoneNumber.length !== expectedLength) {
                $('#phone_error').show().text(`Please enter a ${expectedLength} digit phone number.`);
            } else {
                $('#phone_error').hide();
            }
        });
    });
});
</script>

<!-- Include Bootstrap and jQuery -->
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
