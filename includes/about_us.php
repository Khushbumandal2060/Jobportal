<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .about-us {
            padding: 20px;
        }
        .hero {
            text-align: center;
            background-color: #f4f4f4;
            padding: 40px;
            margin-bottom: 20px;
        }
        .team-members {
            display: flex;
            gap: 15px;
        }
        .team-member {
            text-align: center;
            padding: 10px;
            border: 1px solid #ccc;
        }
        .team-member img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
        }
    </style>
</head>
<body>

<header>
    <nav>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="about_us.php">About Us</a></li>
            <li><a href="jobs/job_listings.php">Jobs</a></li>
        </ul>
    </nav>
</header>

<main class="about-us">
    <?php
    $conn = new mysqli('localhost', 'root', '', 'job_portal');

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $query = "SELECT * FROM about_us LIMIT 1";
    $result = $conn->query($query);
    $about = $result->fetch_assoc();
    ?>

    <section class="hero">
        <h1>About Us</h1>
        <p><?php echo $about['hero_description']; ?></p>
    </section>

    <section class="our-mission">
        <h2>Our Mission</h2>
        <p><?php echo $about['mission']; ?></p>
    </section>

    <section class="our-vision">
        <h2>Our Vision</h2>
        <p><?php echo $about['vision']; ?></p>
    </section>

    <section class="team">
        <h2>Meet Our Team</h2>
        <div class="team-members">
            <?php
            $teamQuery = "SELECT * FROM team";
            $teamResult = $conn->query($teamQuery);
            while ($teamMember = $teamResult->fetch_assoc()) {
                echo "<div class='team-member'>";
                echo "<img src='uploads/" . $teamMember['photo'] . "' alt='" . $teamMember['name'] . "'>";
                echo "<h3>" . $teamMember['name'] . "</h3>";
                echo "<p>" . $teamMember['role'] . "</p>";
                echo "</div>";
            }
            ?>
        </div>
    </section>
</main>

<footer>
    <p>&copy; 2024 Job Portal. All Rights Reserved.</p>
</footer>

<script>
    console.log("About Us page loaded.");
</script>

</body>
</html>


