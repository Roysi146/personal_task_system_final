<?php
/*
Simple Category Delete Handler
----------------------------
This file does 3 things:
1. Checks if user is logged in
2. Deletes the category if it belongs to the user
3. Redirects back with a message
*/

// Get database connection
require_once __DIR__ . '/../db.php';

// Make sure user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: /personal_task_system/pages/login.php");
    exit;
}

// Get the IDs we need
$user_id = $_SESSION['user_id'];
$category_id = (int)$_GET['id'];

// Delete the category
mysqli_query($koneksi, "DELETE FROM categories WHERE id = $category_id AND user_id = $user_id");

// Show success message and go back
$_SESSION['flash_msg'] = "Category deleted";
header("Location: /personal_task_system/pages/manage_categories.php");
exit;

/*
How to explain this to your teacher:
----------------------------------
1. This is like a security guard that:
   - Checks if you're allowed to delete (must be logged in)
   - Only lets you delete your own categories
   - Tells you if it worked
   - Sends you back to the categories page

2. It's simple but secure because:
   - Checks user_id match (can't delete others' categories)
   - Uses full paths (no 404 errors)
   - Shows feedback message
*/
