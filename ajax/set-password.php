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

// to validate inputs
function validateInput($data, $pdo) {
    $errors = [];

    // required fields
    if (empty($data['newPassword'])) {
        $errors[] = "New password is required.";
    } elseif (strlen($data['newPassword']) < 8) {
        $errors[] = "New password must be at least 8 characters long.";
    }

    if (empty($data['confirmPassword'])) {
        $errors[] = "Confirm password is required.";
    }

    if ($data['newPassword'] !== $data['confirmPassword']) {
        $errors[] = "Passwords do not match.";
    }

    // validate pin and token
    if (empty($data['pin']) || empty($data['token'])) {
        $errors[] = "Invalid request.";
    } else {
        $stmt = $pdo->prepare("SELECT email FROM reset_password WHERE pin = :pin AND token = :token");
        $stmt->execute(['pin' => $data['pin'], 'token' => $data['token']]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user === false) {
            $errors[] = "Invalid pin or token.";
        }
    }

    return [$errors, $user['email'] ?? null];
}

// form via post method
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // sanitize input data
    $newPassword = sanitizeInput($_POST['newPassword']);
    $confirmPassword = sanitizeInput($_POST['confirmPassword']);
    $pin = sanitizeInput($_POST['pin']);
    $token = sanitizeInput($_POST['token']);

    // prep input data for validation
    $inputData = [
        'newPassword' => $newPassword,
        'confirmPassword' => $confirmPassword,
        'pin' => $pin,
        'token' => $token,
    ];

    // validate input data
    list($validationErrors, $email) = validateInput($inputData, $pdo);

    if (!empty($validationErrors)) {
        // return if validation errors
        echo json_encode(['errors' => $validationErrors]);
    } else {
        // hash the new password
        $passwordHash = password_hash($newPassword, PASSWORD_BCRYPT);

        // update the user's password in the database
        $stmt = $pdo->prepare("UPDATE users SET password_hash = :password_hash WHERE email = :email");
        $stmt->execute(['password_hash' => $passwordHash, 'email' => $email]);

        // delete the reset request
        $stmt = $pdo->prepare("DELETE FROM reset_password WHERE email = :email");
        $stmt->execute(['email' => $email]);

        // return success indicator
        echo json_encode(['success' => true]);
    }
}
?>