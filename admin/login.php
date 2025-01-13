<?php
session_start();

// Include the database connection file (make sure the connection is established here)
require_once 'db.php';

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if the default admin record exists in the row with id 1
$sql_check_admin = "SELECT id FROM admins WHERE id = ?";
$stmt_check_admin = $conn->prepare($sql_check_admin);
if (!$stmt_check_admin) {
    die("Error preparing statement: " . $conn->error);
}

$stmt_check_admin->bind_param('i', $id);
$id = 1;
$stmt_check_admin->execute();
$result_check_admin = $stmt_check_admin->get_result();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if username and password are set in the POST array
    if (isset($_POST['username']) && isset($_POST['password'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Fetch admin's password from the database (only from the default admin record with id 1)
        $sql = "SELECT password FROM admins WHERE id = ?";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            die("Error preparing select statement: " . $conn->error);
        }

        $stmt->bind_param('i', $id);
        $id = 1; // Get the password for admin with ID 1
        $stmt->execute();
        $stmt->bind_result($stored_password); // No longer hashed, so it stores the plain text password
    $stmt->fetch();
        $stmt->close();

       // Direct string comparison (not recommended for secure systems)
    if (empty($password) || $password !== $stored_password) {
        $error = "Invalid username or password"; // Set error message for incorrect credentials
    } else {
        $_SESSION['admin_logged_in'] = true;
        header('Location: admin_dashboard.php');
        exit();
    }
}}
// Close the connection at the very end of your script
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script>
        // Function to toggle password visibility
        function togglePassword() {
            var passwordField = document.getElementById("password");
            var checkbox = document.getElementById("showPasswordCheckbox");
            if (checkbox.checked) {
                passwordField.type = "text";
            } else {
                passwordField.type = "password";
            }
        }
    </script>
    </head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h2 class="text-center my-4">Admin Login</h2>
                <?php if (!empty($error)): ?>
                    <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
                <?php endif; ?>
                <form action="login.php" method="post">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" id="username" name="username" value="<?php echo htmlspecialchars(isset($_POST['username']) ? $_POST['username'] : ''); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                        <input type="checkbox" id="showPasswordCheckbox" onclick="togglePassword()"> Show Password
                    </div>
                    <button type="submit" class="btn btn-primary">Login</button>
                     </form>
            </div>
        </div>
    </div>
</body>
<style>
body, html {
    background-color: #b0c4de;  /* Light blue background for the whole page */
}
</style>
</html>