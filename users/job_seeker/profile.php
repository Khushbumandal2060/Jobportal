<?php
// Include necessary files
require_once '../../includes/db.php'; // Database connection
require_once '../../includes/functions.php'; // Helper functions

// Initialize variables
$error = '';
$success = '';

// Simulating logged-in user ID for demo purposes
$job_seeker_id = 1; // Replace this with session-based user ID

// Fetch user data
$stmt = $conn->prepare("SELECT name, email, skills, resume FROM job_seekers WHERE id = ?");
$stmt->bind_param("i", $job_seeker_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_profile'])) {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $skills = trim($_POST['skills']);
    $resume = '';

    // Validate inputs
    if (empty($name) || empty($email)) {
        $error = "Name and email are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format.";
    } else {
        // Handle file upload
        if (!empty($_FILES['resume']['name'])) {
            $targetDir = "../../uploads/resumes/";
            $resume = basename($_FILES['resume']['name']);
            $targetFilePath = $targetDir . $resume;

            // Check file type
            $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
            if (!in_array($fileType, ['pdf', 'doc', 'docx'])) {
                $error = "Only PDF, DOC, or DOCX files are allowed for resumes.";
            } elseif (!move_uploaded_file($_FILES['resume']['tmp_name'], $targetFilePath)) {
                $error = "Error uploading your resume.";
            }
        }

        if (empty($error)) {
            // Update user data
            $stmt = $conn->prepare("UPDATE job_seekers SET name = ?, email = ?, skills = ?, resume = ? WHERE id = ?");
            $resumeField = $resume ? $resume : $user['resume']; // Keep old resume if not uploading a new one
            $stmt->bind_param("ssssi", $name, $email, $skills, $resumeField, $job_seeker_id);

            if ($stmt->execute()) {
                $success = "Profile updated successfully.";
                // Refresh user data
                $user['name'] = $name;
                $user['email'] = $email;
                $user['skills'] = $skills;
                $user['resume'] = $resumeField;
            } else {
                $error = "Error updating profile. Please try again.";
            }
            $stmt->close();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Seeker Profile</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
        }
        .container {
            max-width: 600px;
            margin: 50px auto;
            background: #ffffff;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        h2 {
            text-align: center;
            color: #333;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            font-weight: bold;
            color: #555;
            display: block;
            margin-bottom: 5px;
        }
        input, textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
        textarea {
            resize: none;
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
        .error {
            background: #f8d7da;
            color: #721c24;
            padding: 10px;
            border: 1px solid #f5c6cb;
            border-radius: 5px;
            margin-bottom: 15px;
        }
        .success {
            background: #d4edda;
            color: #155724;
            padding: 10px;
            border: 1px solid #c3e6cb;
            border-radius: 5px;
            margin-bottom: 15px;
        }
        a {
            color: #007bff;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>My Profile</h2>

        <?php if (!empty($error)): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <?php if (!empty($success)): ?>
            <div class="success"><?php echo $success; ?></div>
        <?php endif; ?>

        <form id="profileForm" action="" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="name">Full Name</label>
                <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
            </div>
            <div class="form-group">
                <label for="skills">Skills (comma-separated)</label>
                <textarea id="skills" name="skills" rows="4"><?php echo htmlspecialchars($user['skills']); ?></textarea>
            </div>
            <div class="form-group">
                <label for="resume">Upload Resume</label>
                <input type="file" id="resume" name="resume" accept=".pdf, .doc, .docx">
                <?php if (!empty($user['resume'])): ?>
                    <p>Current Resume: <a href="../../uploads/resumes/<?php echo htmlspecialchars($user['resume']); ?>" target="_blank">View</a></p>
                <?php endif; ?>
            </div>
            <button type="submit" name="update_profile">Update Profile</button>
        </form>
    </div>
</body>
</html>
