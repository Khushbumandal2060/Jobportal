<?php
// Include necessary files
require_once '../includes/db.php'; // Database connection
require_once '../includes/functions.php'; // Helper functions

// Initialize variables
$error = '';
$success = '';

// Check if a token is provided in the URL
if (isset($_GET['token'])) {
    $token = $_GET['token'];
    
    // Validate the token in the database
    $stmt = $conn->prepare("SELECT email FROM password_resets WHERE token = ? LIMIT 1");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        $email = $row['email'];
    } else {
        $error = "Invalid or expired token.";
    }
    $stmt->close();
} else {
    $error = "No reset token provided.";
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reset_password'])) {
    if (isset($email)) {
        $new_password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];

        // Validate passwords
        if (empty($new_password) || empty($confirm_password)) {
            $error = "Please fill in all fields.";
        } elseif ($new_password !== $confirm_password) {
            $error = "Passwords do not match.";
        } elseif (strlen($new_password) < 6) {
            $error = "Password must be at least 6 characters long.";
        } else {
            // Hash the new password
            $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);

            // Update the user's password in the database
            $stmt = $conn->prepare("UPDATE users SET password = ? WHERE email = ?");
            $stmt->bind_param("ss", $hashed_password, $email);
            
            if ($stmt->execute()) {
                // Delete the reset token
                $stmt = $conn->prepare("DELETE FROM password_resets WHERE email = ?");
                $stmt->bind_param("s", $email);
                $stmt->execute();
                $stmt->close();

                $success = "Your password has been successfully reset. You can now <a href='login.php'>log in</a>.";
            } else {
                $error = "An error occurred while resetting your password. Please try again.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="container">
        <h2>Reset Password</h2>
        
        <?php if (!empty($error)): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <?php if (!empty($success)): ?>
            <div class="success"><?php echo $success; ?></div>
        <?php else: ?>
            <form id="resetForm" action="" method="POST">
                <div class="form-group">
                    <label for="password">New Password</label>
                    <input type="password" id="password" name="password" required>
                    <small class="error-message" id="passwordError"></small>
                </div>
                <div class="form-group">
                    <label for="confirm_password">Confirm New Password</label>
                    <input type="password" id="confirm_password" name="confirm_password" required>
                    <small class="error-message" id="confirmPasswordError"></small>
                </div>
                <button type="submit" name="reset_password">Reset Password</button>
            </form>
        <?php endif; ?>
    </div>

    <script>
        // JavaScript for client-side validation
        document.getElementById('resetForm').addEventListener('submit', function(e) {
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirm_password').value;
            const passwordError = document.getElementById('passwordError');
            const confirmPasswordError = document.getElementById('confirmPasswordError');

            let isValid = true;

            // Clear previous error messages
            passwordError.textContent = '';
            confirmPasswordError.textContent = '';

            // Validate password length
            if (password.length < 6) {
                passwordError.textContent = 'Password must be at least 6 characters long.';
                isValid = false;
            }

            // Validate matching passwords
            if (password !== confirmPassword) {
                confirmPasswordError.textContent = 'Passwords do not match.';
                isValid = false;
            }

            // Prevent form submission if validation fails
            if (!isValid) {
                e.preventDefault();
            }
        });
    </script>
</body>
</html>
