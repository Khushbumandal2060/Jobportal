<?php
// Start the session if it's not already started (for handling authentication)
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Job Portal</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<!-- Header -->
<header class="jp-header">
    <div class="jp-logo">
        <img src="assets/images/images.png"  alt="Job Portal Logo">
        <h1><b>JobSphere</b></h1>
    </div>
    <nav class="jp-nav">
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="index.php">About Us</a></li>
            <li><a href="jobs/job_listings.php">Jobs</a></li>
            <li><a href="auth/login.php">Login</a></li>
            <li><a href="auth/register.php">Register</a></li>
            <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                <li><a href="admin/index.php">Admin Panel</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>