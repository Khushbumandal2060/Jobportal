<?php
session_start();

// Check if the user is logged in and is an employer
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'employer') {
    header("Location: login.php");
    exit();
}

// Get the logged-in user's details
$userId = $_SESSION['id'];
$userName = $_SESSION['name'];
$userEmail = $_SESSION['email'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../assets/css/style.css">
    <title>Employer Dashboard</title>
    <style>
        /* Dashboard styles */
        .dashboard-container {
            margin: 30px auto;
            width: 80%;
            max-width: 1200px;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        h2 {
            text-align: center;
        }
        .dashboard-info {
            margin-bottom: 30px;
        }
        .dashboard-buttons {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 15px;
        }
        .dashboard-buttons a {
            padding: 12px 25px;
            background-color: #007bff;
            color: white;
            border-radius: 5px;
            text-decoration: none;
            font-size: 16px;
        }
        .dashboard-buttons a:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<header class="jp-header">
    <div class="jp-logo">
        <img src="../assets/images/svg_img1.png" alt="Job Portal Logo">
        <h1>Employer Dashboard</h1>
    </div>
    <nav class="jp-nav">
        <ul>
            <li><a href="../">Home</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </nav>
</header>

<div class="dashboard-container">
    <h2>Welcome, <?php echo $userName; ?>!</h2>
    <div class="dashboard-info">
        <p>Email: <?php echo $userEmail; ?></p>
    </div>
    <div class="dashboard-buttons">
        <a href="manage_jobs.php">Manage Job Postings</a>
        <a href="view_applications.php">View Job Applications</a>
        <a href="post_job.php">Post a New Job</a>
    </div>
</div>

</body>
</html>
