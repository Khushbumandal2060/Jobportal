<?php
session_start();
include('../includes/db.php');

// Check if the user is logged in and is an employer
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'employer') {
    header("Location: login.php");
    exit();
}

$employer_id = $_SESSION['id'];  // Employer's ID from session

// Fetch all jobs posted by the employer
$sql = "SELECT * FROM jobs WHERE employer_id = '$employer_id' ORDER BY posted_at DESC";
$result = mysqli_query($conn, $sql);

// Handle job deletion
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $delete_sql = "DELETE FROM jobs WHERE id = '$delete_id' AND employer_id = '$employer_id'";

    if (mysqli_query($conn, $delete_sql)) {
        $success = "Job deleted successfully.";
    } else {
        $error = "Error deleting job. Please try again.";
    }
}

// Handle job editing (if any)
if (isset($_POST['edit_job'])) {
    $job_id = $_POST['job_id'];
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $location = mysqli_real_escape_string($conn, $_POST['location']);
    $salary = mysqli_real_escape_string($conn, $_POST['salary']);

    $update_sql = "UPDATE jobs SET title = '$title', description = '$description', location = '$location', salary = '$salary' WHERE id = '$job_id' AND employer_id = '$employer_id'";

    if (mysqli_query($conn, $update_sql)) {
        $success = "Job updated successfully.";
    } else {
        $error = "Error updating job. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Jobs</title>
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
        .job-list {
            width: 100%;
            border-collapse: collapse;
        }
        .job-list th, .job-list td {
            padding: 12px;
            border: 1px solid #ccc;
            text-align: center;
        }
        .job-list th {
            background-color: #f1f1f1;
        }
        .job-list td a {
            margin: 0 5px;
            text-decoration: none;
            color: #007bff;
        }
        .job-list td a:hover {
            text-decoration: underline;
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
        .form-container {
            margin-top: 30px;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        input, textarea {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
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
    </style>
</head>
<body>

<header class="jp-header">
    <div class="jp-logo">
        <img src="../assets/images/svg_img1.png" alt="Job Portal Logo">
        <h1>Manage Your Jobs</h1>
    </div>
    <nav class="jp-nav">
        <ul>
            <li><a href="../">Home</a></li>
            <li><a href="employer_dashboard.php">Dashboard</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </nav>
</header>

<div class="container">
    <h2>Your Posted Jobs</h2>

    <?php if (isset($success)) { echo "<div class='success'>$success</div>"; } ?>
    <?php if (isset($error)) { echo "<div class='error'>$error</div>"; } ?>

    <table class="job-list">
        <thead>
            <tr>
                <th>Job Title</th>
                <th>Location</th>
                <th>Salary</th>
                <th>Posted At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (mysqli_num_rows($result) > 0) {
                while ($job = mysqli_fetch_assoc($result)) {
                    echo "<tr>
                            <td>{$job['title']}</td>
                            <td>{$job['location']}</td>
                            <td>{$job['salary']}</td>
                            <td>{$job['posted_at']}</td>
                            <td>
                                <a href='#' data-toggle='modal' data-target='#editModal{$job['id']}'>Edit</a> |
                                <a href='?delete_id={$job['id']}'>Delete</a>
                            </td>
                        </tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No jobs posted yet.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<!-- Modal for Edit Job -->
<?php
if (mysqli_num_rows($result) > 0) {
    while ($job = mysqli_fetch_assoc($result)) {
        echo "<div id='editModal{$job['id']}' class='modal'>
                <div class='modal-content'>
                    <h3>Edit Job: {$job['title']}</h3>
                    <form action='manage_jobs.php' method='POST'>
                        <input type='hidden' name='job_id' value='{$job['id']}'>
                        <label for='title'>Job Title</label>
                        <input type='text' name='title' value='{$job['title']}' required>

                        <label for='description'>Description</label>
                        <textarea name='description' rows='5' required>{$job['description']}</textarea>

                        <label for='location'>Location</label>
                        <input type='text' name='location' value='{$job['location']}' required>

                        <label for='salary'>Salary</label>
                        <input type='number' name='salary' step='0.01' value='{$job['salary']}' required>

                        <button type='submit' name='edit_job'>Update Job</button>
                    </form>
                    <button class='close'>&times;</button>
                </div>
            </div>";
    }
}
?>

<script>
    // JavaScript for closing modals
    const closeButtons = document.querySelectorAll('.close');
    closeButtons.forEach(button => {
        button.addEventListener('click', () => {
            const modal = button.closest('.modal');
            modal.style.display = 'none';
        });
    });
</script>

</body>
</html>
