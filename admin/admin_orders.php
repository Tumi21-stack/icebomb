<?php
session_start();
include 'db.php'; // Database connection

// Fetch orders from the database instead of the session
$sql = "SELECT * FROM invoices"; // Adjust your SQL as necessary
$result = $conn->query($sql);

$orders = [];
if ($result) {
    while ($row = $result->fetch_assoc()) {
        // Assuming the database has columns that match your session structure
        $orders[$row['order_id']] = $row; // or whatever key you need
    }
} else {
    echo "Error fetching orders: " . htmlspecialchars($conn->error);
}

// Handle search request if order ID is set
$search_order_id = isset($_POST['search_order_id']) ? $_POST['search_order_id'] : '';
$filtered_orders = [];

// Filter orders if a search is performed
if (!empty($search_order_id)) {
    foreach ($orders as $order_id => $order) {
        if (str_contains($order_id, $search_order_id)) {
            $filtered_orders[$order_id] = $order;
        }
    }
} else {
    $filtered_orders = $orders; // Show all orders if no search is performed
}

// Check for new orders (only count orders that are not shipped or fulfilled)
$new_orders_count = 0;
foreach ($filtered_orders as $order) {
    if ($order['status'] !== 'SHIPPED' && $order['status'] !== 'FULFILLED') {
        $new_orders_count++;
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Orders</title>
    <link rel="stylesheet" href="styles.css"> <!-- Link your CSS file -->
    <style>
        
        /* General body styling */
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
            margin: 0;
            padding: 0;
        }
         /* Notification styling */
         .notification {
            background-color: #ffcc00;
            color: #333;
            text-align: center;
            padding: 10px;
            margin: 20px 0;
            display: <?= $new_orders_count > 0 ? 'block' : 'none' ?>; /* Show if there are new orders */
        }body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
            margin: 0;
            padding: 0;
        }
        

        /* Container for the table */
        .table-container {
            width: 90%;
            margin: 50px auto;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            background-color: #fff;
            border-radius: 8px;
            padding: 20px;
        }

        /* Table styling */
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 16px;
        }

        th, td {
            padding: 12px 15px;
            text-align: left;
        }

        th {
            background-color: #333;
            color: white;
            text-transform: uppercase;
        }

        td {
            background-color: #f9f9f9;
        }

        /* Striped rows */
        tr:nth-child(even) td {
            background-color: #f1f1f1;
        }

        /* Hover effect */
        tr:hover td {
            background-color: #e0e0e0;
        }

        /* Style the dropdown and button */
        select, button {
            padding: 8px 12px;
            font-size: 14px;
            border: 1px solid #333;
            border-radius: 4px;
            background-color: white;
            color: #333;
            cursor: pointer;
            outline: none;
        }

        button {
            margin-left: 10px;
        }

        button:hover {
            background-color: #333;
            color: white;
        }

        /* Table header and body */
        thead {
            border-bottom: 2px solid #333;
        }

        tbody tr td:first-child {
            font-weight: bold;
        }

        /* Title */
        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        .footer {
            background-color: #333;
            color: #fff;
            text-align: center;
            padding: 10px;
            position: fixed;
            bottom: 0;
            width: 100%;
            left: 0;
            z-index: 1000; /* Ensures it stays above other elements */
        }

        /* Header Styling */
        .header {
            background-color: #333;
            color: #fff;
            text-align: center;
            padding: 20px 0;
        }

        /* Navbar styling */
        .navbar {
            background-color: #333;
            overflow: hidden;
            display: flex;
            justify-content: center;
            padding: 10px 0;
        }

        .navbar a {
            display: inline-block;
            color: #fff;
            text-align: center;
            padding: 10px 20px;
            text-decoration: none;
            margin: 0 10px;
        }

        .navbar a:hover {
            background-color: #575757;
        }

        /* Main content area */
        .content {
            padding: 20px;
            text-align: center;
        }/* Container for the table */
.table-container {
    width: 90%; /* Keeps the container responsive */
    margin: 50px auto;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    background-color: #fff;
    border-radius: 8px;
    padding: 20px;
    overflow-x: auto; /* Allow horizontal scrolling */
}

/* Table styling */
table {
    width: 100%; /* Ensures the table fills the container */
    border-collapse: collapse;
    font-size: 16px; /* You can adjust font-size as needed */
}

