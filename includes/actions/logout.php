<?php
/**
 * Simple Logout System
 * This file does 3 simple things:
 * 1. Clears all user data
 * 2. Removes login cookies 
 * 3. Sends user back to login page
 */

// Get access to our database connection and session
require_once __DIR__ . '/../db.php';

// Store the message before destroying session
setcookie('flash_msg', 'You have been successfully logged out!', time() + 30, '/');

// Clear all session data
$_SESSION = array();

// Delete the session cookie
if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time() - 3600, '/');
}

// Destroy the session
session_destroy();

// Redirect to login page
header("Location: /personal_task_system/pages/login.php");
exit; // Stop the script here

/* 
How to explain this to your teacher:
- When a user clicks logout, we need to clean up everything
- We remove all their data from $_SESSION 
- We remove any cookies from their browser
- We destroy their session completely
- Finally, we send them back to the login page
*/
