<?php
require '../vendor/autoload.php'; 

use Dotenv\Dotenv;
use PDO;

// Loading env file vars
$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

// DB config from env vars
$hostname = $_ENV['DB_HOSTNAME'];
$username = $_ENV['DB_USERNAME'];
$password = $_ENV['DB_PASSWORD'];
$database = $_ENV['DB_DATABASE'];

try {
    // Create a new PDO instance
    $pdo = new PDO("mysql:host=$hostname;dbname=$database", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Prepare and execute the query
    $stmt = $pdo->query("SELECT post_id, title, image_url FROM posts ORDER BY RAND() LIMIT 9");
    $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Return the results as JSON
    echo json_encode($posts);
} catch (PDOException $e) {
    // Handle connection errors
    echo json_encode(['error' => $e->getMessage()]);
}
?>