<?php
// Function to check if a user is logged in
function isUserLoggedIn() {
    return isset($_SESSION['user_id']) && isset($_SESSION['role']);
}

// Function to hash passwords
function hashPassword($password) {
    return password_hash($password, PASSWORD_DEFAULT);
}

// Function to verify passwords
function verifyPassword($password, $hashedPassword) {
    return password_verify($password, $hashedPassword);
}

// Function to redirect the user to a specific page
function redirectTo($url) {
    header("Location: " . $url);
    exit;
}

// Function to sanitize user input to prevent XSS
function sanitizeInput($data) {
    return htmlspecialchars(trim($data));
}
