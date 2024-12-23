<?php
// Include database connection
include('../includes/db.php');

// Fetch all job categories from the database
$categories = $conn->query("SELECT * FROM categories");

// Handle category filter
$selected_category = isset($_GET['category']) ? $_GET['category'] : '';

// Fetch jobs based on selected category
$sql = "SELECT jobs.id, jobs.title, jobs.description, categories.name AS category_name 
        FROM jobs
        INNER JOIN categories ON jobs.category_id = categories.id";

if ($selected_category) {
    $sql .= " WHERE categories.id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $selected_category);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $result = $conn->query($sql);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Filter Jobs by Category</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 80%;
            margin: 20px auto;
            padding: 20px;
            background: #fff;
            border: 1px solid #ccc;
            box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
        }

        h1 {
            text-align: center;
            font-size: 24px;
            color: #444;
            margin-bottom: 20px;
        }

        .filter-form {
            margin-bottom: 20px;
        }

        select {
            padding: 10px;
            font-size: 14px;
            margin-right: 10px;
            border-radius: 3px;
            border: 1px solid #ccc;
        }

        .job-listings {
            margin-top: 20px;
        }

        .job-listing {
            border-bottom: 1px solid #ccc;
            padding: 10px 0;
        }

        .job-listing h2 {
            font-size: 20px;
            color: #333;
        }

        .job-listing p {
            font-size: 16px;
            color: #555;
        }

        .job-listing .category {
            color: #007BFF;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Filter Jobs by Category</h1>

        <form method="GET" class="filter-form">
            <label for="category">Select Category:</label>
            <select name="category" id="category">
                <option value="">-- All Categories --</option>
                <?php while ($category = $categories->fetch_assoc()): ?>
                    <option value="<?php echo $category['id']; ?>" <?php echo ($category['id'] == $selected_category) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($category['name']); ?>
                    </option>
                <?php endwhile; ?>
            </select>
            <button type="submit">Filter</button>
        </form>

        <div class="job-listings">
            <?php if ($result->num_rows > 0): ?>
                <?php while ($job = $result->fetch_assoc()): ?>
                    <div class="job-listing">
                        <h2><?php echo htmlspecialchars($job['title']); ?></h2>
                        <p><?php echo htmlspecialchars(substr($job['description'], 0, 150)) . '...'; ?></p>
                        <p><span class="category"><?php echo htmlspecialchars($job['category_name']); ?></span></p>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>No jobs found for this category.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
