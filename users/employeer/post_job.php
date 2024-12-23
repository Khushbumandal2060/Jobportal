<?php
session_start();
include('../includes/db.php');

// Check if the user is logged in and is an employer
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'employer') {
    header("Location: login.php");
    exit();
}

// Handle job posting form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $location = mysqli_real_escape_string($conn, $_POST['location']);
    $salary = mysqli_real_escape_string($conn, $_POST['salary']);
    $employer_id = $_SESSION['id'];  // Employer's ID from session

    $sql = "INSERT INTO jobs (employer_id, title, description, location, salary) VALUES ('$employer_id', '$title', '$description', '$location', '$salary')";

    if (mysqli_query($conn, $sql)) {
        $success = "Job posted successfully!";
    } else {
        $error = "Error posting job. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Post a Job</title>
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
        <h1>Post a Job</h1>
    </div>
    <nav class="jp-nav">
        <ul>
            <li><a href="../">Home</a></li>
            <li><a href="employer_dashboard.php">Dashboard</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </nav>
</header>

<div class="form-container">
    <h2>Post a New Job</h2>

    <?php if (isset($success)) { echo "<div class='success'>$success</div>"; } ?>
    <?php if (isset($error)) { echo "<div class='error'>$error</div>"; } ?>

    <form action="post_job.php" method="POST">
        <label for="title">Job Title:</label>
        <input type="text" name="title" required>

        <label for="description">Job Description:</label>
        <textarea name="description" rows="5" required></textarea>

        <label for="location">Location:</label>
        <input type="text" name="location" required>

        <label for="salary">Salary:</label>
        <input type="number" name="salary" step="0.01" required>

        <button type="submit">Post Job</button>
    </form>
</div>

</body>
</html>
