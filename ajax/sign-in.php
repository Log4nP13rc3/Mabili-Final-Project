<?php
// session security
session_start();

//configure vendor classes
require '../vendor/autoload.php'; 

use Dotenv\Dotenv;

// loading env file vars
$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

// db config from env vars
$hostname = $_ENV['DB_HOSTNAME'];
$username = $_ENV['DB_USERNAME'];
$password = $_ENV['DB_PASSWORD'];
$database = $_ENV['DB_DATABASE'];

// connect to db using PDO
try {
    $pdo = new PDO("mysql:host=$hostname;dbname=$database", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// to sanitize input
function sanitizeInput($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

// to validate inputs/ check for errors
function validateInput($data, $pdo) {
    $errors = [];
    $user = null;

    // required fields
    if (empty($data['email'])) {
        $errors[] = "Email is required.";
    } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Please provide a valid email address.";
    }

    if (empty($data['password'])) {
        $errors[] = "Password is required.";
    }

    // check if email and password match a user in the database
    if (empty($errors)) {
        $stmt = $pdo->prepare("SELECT id, password_hash FROM users WHERE email = :email");
        $stmt->execute(['email' => $data['email']]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user === false || !password_verify($data['password'], $user['password_hash'])) {
            $errors[] = "The email address or password is incorrect.";
            $user = null;
        }
    }

    return [$errors, $user];
}

// form via post method
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // sanitize input data
    $email = sanitizeInput($_POST['email']);
    $password = sanitizeInput($_POST['password']);

    // prep input data for validation
    $inputData = [
        'email' => $email,
        'password' => $password,
    ];

    // validate input data
    list($validationErrors, $user) = validateInput($inputData, $pdo);

    if (!empty($validationErrors)) {
        // return if validation errors
        echo json_encode(['errors' => $validationErrors]);
    } else {
        // on success set the session var + redir to dashboard.html (instead of success msg)
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['email'] = $email;
        echo json_encode(['success' => true, 'redirect' => 'dashboard.html']);
    }
}
?>