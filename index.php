<?php
session_start();
?>

<!-- HTML content of index.php -->

<?php if (isset($_SESSION['success_message'])): ?>
    <div class="alert alert-success" role="alert">
        <?php echo $_SESSION['success_message']; ?>
    </div>
    <script>
        alert("<?php echo $_SESSION['success_message']; ?>");
    </script>
    <?php unset($_SESSION['success_message']); // Clear the message after displaying ?>
<?php endif; ?>

<?php if (isset($_SESSION['error_message'])): ?>
    <div class="alert alert-danger" role="alert">
        <?php echo $_SESSION['error_message']; ?>
    </div>
    <script>
        alert("<?php echo $_SESSION['error_message']; ?>");
    </script>
    <?php unset($_SESSION['error_message']); // Clear the message after displaying ?>
<?php endif; ?>

<!-- Rest of your homepage HTML -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ice Bomb Home</title>
    <link rel="stylesheet" href="style.css">
</head>
<style>
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
        }

        .hero.active {
            transform: translateY(200px);
            transition: transform 0.3s ease;
        }

        /* Grid for Action Sections */
        .grid-container {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            padding: 40px;
        }

        .grid-item {
            background-size: cover;
            background-position: center;
            height: 300px;
            border-radius: 15px;
            position: relative;
        }

        .action-button {
            position: absolute;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            background-color: rgba(0, 0, 0, 0.6);
            color: #fff;
            padding: 10px 20px;
            border-radius: 20px;
            text-decoration: none;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        .action-button:hover {
            background-color: rgba(0, 0, 0, 0.8);
        }

        /* About Section */
        .about-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 40px;
            background-color: #f9f9f9;
            margin-top: 30px;
        }

        .certifications img {
            width: 100px;
            margin: 0 15px;

        }.certifications {
 
    justify-content: center;
    margin-bottom: 20px;
    margin-left: 20px; /* Add margin to move the logos to the right */
}

        .ice-lolly-image {
    width: 70%; /* Adjust the width to 50% of the container */
    max-width: 300px; /* Set a max width to prevent it from getting too large on bigger screens */
    border-radius: 15px;
    margin-top: 30px;
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
}.certifications {
        margin-bottom: 40px; /* Adjusts the spacing between the certifications and the about content */
        margin: 40px 90px;
    }

    .about-content {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        text-align: center;
        margin-top: 10px; /* You can add a slight margin-top to create balance */
    }

    .about-content p {
        font-size: 18px;
        line-height: 1.6;
        margin: 40px 90px;
        max-width: 500px;
    }

    .about-btn {
        padding: 10px 20px;
        background-color: #000;
        color: #fff;
        text-decoration: none;
        border-radius: 20px;
        transition: background-color 0.3s ease;
    }

    .about-btn:hover {
        background-color: #444;
    }
        /* Video Section */
        .video-section iframe {
            width: 100%;
            height: auto;
          
            margin-top: 20px;
        }

        /* Newsletter Section */
        .newsletter {
            background-color: #f5f5f5;
            padding: 40px;
            text-align: center;
        }

        .newsletter h2 {
            margin-bottom: 20px;
            font-size: 24px;
        }

        .newsletter input[type="email"] {
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ddd;
            border-radius: 5px;
            width: 250px;
        }

        .newsletter button {
            padding: 10px 20px;
            font-size: 16px;
            background-color: #333;
            color: #fff;
            border: none;
            border-radius: 5px;
            margin-left: 10px;
            cursor: pointer;
        }

        .newsletter button:hover {
            background-color: #555;
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
        }  .newsletter input[type="email"] {
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
/* Tablets and Medium Screens */
@media (max-width: 992px) {
    .grid-container {
        grid-template-columns: repeat(2, 1fr); /* Adjust grid for tablets */
    }

    .video-section iframe {
        height: 400px; /* Reduce video height on smaller screens */
    }

    .newsletter input[type="email"] {
        width: 250px;
    }
}

</STYle>
<body>

    <!-- Header -->
    <header class="header">
        <div class="logo">
            <img src="images/Ice Bomb Logo.8ed06360.png" alt="Ice Bomb Logo">
        </div>
        <nav class="nav">
            <ul id="nav-list">
                <li><a href="Shop.php">Shop</a></li>
                <li><a href="About.html">About</a></li>
                <li><a href="Stocklist.html">Stockists</a></li>
                <li><a href="Wholesale.html">Wholesale</a></li>
                <li><a href="Events.html">Events</a></li>
                <li><a href="ContactUs.html">Contact</a></li>
                <li><a href="Cart.php">Cart</a></li>
            </ul>

            <!-- Hamburger Menu Icon -->
            <div class="menu-icon">
                <img src="images/menu.png" alt="Menu Icon" id="menu-toggle">
            </div>

            <!-- Close Icon for the Menu -->
            <div class="close-icon" id="close-menu">
                <span>&times;</span> <!-- "X" Icon -->
            </div>
        </nav>
    </header>

    <!-- Hero Section -->
    <section class="hero">
        <img src="images/heropage.0cb67446.jpg1.jpg" alt="Ice Bomb Hero Image">
    </section>

    <!-- Action Sections -->
    <section class="grid-container">
        <div class="grid-item" style="background-image: url('images/lemon.jpg');">
            <a href="Shop.php" class="action-button">Online Shop</a>
        </div>
        <div class="grid-item" style="background-image: url('images/strawberry.jpg');">
            <a href="Stocklist.html" class="action-button">Find a Store</a>
        </div>
        <div class="grid-item" style="background-image: url('images/litchi.jpg');">
            <a href="Wholesale.html" class="action-button">Become a Stockist</a>
        </div>
        <div class="grid-item" style="background-image: url('images/granadilla.jpg');">
            <a href="Events.html" class="action-button">Functions & Events</a>
        </div>
        <div class="grid-item" style="background-image: url('images/pineapples.jpg');">
            <a href="About.html" class="action-button">Ice Bomb Squad</a>
        </div>
        <div class="grid-item" style="background-image: url('images/mangos.jpg');">
            <a href="ContactUs.html" class="action-button">Get in Touch</a>
        </div>
    </section>

    <!-- About Section -->
    <section class="about-section">
        <!-- Certification Logos -->
        <div class="certifications">
            <img src="images/Picture1.webp" alt="Halal Certification">
            <img src="images/Picture2.webp" alt="Pareve Certification">
            <img src="images/Picture3.webp" alt="Vegan Certification">
        </div>

        <!-- Ice Lolly Image -->
        <div class="about-content">
            <img src="images/3da34f_98eb5c83809f4d50a66f4598df0ed0b4~mv2.webp" alt="Child eating Ice Lolly"
                class="ice-lolly-image">

            <!-- Text Description -->
            <p>When you bite into an Ice Bomb real fruit ice lolly, all you will taste is the refreshingly bright taste of real fruit! Made from locally-sourced, sun-ripened fruit – each Ice Bomb is packed full of real fruity goodness!</p>

            <!-- About Us Button -->
            <a href="About.html" class="about-btn">About Us</a>
        </div>
    </section>

    <!-- Video Section -->
    <section class="video-section">
        <iframe src="https://icebombs.co.za/assets/celebrate%20may-2%20(1).19213412.mp4" frameborder="0"></iframe>
    </section>

    <!-- Newsletter Section -->
    <section class="newsletter">
        <h2>Get timely updates from the Ice Bomb Squad!</h2>
        <form action="subscribe.php" method="POST">
            <input type="email" name="email" placeholder="Your email" required>
            <button type="submit">Subscribe</button>
        </form>
    </section>
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
            <li><a href="ContactUs.">Contact</a></li>
            <li><a href="Terms.html">Terms</a></li>
            <li><a href="Privacy.html">Privacy</a></li>
        </ul>
    </footer>

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

   
</body>
</html>
