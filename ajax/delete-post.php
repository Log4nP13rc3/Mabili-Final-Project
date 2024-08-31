<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['email'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in.']);
    exit();
}

// Load environment variables
require_once __DIR__ . '/../vendor/autoload.php'; 

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

// Database connection
try {
    $db = new PDO(
        "mysql:host=" . $_ENV['DB_HOSTNAME'] . ";port=" . $_ENV['DB_PORT'] . ";dbname=" . $_ENV['DB_DATABASE'],
        $_ENV['DB_USERNAME'],
        $_ENV['DB_PASSWORD']
    );
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Database connection failed.']);
    exit();
}

// Check if post_id is set
if (!isset($_POST['post_id']) || !is_numeric($_POST['post_id'])) {
    echo json_encode(['success' => false, 'message' => 'Invalid post ID.']);
    exit();
}

$post_id = intval($_POST['post_id']);

// Fetch user ID from the session
$user_id = $_SESSION['email'];

// Delete the post
$sql_delete_post = "DELETE FROM posts WHERE post_id = ? AND user_id = ?";
$stmt_delete_post = $db->prepare($sql_delete_post);
$result = $stmt_delete_post->execute([$post_id, $user_id]);

if ($result) {
    echo json_encode(['success' => true, 'message' => 'Post deleted successfully.']);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to delete post.']);
}
?>