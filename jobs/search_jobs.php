<?php
// Include the database connection
include('../includes/db.php');

// Handle search query
$search_query = isset($_GET['search']) ? $_GET['search'] : '';

// Fetch jobs based on the search query
$sql = "SELECT jobs.id, jobs.title, jobs.description, categories.name AS category_name 
        FROM jobs
        INNER JOIN categories ON jobs.category_id = categories.id";

if ($search_query) {
    $sql .= " WHERE jobs.title LIKE ? OR jobs.description LIKE ?";
    $stmt = $conn->prepare($sql);
    $search_term = "%$search_query%";
    $stmt->bind_param("ss", $search_term, $search_term);
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
    <title>Search Jobs</title>
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

        .search-form {
            margin-bottom: 20px;
            text-align: center;
        }

        input[type="text"] {
            padding: 10px;
            font-size: 14px;
            width: 50%;
            margin-right: 10px;
            border-radius: 3px;
            border: 1px solid #ccc;
        }

        button {
            padding: 10px 20px;
            font-size: 14px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
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
        <h1>Search for Jobs</h1>

        <form method="GET" class="search-form">
            <input type="text" name="search" id="search" placeholder="Search by job title or description..." value="<?php echo htmlspecialchars($search_query); ?>">
            <button type="submit">Search</button>
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
                <p>No jobs found for your search query.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
