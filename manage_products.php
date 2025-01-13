<?php
// Database connection
include 'db.php';

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Add product
if (isset($_POST['add'])) {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $image = $_FILES['image']['name'];
    $ingredients = $_POST['ingredients'];
    $stock = $_POST['stock'];
    $quantity = $_POST['quantity'];
    $product_id = $_POST['product_id'];

    // Move uploaded image to the 'uploads' folder
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($image);
    move_uploaded_file($_FILES['image']['tmp_name'], $target_file);

    $sql = "INSERT INTO products (name, description, price, image, ingredients, stock, quantity, product_id)
            VALUES ('$name', '$description', '$price', '$image', '$ingredients', '$stock', '$quantity', '$product_id')";

    if ($conn->query($sql)) {
        echo "<script>$(document).ready(function(){ alert('Product added successfully'); });</script>";
    }
}

// Edit product
if (isset($_POST['edit'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $image = $_FILES['image']['name'];
    $ingredients = $_POST['ingredients'];
    $stock = $_POST['stock'];
    $quantity = $_POST['quantity'];
    $product_id = $_POST['product_id'];

    if (!empty($image)) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($image);
        move_uploaded_file($_FILES['image']['tmp_name'], $target_file);

        $sql = "UPDATE products SET name='$name', description='$description', price='$price', image='$image', ingredients='$ingredients', stock='$stock', quantity='$quantity', product_id='$product_id' WHERE id=$id";
    } else {
        $sql = "UPDATE products SET name='$name', description='$description', price='$price', ingredients='$ingredients', stock='$stock', quantity='$quantity', product_id='$product_id' WHERE id=$id";
    }

    if ($conn->query($sql)) {
        echo "<script>$(document).ready(function(){ alert('Product updated successfully'); });</script>";
    }
}

// Delete product
if (isset($_POST['delete'])) {
    $id = $_POST['id'];

    $sql = "DELETE FROM products WHERE id=$id";
    if ($conn->query($sql)) {
        echo "<script>$(document).ready(function(){ alert('Product deleted successfully'); });</script>";
    }
}

// Fetch all products
$result = $conn->query("SELECT * FROM products");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Products</title>
    <!-- Bootstrap CSS CDN -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- jQuery CDN -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- Bootstrap JS CDN -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style>
        .container {
            margin-top: 20px;
        }
        .form-group img {
            max-width: 150px;
            height: auto;
        }
        table {
            margin-top: 20px;
        }
    </style>
</head>
<body>

<div class="container">
    <h1 class="text-center">Manage Products</h1>

    <!-- Add/Edit Form -->
    <form method="POST" action="manage_products.php" enctype="multipart/form-data">
        <input type="hidden" name="id" value="">

        <div class="form-group">
            <label for="name">Product Name</label>
            <input type="text" class="form-control" name="name" placeholder="Enter product name" required>
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea class="form-control" name="description" placeholder="Enter product description" required></textarea>
        </div>

        <div class="form-group">
            <label for="price">Price</label>
            <input type="number" class="form-control" name="price" placeholder="Enter price" step="0.01" required>
        </div>

        <div class="form-group">
            <label for="image">Product Image</label>
            <input type="file" class="form-control-file" name="image" accept="image/*">
        </div>

        <div class="form-group">
            <label for="ingredients">Ingredients</label>
            <textarea class="form-control" name="ingredients" placeholder="Enter ingredients" required></textarea>
        </div>

        <div class="form-group">
            <label for="stock">Stock</label>
            <input type="number" class="form-control" name="stock" placeholder="Enter stock quantity" required>
        </div>

        <div class="form-group">
            <label for="quantity">Quantity</label>
            <input type="text" class="form-control" name="quantity" placeholder="Enter quantity" required>
        </div>

        <div class="form-group">
            <label for="product_id">Product ID</label>
            <input type="text" class="form-control" name="product_id" placeholder="Enter product ID">
        </div>

        <button type="submit" name="add" class="btn btn-primary">Add Product</button>
    </form>

    <!-- Products Table -->
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Description</th>
                <th>Price</th>
                <th>Image</th>
                <th>Ingredients</th>
                <th>Stock</th>
                <th>Quantity</th>
                <th>Product ID</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['name']; ?></td>
                <td><?php echo $row['description']; ?></td>
                <td>$<?php echo $row['price']; ?></td>
                <td><img src="uploads/<?php echo $row['image']; ?>" alt="Product Image" class="img-thumbnail"></td>
                <td><?php echo $row['ingredients']; ?></td>
                <td><?php echo $row['stock']; ?></td>
                <td><?php echo $row['quantity']; ?></td>
                <td><?php echo $row['product_id']; ?></td>
                <td>
                    <form method="POST" action="manage_products.php">
                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                        <button type="submit" name="edit" class="btn btn-warning">Edit</button>
                        <button type="submit" name="delete" class="btn btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

</body>
</html>
