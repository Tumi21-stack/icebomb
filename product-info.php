<?php
session_start(); // Make sure session is started to store cart data

// Database connection
$host = 'localhost';
$dbname = 'icebombs_db';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Could not connect to the database $dbname :" . $e->getMessage());
}

// Your product retrieval logic here
if (isset($_GET['id'])) {
    $product_id = intval($_GET['id']);

    // Prepare and execute your query
    $stmt = $pdo->prepare("SELECT * FROM products WHERE product_id = ?");
    
    if ($stmt) {
        $stmt->execute([$product_id]);
        $product = $stmt->fetch(PDO::FETCH_ASSOC);

       
        
    } else {
        echo "Error preparing statement.";
    }
} else {
    echo "Product ID not specified.";
}

// Close the connection
$pdo = null;
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Events & Functions</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header class="header">
        <div class="logo">
            <a href="index.php"><img src="images/Ice Bomb Logo.8ed06360.png" alt="Ice Bomb Logo" style="width: 150px;"></a>
        </div>
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
    
    <title>Product Information</title>
    <style>
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
    list-style: none;
}

.product-details ul {
    margin-top: 10px; /* Add space between heading and list */
}

/* Add to Cart Button */
.add-to-cart-btn {
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

.add-to-cart-btn:hover {
    background-color: #0056b3;
}
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
        flex-direction: column;
    }

    footer ul li {
        margin: 0 15px;
    }

    footer ul li a {
        color: #fff;
        text-decoration: none;
    }

    footer p {
        font-size: 14px;
        margin-top: 10px;
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
        <section>
  <?php

    
?>

<div class="info-section">
    <h2><?php echo $product['name']; ?></h2>
    
    <div class="product-info">
        <div class="product-image">
            <img src="<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>">
        </div>
        <div class="product-price">
            R<?php echo number_format($product['price'], 2); ?>
        </div>
        <div class="product-details">
            <h3>Details</h3>
            <p><?php echo $product['description']; ?></p>
            <h4>Ingredients:</h4>
            <ul style="list-style-type: none;">
    <?php
    $ingredients = explode(',', $product['ingredients']);
    foreach ($ingredients as $ingredient) {
        echo "<li>" . trim($ingredient) . "</li>";
    }
    ?>
</ul>
            </ul>
          <!-- Add to Cart Button -->
    <form action="add_to_cart.php" method="POST">
        <input type="hidden" name="id" value="<?php echo $product['id']; ?>">
        <button type="submit" class="add-to-cart-btn">Add to Cart</button>
    </form>
    
</div>

</section>
    <script>
        // Toggle Navigation Menu for Mobile
        const menuToggle = document.getElementById('menu-toggle');
        const navList = document.getElementById('nav-list');
        const closeMenu = document.getElementById('close-menu');
    
        const heroSection = document.querySelector('.hero');
    
        menuToggle.addEventListener('click', function() {
            navList.classList.toggle('active');
            closeMenu.style.display = 'block';
            //Move hero section down when menu is open
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
        
    </script>


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
        <li><a href="Privacy.html">Privacy</a></li>
    </ul>
</footer>
    </body>
</html>
