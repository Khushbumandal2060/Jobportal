<?php
session_start();
include('../includes/db.php');

// Check if the job ID is provided
if (!isset($_GET['id'])) {
    header("Location: job_listings.php");
    exit();
}

$job_id = $_GET['id'];

// Check if the user is logged in (as a job seeker)
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'job_seeker') {
    header("Location: login.php");
    exit();
}

// Handle the job application (insert into a job applications table)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];

    // Insert the application into the database
    $sql = "INSERT INTO job_applications (user_id, job_id) VALUES ('$user_id', '$job_id')";
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('You have successfully applied for the job.');</script>";
    } else {
        echo "<script>alert('Error applying for the job. Please try again later.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Apply for Job</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<header class="jp-header">
    <div class="jp-logo">
        <img src="../assets/images/svg_img1.png" alt="Job Portal Logo">
        <h1>Apply for Job</h1>
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
    <h2>Apply for the Job</h2>
    <form action="apply_job.php?id=<?php echo $_GET['id']; ?>" method="POST">
        <button type="submit">Submit Application</button>
    </form>
</div>

</body>
</html>
