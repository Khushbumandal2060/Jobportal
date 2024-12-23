<?php
session_start();
include('../includes/db.php');

// Fetch all job listings from the database
$sql = "SELECT * FROM jobs ORDER BY posted_at DESC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Job Listings</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        /* General Styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7f6;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 80%;
            margin: 30px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .job-item {
            padding: 15px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .job-item h3 {
            margin-top: 0;
            font-size: 1.2em;
        }
        .job-item p {
            margin: 5px 0;
        }
        .view-details {
            color: #007bff;
            text-decoration: none;
        }
        .view-details:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<header class="jp-header">
    <div class="jp-logo">
        <img src="../assets/images/svg_img1.png" alt="Job Portal Logo">
        <h1>Job Listings</h1>
    </div>
    <nav class="jp-nav">
        <ul>
            <li><a href="../">Home</a></li>
            <li><a href="login.php">Login</a></li>
            <li><a href="register.php">Register</a></li>
        </ul>
    </nav>
</header>

<div class="container">
    <h2>Available Jobs</h2>
    <?php while ($job = mysqli_fetch_assoc($result)): ?>
        <div class="job-item">
            <h3><?php echo htmlspecialchars($job['job_title']); ?></h3>
            <p><strong>Location:</strong> <?php echo htmlspecialchars($job['location']); ?></p>
            <p><strong>Salary:</strong> $<?php echo number_format($job['salary'], 2); ?></p>
            <p><strong>Job Type:</strong> <?php echo htmlspecialchars($job['job_type']); ?></p>
            <p><a href="job_details.php?id=<?php echo $job['id']; ?>" class="view-details">View Details</a></p>
        </div>
    <?php endwhile; ?>
</div>

</body>
</html>
