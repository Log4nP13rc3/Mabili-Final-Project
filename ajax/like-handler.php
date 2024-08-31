<?php
session_start();

header('Content-Type: application/json; charset=utf-8');

if (!isset($_SESSION['email'])) {
    echo json_encode(['status' => 'error', 'message' => 'User not logged in.']);
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
    echo json_encode(['status' => 'error', 'message' => 'Database connection failed.']);
    exit();
}

$action = $_POST['action'] ?? null;
$post_id = $_POST['post_id'] ?? null;
$email = $_SESSION['email'];

if ($action === 'toggle_like') {
    if (!$post_id) {
        echo json_encode(['status' => 'error', 'message' => 'Post ID is missing.']);
        exit();
    }

    $query = $db->prepare("SELECT user_id FROM users WHERE email = :email");
    $query->execute(['email' => $email]);
    $user = $query->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        echo json_encode(['status' => 'error', 'message' => 'User not found.']);
        exit();
    }
    
    $user_id = $user['user_id'];

    $query = $db->prepare("SELECT * FROM likes WHERE post_id = :post_id AND user_id = :user_id");
    $query->execute(['post_id' => $post_id, 'user_id' => $user_id]);
    $like = $query->fetch(PDO::FETCH_ASSOC);

    if ($like) {
        $query = $db->prepare("DELETE FROM likes WHERE post_id = :post_id AND user_id = :user_id");
        $result = $query->execute(['post_id' => $post_id, 'user_id' => $user_id]);
        $liked = false;
    } else {
        $query = $db->prepare("INSERT INTO likes (post_id, user_id) VALUES (:post_id, :user_id)");
        $result = $query->execute(['post_id' => $post_id, 'user_id' => $user_id]);
        $liked = true;
    }

    if ($result) {
        $query = $db->prepare("SELECT COUNT(*) AS like_count FROM likes WHERE post_id = :post_id");
        $query->execute(['post_id' => $post_id]);
        $like_count = $query->fetch(PDO::FETCH_ASSOC)['like_count'];

        echo json_encode(['status' => 'success', 'like_count' => $like_count, 'liked' => $liked]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to update like.']);
    }
} elseif ($action === 'fetch_likes') {
    if (!$post_id) {
        echo json_encode(['status' => 'error', 'message' => 'Post ID is missing.']);
        exit();
    }

    $query = $db->prepare("SELECT user_id FROM users WHERE email = :email");
    $query->execute(['email' => $email]);
    $user = $query->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        echo json_encode(['status' => 'error', 'message' => 'User not found.']);
        exit();
    }
    
    $user_id = $user['user_id'];

    $query = $db->prepare("SELECT COUNT(*) AS like_count FROM likes WHERE post_id = :post_id");
    $query->execute(['post_id' => $post_id]);
    $like_count = $query->fetch(PDO::FETCH_ASSOC)['like_count'];

    $query = $db->prepare("SELECT * FROM likes WHERE post_id = :post_id AND user_id = :user_id");
    $query->execute(['post_id' => $post_id, 'user_id' => $user_id]);
    $liked = $query->fetch(PDO::FETCH_ASSOC) ? true : false;

    echo json_encode(['status' => 'success', 'like_count' => $like_count, 'liked' => $liked]);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid action.']);
}
?>