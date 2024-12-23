<?php
session_start();
include('../includes/db.php');

// Check if the user is logged in and is a job seeker
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'job_seeker') {
    header("Location: login.php");
    exit();
}

// Get job details from the URL
if (!isset($_GET['job_id'])) {
    header("Location: view_jobs.php");
    exit();
}

$job_id = $_GET['job_id'];
$sql = "SELECT * FROM jobs WHERE id = '$job_id'";
$result = mysqli_query($conn, $sql);
$job = mysqli_fetch_assoc($result);

// Handle job application
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $resume = mysqli_real_escape_string($conn, $_POST['resume']);
    $cover_letter = mysqli_real_escape_string($conn, $_POST['cover_letter']);
    $job_seeker_id = $_SESSION['id'];  // Job Seeker's ID from session

    $sql = "INSERT INTO applications (job_id, job_seeker_id, resume, cover_letter) VALUES ('$job_id', '$job_seeker_id', '$resume', '$cover_letter')";

    if (mysqli_query($conn, $sql)) {
        $success = "Application submitted successfully!";
    } else {
        $error = "Error applying for the job. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Apply for Job</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7f6;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .form-container {
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 600px;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        label {
            font-size: 14px;
            font-weight: bold;
            color: #333;
            display: block;
            margin-bottom: 5px;
        }
        input, textarea {
            width: 100%;
            padding: 12px;
            margin: 10px 0 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }
        button {
            width: 100%;
            padding: 12px;
            background-color: #007bff;
            color: white;
            font-size: 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
        .success, .error {
            text-align: center;
            margin-top: 20px;
        }
        .success {
            color: green;
        }
        .error {
            color: red;
        }
    </style>
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
            <li><a href="job_seeker_dashboard.php">Dashboard</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </nav>
</header>

<div class="form-container">
    <h2>Apply for Job: <?php echo $job['title']; ?></h2>

    <?php if (isset($success)) { echo "<div class='success'>$success</div>"; } ?>
    <?php if (isset($error)) { echo "<div class='error'>$error</div>"; } ?>

    <form action="apply_job.php?job_id=<?php echo $job_id; ?>" method="POST">
        <label for="resume">Resume (File Path):</label>
        <input type="text" name="resume" required>

        <label for="cover_letter">Cover Letter:</label>
        <textarea name="cover_letter" rows="5" required></textarea>

        <button type="submit">Submit Application</button>
    </form>
</div>

</body>
</html>
