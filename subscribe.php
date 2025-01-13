<?php
include 'db.php'; // Include your database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];

    // Validate email
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Prepare an insert statement
        $stmt = $conn->prepare("INSERT INTO subscribers (email) VALUES (?)");
        $stmt->bind_param("s", $email);

        // Execute the query
        if ($stmt->execute()) {
            // Optionally display a success message
            echo "You have successfully subscribed!";
            
            // Redirect to the home page after a few seconds
            header("Refresh: 3; URL=index.php");
            echo "You will be redirected to the home page in 3 seconds.";
            exit(); // Make sure to stop further script execution after the redirect
        } else {
            echo "There was an error. Please try again.";
        }

        // Close the statement and connection
        $stmt->close();
        $conn->close();
    } else {
        echo "Invalid email address.";
    }
}
?>
