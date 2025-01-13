<?php 
// Start the session
session_start();


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

if (isset($_POST['add_product'])) {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    $ingredients = $_POST['ingredients'];
    $image = $_FILES['image']['name'];
    $imagePath = 'images/' . basename($image);

    // Upload image to server
    move_uploaded_file($_FILES['image']['tmp_name'], $imagePath);

    // Insert into products table
    $stmt = $pdo->prepare("INSERT INTO products (name, description, price, stock, image, ingredients) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([$name, $description, $price, $stock, $imagePath, $ingredients]);

    // Get the inserted product's ID
    $productId = $pdo->lastInsertId();

    // Insert into product_overview table
    $stmtOverview = $pdo->prepare("INSERT INTO product_overview (product_id, name, image, price) VALUES (?, ?, ?, ?)");
    $stmtOverview->execute([$productId, $name, $imagePath, $price]);
}


// Handle deleting a product
if (isset($_POST['delete_product'])) {
    $productId = $_POST['product_id'];

    try {
        // Delete the product from the database
       // Prepare the first delete statement
    $stmt1 = $pdo->prepare("DELETE FROM products WHERE id = :id");
    $stmt1->execute(['id' => $productId]);

    // Prepare the second delete statement
    $stmt2 = $pdo->prepare("DELETE FROM product_overview WHERE id = :id");
    $stmt2->execute(['id' => $productId]);;

        echo "Product deleted successfully!";
    } catch (PDOException $e) {
        echo "Error deleting product: " . $e->getMessage();
    }
}

// Fetch data for the dashboard
$totalSales = $pdo->query('SELECT COUNT(*) FROM invoices WHERE status="FULFILLED"')->fetchColumn();
$totalProducts = $pdo->query('SELECT COUNT(*) FROM products')->fetchColumn();
$totalUsers = $pdo->query('SELECT COUNT(*) FROM subscribers')->fetchColumn();
$products = $pdo->query('SELECT * FROM products')->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ice Bomb Admin Dashboard</title>
    <style>
    * {
    box-sizing: border-box; /* Include padding and border in element's total width and height */
}

body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    margin: 0;
    padding: 0;
}

.header {
    background-color: #333;
    color: #fff;
    padding: 10px 20px;
    text-align: center;
    width: 100%; /* Ensure full width */
}

.sidebar {
    width: 250px;
    height: 100vh;
    background-color: #333;
    color: #fff;
    float: left;
    padding-top: 20px;
}

.sidebar a {
    display: block;
    color: #fff;
    text-decoration: none;
    padding: 10px 20px;
    margin-bottom: 10px;
}

.sidebar a:hover {
    background-color: #575757;
}

.content {
    margin-left: 250px; /* Adjust content margin based on sidebar width */
    padding: 20px;
}

/* Mobile Styles */
@media (max-width: 768px) {
    .sidebar {
        width: 100%; /* Sidebar full width on mobile */
        height: auto; /* Allow it to shrink */
        position: relative; /* Change to relative for stacking */
    }

    .content {
        margin-left: 0; /* Reset margin on mobile */
        padding: 10px; /* Add padding */
    }
}

