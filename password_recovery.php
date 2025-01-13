<?php
require 'db.php'; // Include the database connection
require 'vendor/autoload.php'; // PHPMailer autoload
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
$error = '';
$success = '';

// Handle the form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];

    // Check if the email exists in the database
    $sql = "SELECT id FROM admins WHERE email = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $stmt->store_result();
        
        if ($stmt->num_rows > 0) {
            // Generate a unique token
            $token = bin2hex(random_bytes(50));
            
            // Store the token and expiration in the database
            $stmt->bind_result($admin_id);
            $stmt->fetch();
            $stmt->close();

            $sql = "UPDATE admins SET reset_code = ? WHERE email = ?";
            $stmt = $conn->prepare($sql);
            if ($stmt) {
                $stmt->bind_param('ss', $token, $email);
                $stmt->execute();
                $stmt->close();
                
                $token = bin2hex(random_bytes(32)); // Securely generate a random token
$reset_link = "http://localhost/icebomb/reset_password.php?token=" . $token;

                // Email setup using PHPMailer
                $mail = new PHPMailer();
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com'; // Your SMTP server
                $mail->SMTPAuth = true;
                $mail->Username = 'icebombs01@gmail.com'; // Your email
                $mail->Password = 'cgdtgudfopunqrmq'; // Your email password
                $mail->SMTPSecure = 'tls';
                $mail->Port = 587;

                $mail->setFrom('no-reply@icebomb.com', 'Ice Bombs');
                $mail->addAddress($email);

                $mail->isHTML(true);
                $mail->Subject = 'Password Reset Request';
                $mail->Body    = "Click on the link below to reset your password:<br><a href='$reset_link'>$reset_link</a>";
                
                if ($mail->send()) {
                    $success = 'A password reset link has been sent to your email.';
                } else {
                    $error = 'Failed to send the email. Please try again later.';
                }
            }
        } else {
            $error = 'No account found with that email.';
        }
    }
   
}

// Close the connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h2 class="text-center my-4">Forgot Password</h2>
                <?php if (!empty($error)): ?>
                    <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
                <?php elseif (!empty($success)): ?>
                    <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
                <?php endif; ?>
                <form action="password_recovery.php" method="post">
                    <div class="form-group">
                        <label for="email">Enter your email address</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Send Reset Link</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
