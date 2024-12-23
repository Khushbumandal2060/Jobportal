<?php
// Include necessary PHP files
include('includes/header.php');
include('includes/db.php');
include('includes/functions.php');
include('includes/about_us.php');
?>

<div class="jp-hero-section">
    <div class="jp-hero-content">
        <h2>Welcome to the JobSphere</h2>
        <p>Your dream job is just a few clicks away. Explore job listings, discover companies, and apply for jobs effortlessly.</p>
        <a href="jobs/job_listings.php" class="jp-btn">Browse Jobs</a>
    </div>
    <div class="jp-hero-image">
        <img src="https://img.freepik.com/free-vector/choice-worker-concept-illustrated_52683-44076.jpg?t=st=1733065075~exp=1733068675~hmac=11b2bca07fa5a0bc98ba5d2da16225c3a6131d1799ef37d1ad6c02a7bfe2d27b&w=1380" alt="Hero Image">
    </div>
</div>

<!-- Featured Job Listings Section -->
<section class="jp-featured-jobs">
    <div class="container">
        <h2>Featured Job Listings</h2>
        <div class="jp-job-listings">

            <!-- Job 1 -->
            <div class="jp-job-card">
                <div class="jp-job-image">
                    <img src="assets/images/images (2).jpg" alt="Job Image1">
                </div>
                <h3>- Financial Analyst</h3>
                <p>Company: <span class="jp-company">Info Tech</span></p>
                <p>Location: <span class="jp-location">Lalitpur</span></p>
                <p>Salary: <span class="jp-salary">$50,000 - $70,000/year</span></p>
                <a href="jobs/job_details.php?id=1" class="jp-btn">View Details</a>
            </div>

            <!-- Job 2 -->
            <div class="jp-job-card">
                <div class="jp-job-image">
                    <img src="assets/images/images.jpg" alt="Job Image">
                </div>
                <h3> - Software Engineer</h3>
                <p>Company: <span class="jp-company">ABC Tech</span></p>
                <p>Location: <span class="jp-location">Kathmandu</span></p>
                <p>Salary: <span class="jp-salary">$60,000 - $90,000/year</span></p>
                <a href="jobs/job_details.php?id=2" class="jp-btn">View Details</a>
            </div>

            <!-- Job 3 (New Job) -->
            <div class="jp-job-card">
                <div class="jp-job-image">
                    <img src="assets/images/download.jpg" alt="Job Image">
                </div>
                <h3>- Marketing Manager</h3>
                <p>Company: <span class="jp-company">TechWorld</span></p>
                <p>Location: <span class="jp-location">Pokhara</span></p>
                <p>Salary: <span class="jp-salary">$40,000 - $60,000/year</span></p>
                <a href="jobs/job_details.php?id=3" class="jp-btn">View Details</a>
            </div>
        </div>
    </div>
</section>

<!-- About the Portal Section -->
<section class="jp-about">
    <div class="container">
        <h2>About Our JobSphere</h2>
        <p>Our jobsphere connects employers and job seekers by providing a seamless platform for finding jobs and recruiting talent.</p>
        <p>Whether you're looking for a part-time position, full-time job, or internships, we have a variety of job opportunities listed daily.</p>
    </div>
</section>

<section class="jp-testimonials">
    <div class="container">
        <h2>What Our Users Say</h2>
        <div class="jp-testimonial-cards">
            <div class="jp-testimonial-card">
                <p>"This jobSphere helped me find my dream job. The process was easy, and the job listings were relevant to my skills."</p>
                <h4>-Shushant Shrestha</h4>
            </div>

            <div class="jp-testimonial-card">
                <p>"I found multiple job offers within weeks. Highly recommend it for anyone looking to advance their career!"</p>
                <h4>-Ankit Shah</h4>
            </div>
        </div>
    </div>
</section>

<?php include('includes/footer.php'); ?>
