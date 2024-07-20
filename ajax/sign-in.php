<?php
require '../vendor/autoload.php'; //configure vendor classes

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
        $stmt = $pdo->prepare("SELECT password_hash FROM users WHERE email = :email");
        $stmt->execute(['email' => $data['email']]);
        $storedPasswordHash = $stmt->fetchColumn();

        if ($storedPasswordHash === false || !password_verify($data['password'], $storedPasswordHash)) {
            $errors[] = "The email address or password is incorrect.";
        }
    }

    return $errors;
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
    $validationErrors = validateInput($inputData, $pdo);

    if (!empty($validationErrors)) {
        // return if validation errors
        echo '<ul class="error-message">';
        foreach ($validationErrors as $error) {
            echo "<li>$error</li>";
        }
        echo "</ul>";
    } else {
        // success
        echo "<p class='success-message'>Sign-In successful!</p>";
    }
}
?>