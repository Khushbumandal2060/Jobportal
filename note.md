Job-portal/
│
├── assets/              # Stores all the static assets like images, icons, etc.
│   ├── images/          # Image files (logo, icons, etc.)
│   └── css/             # CSS files
│       └── style.css    # Main stylesheet for the portal
│
├── js/                  # JavaScript files for interactivity
│   ├── script.js        # Main JS file (AJAX, form validation, etc.)
│   └── validation.js    # Client-side form validation
│
├── includes/            # Reusable code snippets (header, footer, DB connection, etc.)
│   ├── db.php           # Database connection file
│   ├── header.php       # Common header (navigation bar, meta tags)
│   ├── footer.php       # Common footer (footer info, scripts)
│   └── functions.php    # Helper functions (validation, password hashing)
│
├── config/              # Configuration files
│   └── config.php       # General settings, paths, and constants
│
├── uploads/             # For storing uploaded files (resumes, company logos, etc.)
│
├── users/               # User-related folders
│   ├── job_seeker/      # Job seeker profile and job-related pages
│   │   ├── dashboard.php    # Dashboard for job seekers
│   │   ├── profile.php      # Job seeker profile page
│   │   └── apply_job.php    # Apply for jobs page
│   └── employer/         # Employer profile and job-related pages
│       ├── dashboard.php    # Dashboard for employers
│       ├── post_job.php     # Page to post a new job
│       ├── manage_jobs.php  # Manage posted jobs page
│       └── company_profile.php # Employer's company profile page
│
├── auth/                 # Authentication related files
│   ├── login.php         # Login page
│   ├── register.php      # User registration page (job seekers & employers)
│   ├── logout.php        # Logout functionality
│   ├── forgot_password.php # Password recovery
│   └── reset_password.php  # Reset password page
│
├── jobs/                 # Job-related functionality
│   ├── job_listings.php  # Job listings page
│   ├── job_details.php   # Job details page (with apply button)
│   ├── search_jobs.php   # Search job page
│   └── category_filter.php # Filter jobs by category
│
├── admin/                # Admin Panel (for managing the portal)
│   ├── index.php         # Admin Dashboard (overview of portal activity)
│   ├── manage_users.php  # Admin manages users (job seekers and employers)
│   ├── manage_jobs.php   # Admin manages all job postings (approve/delete)
│   ├── manage_categories.php  # Admin manages job categories
│   ├── settings.php      # Portal settings (e.g., site details, admin settings)
│   ├── view_job_applications.php  # Admin views all job applications
│   └── login.php         # Admin login page
│
└── index.php             # Main entry point (homepage)



CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    user_type ENUM('job_seeker', 'employer') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


CREATE TABLE `jobs` (
    `id` INT(11) AUTO_INCREMENT PRIMARY KEY,
    `employer_id` INT(11) NOT NULL,  -- Foreign key to users table (employer)
    `title` VARCHAR(255) NOT NULL,
    `description` TEXT NOT NULL,
    `location` VARCHAR(255) NOT NULL,
    `salary` DECIMAL(10, 2) NOT NULL,
    `posted_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (`employer_id`) REFERENCES users(id) ON DELETE CASCADE
);

ALTER TABLE users
ADD COLUMN company_name VARCHAR(255),
ADD COLUMN company_logo VARCHAR(255),
ADD COLUMN company_description TEXT,
ADD COLUMN company_contact VARCHAR(255);

CREATE TABLE company_profiles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    employer_id INT NOT NULL,
    company_name VARCHAR(255),
    company_logo VARCHAR(255),
    company_description TEXT,
    company_contact VARCHAR(255),
    FOREIGN KEY (employer_id) REFERENCES users(id)
);

CREATE TABLE job_applications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    job_id INT NOT NULL,
    applied_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (job_id) REFERENCES jobs(id)
);

CREATE TABLE `applications` (
    `id` INT(11) AUTO_INCREMENT PRIMARY KEY,
    `job_id` INT(11) NOT NULL,  -- Foreign key to jobs table
    `job_seeker_id` INT(11) NOT NULL,  -- Foreign key to users table (job seeker)
    `resume` VARCHAR(255) NOT NULL,
    `cover_letter` TEXT NOT NULL,
    `applied_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (`job_id`) REFERENCES jobs(id) ON DELETE CASCADE,
    FOREIGN KEY (`job_seeker_id`) REFERENCES users(id) ON DELETE CASCADE
);j