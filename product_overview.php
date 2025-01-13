<?php
session_start();
include 'db.php';

$product_id = $_GET['id'];

// Fetch product details
$sql = "SELECT * FROM products WHERE id = $product_id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $product = $result->fetch_assoc();
} else {
    die("Product not found!");
}

// Add product to cart
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $quantity = $_POST["quantity"];

    // Check if the cart session exists
    if (!isset($_SESSION["cart"])) {
        $_SESSION["cart"] = [];
    }

    // Add the product to the cart
    $_SESSION["cart"][] = [
        "product_id" => $product["id"],
        "name" => $product["name"],
        "price" => $product["price"],
        "image" => $product["image"],
        "quantity" => $quantity
    ];

    // Redirect to cart page
    header("Location: cart.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head> <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header class="header">
        <div class="logo">
            <a href="index.php"><img src="images/Ice Bomb Logo.8ed06360.png" alt="Ice Bomb Logo" style="width: 150px;"></a>
        </div>
        
<style>       /* General Reset */
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
    .info-section {
    list-style-type: none; /* Removes bullet points */
    padding: 0; /* Removes default padding */
}

.info-section li {
    margin-bottom: 10px; /* Adds some space between list items, optional */
}

/* Info Section */
.info-section {
    width: 80%;
    max-width: 800px;
    margin: 0 auto;
    padding: 20px;
    background-color: #ffffff;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}
h2 {
    text-align: center;
    margin: 20px 0;
}

/* Product Image */
.product-image {
    text-align: center;
    margin: 20px 0;
}

.product-image img {
    max-width: 100%;
    height: auto;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

/* Product Price */
.product-price {
    font-size: 24px;
    font-weight: bold;
    text-align: center;
    margin: 20px 0;
    color: #333;
}

/* Product Details */
.product-details h3 {
    margin-top: 20px;
    font-size: 18px;
    color: #555;
}

.product-details p {
    line-height: 1.6;
    color: #666;
}
.product-details h4 {
    margin-top: 20px; /* Add space above the ingredient heading */
}

.product-details ul {
    margin-top: 10px; /* Add space between heading and list */
}

/* Add to Cart Button */
.btn  {
    display: block;
    width: 100%;
    max-width: 200px;
    margin: 20px auto;
    padding: 10px;
    background-color: #007bff;
    color: white;
    border: none;
    cursor: pointer;
    border-radius: 5px;
    text-align: center;
    text-decoration: none;
    font-size: 16px;
    transition: background-color 0.3s;
}

.btn :hover {
    background-color: #0056b3;
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
.contact-info {
    text-align: center;
    padding: 20px;
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
}
/* Media Queries for Mobile Responsiveness */
@media (max-width: 768px) {
    .nav ul {
        display: none;
        flex-direction: column;
        position: absolute;
        top: 60px;
        left: 0;
        width: 100%;
        background-color: #fff;
        border-top: 1px solid #ddd;
        z-index: 1;
    }

    .nav ul.active {
        display: flex;
    }

    .menu-icon {
        display: block;
    }

    .grid-container {
        grid-template-columns: 1fr;
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

    footer ul {
        flex-direction: column;
    }

    footer ul li {
        margin: 10px 0;
    }
}
</style>
        <nav class="nav">
            <ul id="nav-list" class="nav-list">
                <li><a href="Shop.html">Shop</a></li>
                <li><a href="About.html">About</a></li>
                <li><a href="Stocklist.html">Stockists</a></li>
                <li><a href="Wholesale.html">Wholesale</a></li>
                <li><a href="Events.html">Events</a></li>
                <li><a href="ContactUs.html">Contact</a></li>
                <li><a href="cart.php">Cart</a></li>
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
       // Toggle Navigation Menu for Mobile
const menuToggle = document.getElementById('menu-toggle');
const navList = document.getElementById('nav-list');
const closeMenu = document.getElementById('close-menu');
const heroSection = document.querySelector('.hero');

menuToggle.addEventListener('click', function() {
    navList.classList.toggle('active');
    closeMenu.style.display = 'block';
    // Move hero section down when menu is open
    if (navList.classList.contains('active')) {
        heroSection.style.marginTop = '150px'; // Adjust this value if needed
    }
});

closeMenu.addEventListener('click', function() {
    navList.classList.remove('active');
    closeMenu.style.display = 'none'; // Hide the close button when menu is closed

    // Move hero section back up
    heroSection.style.marginTop = '0';
});

function toggleDropdown(provinceId) {
  // Get the selected dropdown content
  const selectedDropdown = document.getElementById(provinceId);

  // Check if it's currently displayed
  const isDisplayed = selectedDropdown.style.display === 'block';

  // Hide all dropdowns first
  const dropdowns = document.getElementsByClassName('dropdown-content');
  for (let i = 0; i < dropdowns.length; i++) {
    dropdowns[i].style.display = 'none';
  }

  // If the clicked dropdown wasn't displayed, display it
  if (!isDisplayed) {
    selectedDropdown.style.display = 'block';
  }
}

// Add event listener for 'Add to Cart' buttons
document.querySelectorAll('.add-to-cart-btn').forEach(function(button) {
    button.addEventListener('click', function() {
        // Get product details
        const productId = this.getAttribute('data-product-id');
        const productPrice = parseFloat(this.getAttribute('data-product-price'));

        // Get cart from sessionStorage (or create an empty cart if not exists)
        let cart = JSON.parse(sessionStorage.getItem('cart')) || [];

        // Check if product is already in the cart
        let existingProduct = cart.find(item => item.id === productId);
        if (existingProduct) {
            // If product already in cart, increment the quantity
            existingProduct.quantity++;
        } else {
            // Otherwise, add the new product with quantity 1
            cart.push({ id: productId, price: productPrice, quantity: 1 });
        }

        // Save updated cart to sessionStorage
        sessionStorage.setItem('cart', JSON.stringify(cart));

        // Redirect to cart page
        window.location.href = 'cart.php';
    });
});




    </script>
    <title>Product Overview</title>
    <!-- Bootstrap CSS CDN -->
 
<div class="info-section">
   <div class="product-info">
        <div class="product-image">
        <img src="<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>">
        </div>
        <div class="col-md-6">
            <h2><?php echo $product['name']; ?></h2>
            <div class="product-details">
            <p><?php echo $product['description']; ?></p>
    
        
            <ul>
            <h4>Product Ingredients</h4>

<ul><?php
// Assuming $product['ingredients'] contains a period-separated string of ingredients
$ingredients = explode('.', $product['ingredients']);
foreach ($ingredients as $ingredient) {
    // Trim the ingredient, then split it by spaces to isolate the first word
    $ingredient = trim($ingredient);
    if (!empty($ingredient)) {
        $words = explode(' ', $ingredient);
        $firstWord = array_shift($words); // Get the first word
        $restOfSentence = implode(' ', $words); // Join the rest of the sentence
        echo "<li><strong>" . htmlspecialchars($firstWord) . "</strong> " . htmlspecialchars($restOfSentence) . "</li>";
    }
}
?>
<p>May contain nuts, cow’s milk.</p> <!-- Optional warning if needed -->

<h4>Quantity</h4>
<p><?php echo htmlspecialchars($product['quantity']); ?></p>
<div class="product-price">
<p><strong>Price:</strong> R<?php echo $product['price']; ?></p>
</div>
            <!-- Add to Cart Form -->
            <form method="post" action="">
                <div class="form-group">
                   
                   </div>
                <button type="submit" class="btn btn-success">Add to Cart</button>
            </form>
        </div>
    </div>
</div>
</div>
<section>
        <div class="contact-info">
        <p>We do not have a walk-in store, only an online shop. If you would like to order Ice Bombs, please shop online.</p>
        <p>LEAVE A REVIEW: We value any feedback that you may have, should you have any, please click the following link: <a href="https://bit.ly/3VkhCqf" target="_blank">https://bit.ly/3VkhCqf</a></p>
        <div class="social-icons">
            <a href="https://m.facebook.com/icebombs/" target="_blank"><img src="images/facebook.png" alt="Facebook"></a>
            <a href="https://www.instagram.com/icebombs/" target="_blank"><img src="images/instagram.png" alt="Instagram"></a>
            </div>    
        </section>
   
        <footer>
        <p>&copy; 2023 Ice Bomb. All rights reserved.</p>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="About.html">About us</a></li>
            <li><a href="ContactUs.html">Contact</a></li>
            <li><a href="Terms.html">Terms</a></li>
            <li><a href="admin_dashboard.php">Admin Page</a></li>
            <li><a href="Privacy.html">Privacy</a></li>
        </ul>
    </footer>
    </body>
</html>
