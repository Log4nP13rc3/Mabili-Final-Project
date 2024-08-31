<?php
session_start();

header('Content-Type: text/html; charset=utf-8');

if (!isset($_SESSION['email'])) {
    echo 'User not logged in.';
    exit();
}

require_once __DIR__ . '/../vendor/autoload.php';
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

try {
    $db = new PDO(
        "mysql:host=" . $_ENV['DB_HOSTNAME'] . ";port=" . $_ENV['DB_PORT'] . ";dbname=" . $_ENV['DB_DATABASE'],
        $_ENV['DB_USERNAME'],
        $_ENV['DB_PASSWORD']
    );
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Database connection failed.';
    exit();
}

$action = $_POST['action'] ?? null;
$post_id = $_POST['post_id'] ?? null;
$content = $_POST['content'] ?? null;
$comment_id = $_POST['comment_id'] ?? null;

// Fetch user_id based on email
$email = $_SESSION['email'];
$query = $db->prepare("SELECT user_id FROM users WHERE email = :email");
$query->execute(['email' => $email]);
$user = $query->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    echo 'User not found.';
    exit();
}

$user_id = $user['user_id'];

if ($action === 'fetch_comments') {
    if (!$post_id) {
        echo 'Post ID is missing.';
        exit();
    }

    // Fetch comments with the current user's ID
    $query = $db->prepare("SELECT comments.*, users.username, :current_user_id as current_user_id 
                            FROM comments 
                            JOIN users ON comments.user_id = users.user_id 
                            WHERE comments.post_id = :post_id 
                            ORDER BY comments.created_at DESC");
    $query->execute(['post_id' => $post_id, 'current_user_id' => $user_id]);
    $comments = $query->fetchAll(PDO::FETCH_ASSOC);

    foreach ($comments as $comment) {
        // Show delete button only if the comment belongs to the current user
        $delete_button = ($comment['user_id'] == $user_id) 
            ? "<button class='delete-comment-btn' data-comment-id='{$comment['comment_id']}'><i class='fa-solid fa-trash-can'></i></button>"
            : "";

        echo "<div class='comment'>
                <strong>{$comment['username']}</strong>: {$comment['content']}
                <br><small>" . date('Y-m-d H:i:s', strtotime($comment['created_at'])) . "</small>
                $delete_button
              </div>";
    }
} elseif ($action === 'post_comment') {
    if (!$post_id || !$content) {
        echo 'Post ID or comment content is missing.';
        exit();
    }

    $query = $db->prepare("INSERT INTO comments (post_id, user_id, content) VALUES (:post_id, :user_id, :content)");
    $result = $query->execute(['post_id' => $post_id, 'user_id' => $user_id, 'content' => $content]);

    if ($result) {
        echo 'Comment posted successfully.';
    } else {
        echo 'Failed to post comment.';
    }
} elseif ($action === 'delete_comment') {
    if (!$comment_id) {
        echo 'Comment ID is missing.';
        exit();
    }

    $query = $db->prepare("DELETE FROM comments WHERE comment_id = :comment_id AND user_id = :user_id");
    $result = $query->execute(['comment_id' => $comment_id, 'user_id' => $user_id]);

    if ($result) {
        echo 'Comment deleted successfully.';
    } else {
        echo 'Failed to delete comment.';
    }
} else {
    echo 'Invalid action.';
}
?>