.card {
    background-color: #fff;
    padding: 20px;
    margin-bottom: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

/* Add your existing styles here... */

.content h1 {
    color: #333;
}
.footer {
    clear: both;
    background-color: #333;
    color: #fff;
    text-align: center;
    padding: 10px;
    bottom: 0;
    width: 100%;
}

img {
    width: 100%;
    height: auto;
    border-radius: 8px;
    margin-bottom: 20px;
}

form {
    margin-bottom: 20px;
}

form input,
form textarea {
    display: block;
    width: 100%;
    margin-bottom: 10px;
    padding: 8px;
}

.product-list {
    margin-top: 20px;
}

.product-item {
    padding: 10px;
    border-bottom: 1px solid #ccc;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.product-item img {
    width: 50px;
    height: auto;
    border-radius: 5px;
    margin-right: 10px;
}

.product-item form {
    display: inline;
}

.product-item button {
    padding: 5px 10px;
    background-color: #d9534f;
    color: #fff;
    border: none;
    border-radius: 3px;
    cursor: pointer;
}

.product-item button:hover {
    background-color: #c9302c;
}

.product {
    border: 1px solid #ddd;
    padding: 20px;
    margin: 20px;
    border-radius: 8px;
    text-align: center;
}

.product img {
    max-width: 100%;
    height: auto;
}

.product-name {
    font-size: 18px;
    font-weight: bold;
    margin-top: 10px;
}

.product-price {
    color: #888;
    margin-top: 5px;
}

/* Style for the table */
table {
    width: 100%;
    border-collapse: collapse;
    margin: 20px 0;
    font-size: 18px;
    text-align: left;
}

table th,
table td {
    padding: 12px 15px;
    border: 1px solid #ddd;
}

table th {
    background-color: #f4f4f4;
    color: #333;
    font-weight: bold;
}

table tr:nth-child(even) {
    background-color: #f9f9f9;
}

table tr:hover {
    background-color: #f1f1f1;
}

/* Style for the action buttons */
button {
    padding: 8px 12px;
    background-color: #28a745;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

button:hover {
    background-color: #218838;
}

.remove-button {
    background-color: #dc3545;
}

.remove-button:hover {
    background-color: #c82333;
}


@media (max-width: 480px) {
    .sidebar a {
        padding: 8px; /* Smaller padding for links */
    }
    button {
        padding: 6px; /* Smaller button padding */
    }
}


    </style>
</head>
<body>
    <div class="header">
        <h1>Ice Bomb Admin Dashboard</h1>
    </div>
    <div class="sidebar">
        <a href="admin_dashboard.php">Dashboard</a>
        <a href="#product-section">Manage Products</a>
        <a href="admin_orders.php">Manage Orders</a>
        <a href="#newsletter-section">Send Newsletters</a>
        <a href="logout.php">Logout</a>
    </div>
    <div class="content">
        <h1>Welcome, Admin!</h1>
        <div class="card">
        <img src="images/MixedPackA.6ad51689.jpg" alt="Ice Bombs">
            <h2>Sales Overview</h2>
            <p>Total Sales: <?php echo number_format($totalSales); ?></p>
        </div>
        <div class="card">
            <h2>Product Overview</h2>
            <p>Number of Products: <?php echo $totalProducts; ?></p>
        </div>
        <div class="card">
            <h2>User Overview</h2>
            <p>Newsletter Subscribers: <?php echo $totalUsers; ?></p>
        </div>

        <!-- Add Product Form -->
        <section id="product-section">
        <div class="card">
            <h2>Add Product</h2>
            <form action="admin_dashboard.php" method="post" enctype="multipart/form-data">
                <input type="text" name="name" placeholder="Product Name" required>
                <textarea name="description" placeholder="Product Description" required></textarea>
                <input type="number" name="price" placeholder="Price" step="0.01" required>
                <input type="number" name="stock" placeholder="Stock" required>
                <p>Upload Image</p>
                <input type="file" name="image" required>
                <textarea name="quantity" placeholder="Quantity (separate by commas)" required></textarea>
                <textarea name="ingredients" placeholder="Ingredients (separate by commas)" required></textarea>
                <button type="submit" name="add_product">Add Product</button>
            </form>
       
   
        <!-- Product List Section -->
        <div class="product-list">
            <h3>Current Products</h3>
            <?php if (!empty($products)): ?>
                <?php foreach ($products as $product): ?>
                    <div class="product-item">
                        <div>
                            <img src="<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>">
                            <strong><?php echo $product['name']; ?></strong> - R<?php echo number_format($product['price'], 2); ?>
                        </div>
                        <form method="POST" action="">
                            <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                            <button type="submit" name="delete_product">Remove</button>
                        </form>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No products found in the database.</p>
            <?php endif; ?>
        </div>
    </div>
</div>
<section id="newsletter-section">
<div class="content">
    <h2>Send Newsletter</h2>
    <form action="send_newsletter.php" method="POST">
        <label for="subject">Subject:</label>
        <input type="text" id="subject" name="subject" placeholder="Enter newsletter subject" required>
        <p>Upload Image</p>
                <input type="file" name="image" >

        <label for="message">Message:</label>
        <textarea id="message" name="message" placeholder="Write your newsletter message here..." required></textarea>

        <button type="submit">Send Newsletter</button>
    </form>
</div>



        <div class="footer">
        <p>&copy; 2024 Ice Bombs. All rights reserved.</p>
    </div>
</body>
</html>
