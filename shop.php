<?php
// Database connection
include 'db.php';

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch products
$result = $conn->query("SELECT id, name, price, image FROM products");
?>


    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Ice Bombs Products</title>

<!-- Header -->
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

<div class="notice-message">
            Online orders are for customers living within the GAUTENG province only. We deliver weekly. We will notify you the day before your delivery via SMS. Cut-off for same-week deliveries is Tuesday 23:59. 
            <br><br>
            For customers living in other provinces, please click here to find a stockist closest to you: 
            <a href="Stocklist.html">Stockists Page</a>
        </div>
        

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




    </script>
</header>


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
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

/* Body and Typography */
body {
    font-family: 'Arial', sans-serif;
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


    body {
    font-family: Arial, sans-serif;
    background-color: #fff;
    margin: 0;
    padding: 0;
    color: #333;
}


    /* General Reset */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    /* Body and typography */
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
    }.contact-info {
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
    .grid-container
     {
            grid-template-columns: 1fr;
        }

    .nav ul
     {
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

.nav ul.active
 {
    display: flex; /* Show when toggled */
}

.menu-icon
 {
    display: block; /* Show hamburger menu on mobile */
}

 .about-section 
 {
            flex-direction: column;
        }
 .about-content p 
 {
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
}
        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
            padding: 20px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .product-card {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            text-align: center;
            padding: 20px;
            transition: transform 0.3s ease;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            height: 350px;
        }

        .product-card:hover {
            transform: translateY(-5px);
        }

        .product-image {
            width: 100%;
            height: 180px;
            object-fit: cover;
            border-radius: 8px;
            margin-bottom: 10px;
        }

        .product-title {
            font-size: 18px;
            margin: 10px 0;
            color: #333;
        }

        .price {
            font-size: 16px;
            color: #0b0c0b;
            margin-bottom: 15px;
        }

        .btn {
            background-color: #070607;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
            text-decoration: none;
        }

        .btn:hover {
            background-color: #218838;
        }        
     /* Container for the notice message */
     .notice-message {
            background-color: #fff4e5;
            border-left: 6px solid #ff9900;
            padding: 15px;
            margin: 20px auto;
            max-width: 800px;
            font-size: 16px;
            color: #333;
            line-height: 1.5;
        }

        .notice-message a {
            color: #ff9900;
            text-decoration: none;
            font-weight: bold;
        }

        .notice-message a:hover {
            text-decoration: underline;
        }
          
    </style>
</head>
<body>

<div class="product-grid">
        <?php while ($row = $result->fetch_assoc()) { ?>
        <div class="product-card">
            <!-- Display product image -->
             
            <img src="<?php echo $row['image']; ?>" alt="Product Image"class="product-image">
            <h2 class="product-title"><?php echo $row['name']; ?></h2>
            <p class="price">R<?php echo $row['price']; ?></p>
            <!-- Link to the product overview page -->
            <a href="product_overview.php?id=<?php echo $row['id']; ?>" class="btn btn-primary">View Details</a>
        </div>
        <?php } ?>
    </div>
</div>


<?php
$conn->close();
?>
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
<!-- Footer -->
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
    