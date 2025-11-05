<?php
// Include database connection
require_once __DIR__ . '/../includes/db.php';

// Check if user is logged in, if not redirect to login page
if (!isset($_SESSION['user_id'])) {
    header("Location: /personal_task_system/pages/login.php");
    exit;
}

// Store user ID for later use
$userId = $_SESSION['user_id'];

// Get all tasks for this user with their category and priority
$query = "SELECT t.*, 
          c.name as category_name,
          p.name as priority_name
          FROM tasks t
          LEFT JOIN categories c ON t.category_id = c.id
          LEFT JOIN priorities p ON t.priority_id = p.id
          WHERE t.user_id = $userId
          ORDER BY t.created_at DESC";

$taskList = mysqli_query($koneksi, $query);

// Set page title and include header
$pageTitle = "My Tasks";
require_once __DIR__ . '/../includes/header.php';
?>

<!-- Show success message if there is one -->
<?php if (isset($_SESSION['flash_msg'])): ?>
    <div class="alert alert-success">
        <?= htmlspecialchars($_SESSION['flash_msg']) ?>
    </div>
    <?php unset($_SESSION['flash_msg']); ?>
<?php endif; ?>

<!-- Page header with title and Add button -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3">My Tasks</h1>
    <a href="add_task.php" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i> New Task
    </a>
</div>

<!-- Tasks table -->
<div class="card">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Category</th>
                    <th>Priority</th>
                    <th>Status</th>
                    <th width="200">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!$taskList || mysqli_num_rows($taskList) == 0): ?>
                    <tr>
                        <td colspan="5" class="text-center text-muted py-3">
                            No tasks found
                        </td>
                    </tr>
                <?php else: while($task = mysqli_fetch_assoc($taskList)): ?>
                    <tr>
                        <td><?= htmlspecialchars($task['title']) ?></td>
                        <td><?= htmlspecialchars($task['category_name'] ?? 'None') ?></td>
                        <td><?= htmlspecialchars($task['priority_name'] ?? 'None') ?></td>
                        <td>
                            <span class="badge bg-<?= $task['status'] === 'done' ? 'success' : 'secondary' ?>">
                                <?= $task['status'] === 'done' ? 'Completed' : 'Pending' ?>
                            </span>
                        </td>
                        <td>
                            <!-- Action buttons -->
                            <a href="edit_task.php?id=<?= $task['id'] ?>" 
                               class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-pencil"></i> Edit
                            </a>
                            <a href="notes.php?task_id=<?= $task['id'] ?>" 
                               class="btn btn-sm btn-outline-info">
                                <i class="bi bi-journal-text"></i> Notes
                            </a>
                            <a href="../includes/actions/delete_task.php?id=<?= $task['id'] ?>" 
                               class="btn btn-sm btn-outline-danger"
                               onclick="return confirm('Delete this task?')">
                                <i class="bi bi-trash"></i>
                            </a>
                        </td>
                    </tr>
                <?php endwhile; endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