th, td {
    padding: 12px 15px;
    text-align: left;
    word-wrap: break-word; /* Allows long words to break and wrap */
}

td {
    background-color: #f9f9f9;
}

/* Responsive Design for smaller screens */
@media (max-width: 768px) {
    th, td {
        padding: 10px; /* Reduce padding for smaller screens */
        font-size: 14px; /* Slightly smaller text for readability */
    }

    /* Adjust title size on small screens */
    h1 {
        font-size: 24px; /* Adjust title font size */
    }
    
}
  /* Container for the search form */
  .search-container {
            text-align: center;
            margin: 20px 0;
        }

        /* Style the search box and button */
        .search-container input[type="text"] {
            padding: 8px;
            font-size: 14px;
            border: 1px solid #333;
            border-radius: 4px;
            width: 200px; /* Set a fixed width for the input */
        }

        .search-container button {
            padding: 8px 12px;
            font-size: 14px;
            border: 1px solid #333;
            border-radius: 4px;
            background-color: #333;
            color: white;
            cursor: pointer;
            outline: none;
            margin-left: 10px;
        }

        .search-container button:hover {
            background-color: #575757;
        }
    </style>
</head>
<body>
    


    
    <!-- Navbar at the top -->
    <div class="navbar">
        <a href="admin_dashboard.php">Dashboard</a>
        <a href="logout.php">Logout</a>
    </div>
    
    <h1>Orders Overview</h1>
    
<!-- Notification for new orders -->
<div class="notification">
        <?php if ($new_orders_count > 0): ?>
            You have <?= $new_orders_count ?> new order<?= $new_orders_count > 1 ? 's' : '' ?>!
        <?php endif; ?>
    </div>
    

    <div class="search-container">
        <form method="POST" action="">
            <input type="text" name="search_order_id" placeholder="Search Order ID" value="<?php echo htmlspecialchars($search_order_id); ?>">
            <button type="submit">Search For Order</button>
        </form>
    </div>
    
    <div class="table-container">
        <table border="1">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Invoice Number</th>
                    <th>Customer Email</th>
                    <th>Phone</th>
                    <th>Amount</th>
                    <th>Items</th>
                    <th>Shipping Address</th>
                    <th>Ordered At</th> <!-- New Column -->
                    <th>Status</th>
                    <th>Change Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Loop through each order in the filtered orders
                foreach ($filtered_orders as $order_id => $order) {
                    $invoice_number = $order['invoice_number'];
                    $customer_email = $order['customer_email'];
                    $customer_phone = $order['customer_phone'];
                    $total = number_format($order['amount'], 2);
                    $items = $order['item_list'];
                    $address = "{$order['shipping_address']}, {$order['shipping_city']}, {$order['shipping_postal_code']}, {$order['province']}, {$order['shipping_country']}";
                    $created_at = date("Y-m-d H:i:s", strtotime($order['created_at'])); // Format created_at
                    $status = $order['status']; // Assuming status is part of the fetched order data

                    echo "
                    <tr>
                        <td>{$order_id}</td>
                        <td>{$invoice_number}</td>
                        <td>{$customer_email}</td>
                        <td>{$customer_phone}</td>
                        <td>R {$total}</td>
                        <td>{$items}</td>
                        <td>{$address}</td>
                        <td>{$created_at}</td> 
                        <td>{$status}</td>
                        <td>
                            <form method='POST' action='update_order_status.php'>
                                <input type='hidden' name='invoice_number' value='{$invoice_number}' />
                                <select name='new_status'>
                                    <option value='PAID' ".($status === 'PAID' ? 'selected' : '').">Paid</option>
                                    <option value='SHIPPED' ".($status === 'SHIPPED' ? 'selected' : '').">Shipped</option>
                                    <option value='FULFILLED' ".($status === 'FULFILLED' ? 'selected' : '').">Fulfilled</option>
                                </select>
                                <button type='submit'>Update</button>
                                <button type='submit' name='delete' value='true'>Delete Invoice</button>
                            </form>
                        </td>
                    </tr>
                    ";
                }
                ?>
            </tbody>
        </table>
    </div>

    <div class="footer">
        <p>&copy; 2024 Ice Bombs. All rights reserved.</p>
    </div>
</body>
</html>

<?php
$conn->close();
?>
