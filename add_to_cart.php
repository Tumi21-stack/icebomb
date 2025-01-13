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

// Check if product_id is set in the POST request
if (isset($_POST['id'])) {
    $productId = $_POST['id'];
    
    // Fetch product details from the database based on product ID
    $query = $pdo->prepare("SELECT * FROM products WHERE id = ?");
    $query->execute([$productId]);
    $product = $query->fetch(PDO::FETCH_ASSOC);

    if ($product) {
        // Initialize session cart if it doesn't exist
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

       // Add to cart logic (assuming this is in your add to cart file)
$product_id = $_POST['id'];
$product_name = $_POST['name'];
$product_image = $_POST['image'];  // Ensure this field is coming from the form
$product_price = $_POST['price'];
$product_quantity = $_POST['quantity'];

// Check if the product is already in the cart
if (isset($_SESSION['cart'][$product_id])) {
    $_SESSION['cart'][$product_id]['quantity'] += $product_quantity;
} else {
    // Add new product to the cart
    $_SESSION['cart'][$product_id] = [
        'name' => $product_name,
        'image' => $product_image,  // Include the image here
        'price' => $product_price,
        'quantity' => $product_quantity
    ];
}

        $_SESSION['cart'][$productId] = $productData;

        echo "Product added to cart!";
    } else {
        echo "Error: Product not found.";
    }
} else {
    echo "Error: Product ID not provided.";
}
// Redirect to the cart page after adding
header("Location: cart.php");
exit();
if (isset($_POST["add_to_cart"])) {
    $product_id = $_POST["product_id"];
    
    // Check if the cart exists in the session
    if (!isset($_SESSION["cart"])) {
        $_SESSION["cart"] = [];
    }

    // Check if the product is already in the cart
    $found = false;
    foreach ($_SESSION["cart"] as $key => $item) {
        if ($item["product_id"] == $product_id) {
            // If found, increment the quantity instead of setting it to 0
            $_SESSION["cart"][$key]["quantity"] += 1; // Increment quantity
            $found = true;
            break;
        }
    }

    // If the product is not found, add it with quantity 1
    if (!$found) {
        $_SESSION["cart"][] = [
            "product_id" => $product_id,
            "quantity" => 1 // Start at 1 when first added
        ];
    }

    echo json_encode(["status" => "success", "message" => "Product added to cart"]);
    exit;
}

?>