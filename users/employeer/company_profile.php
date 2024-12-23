<?php
session_start();
include('../includes/db.php');

// Ensure the user is logged in and is an employer
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'employer') {
    header("Location: login.php");
    exit();
}

$employer_id = $_SESSION['id'];  // Get the employer's ID from session

// Fetch the company profile for the logged-in employer
$sql = "SELECT * FROM company_profiles WHERE employer_id = '$employer_id'";
$result = mysqli_query($conn, $sql);
$company = mysqli_fetch_assoc($result);

// Update company profile if the form is submitted
if (isset($_POST['update_profile'])) {
    $company_name = mysqli_real_escape_string($conn, $_POST['company_name']);
    $company_description = mysqli_real_escape_string($conn, $_POST['company_description']);
    $company_contact = mysqli_real_escape_string($conn, $_POST['company_contact']);

    // Handle logo upload
    $company_logo = $company['company_logo']; // Default to current logo if not updated
    if ($_FILES['company_logo']['name']) {
        $target_dir = "../uploads/logos/";
        $target_file = $target_dir . basename($_FILES["company_logo"]["name"]);
        if (move_uploaded_file($_FILES["company_logo"]["tmp_name"], $target_file)) {
            $company_logo = basename($_FILES["company_logo"]["name"]);
        }
    }

    // Update company profile in the database
    $update_sql = "UPDATE company_profiles SET 
                    company_name = '$company_name', 
                    company_logo = '$company_logo',
                    company_description = '$company_description', 
                    company_contact = '$company_contact' 
                    WHERE employer_id = '$employer_id'";

    if (mysqli_query($conn, $update_sql)) {
        $success_message = "Company profile updated successfully.";
    } else {
        $error_message = "Error updating company profile. Please try again.";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Company Profile</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        /* General Styles */
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
        .company-logo {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border-radius: 50%;
            margin-bottom: 20px;
        }
        .form-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        label {
            font-size: 14px;
            font-weight: bold;
            color: #333;
            display: block;
            margin-bottom: 5px;
        }
        input[type="text"], input[type="file"], textarea {
            width: 100%;
            padding: 12px;
            margin: 10px 0 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
            box-sizing: border-box;
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
        .form-footer {
            text-align: center;
            margin-top: 10px;
        }
        .form-footer a {
            color: #007bff;
            text-decoration: none;
        }
        .form-footer a:hover {
            text-decoration: underline;
        }
        .message {
            text-align: center;
            margin-top: 20px;
        }
        .message.success {
            color: green;
        }
        .message.error {
            color: red;
        }
    </style>
</head>
<body>

<header class="jp-header">
    <div class="jp-logo">
        <img src="../assets/images/svg_img1.png" alt="Job Portal Logo">
        <h1>Company Profile</h1>
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
    <h2>Update Your Company Profile</h2>

    <!-- Display success or error messages -->
    <?php if (isset($success_message)) { echo "<div class='message success'>$success_message</div>"; } ?>
    <?php if (isset($error_message)) { echo "<div class='message error'>$error_message</div>"; } ?>

    <div class="form-container">
        <form action="company_profile.php" method="POST" enctype="multipart/form-data">
            <!-- Display current company logo -->
            <div style="text-align: center;">
                <?php if ($company && $company['company_logo']): ?>
                    <img src="../uploads/logos/<?php echo $company['company_logo']; ?>" alt="Company Logo" class="company-logo">
                <?php else: ?>
                    <img src="../assets/images/default_logo.png" alt="Default Logo" class="company-logo">
                <?php endif; ?>
            </div>

            <label for="company_logo">Upload Logo:</label>
            <input type="file" name="company_logo" accept="image/*">

            <label for="company_name">Company Name:</label>
            <input type="text" name="company_name" value="<?php echo $company['company_name'] ?? ''; ?>" required>

            <label for="company_description">Company Description:</label>
            <textarea name="company_description" rows="5" required><?php echo $company['company_description'] ?? ''; ?></textarea>

            <label for="company_contact">Contact Information:</label>
            <input type="text" name="company_contact" value="<?php echo $company['company_contact'] ?? ''; ?>" required>

            <button type="submit" name="update_profile">Update Profile</button>
        </form>
    </div>
</div>

</body>
</html>
