<?php
require '../vendor/autoload.php'; //configure vendor classes

use Dotenv\Dotenv;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// loading env file vars
$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

// db config from env vars
$hostname = $_ENV['DB_HOSTNAME'];
$username = $_ENV['DB_USERNAME'];
$password = $_ENV['DB_PASSWORD'];
$database = $_ENV['DB_DATABASE'];

// email config from env vars
$emailHost = $_ENV['EMAIL_HOST'];
$emailPort = $_ENV['EMAIL_PORT'];
$emailUsername = $_ENV['EMAIL_USERNAME'];
$emailPassword = $_ENV['EMAIL_PASSWORD'];

// connect to db using PDO
try {
    $pdo = new PDO("mysql:host=$hostname;dbname=$database", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die(json_encode(['errors' => ["Connection failed: " . $e->getMessage()]]));
}

// to sanitize input
function sanitizeInput($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

// form via post method
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // sanitize input data
    $email = sanitizeInput($_POST['email']);

    // validation errors
    $errors = [];

    if (empty($email)) {
        $errors[] = "Email is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Please provide a valid email address.";
    }

    // check if email exists in the database
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        $errors[] = "No account found with that email address.";
    }

    if (!empty($errors)) {
        echo json_encode(['errors' => $errors]);
        exit;
    }

    // generate pin and token
    $pin = mt_rand(100000, 999999);
    $token = bin2hex(random_bytes(50));

    // insert into reset_password table
    $stmt = $pdo->prepare("INSERT INTO reset_password (email, pin, token) VALUES (:email, :pin, :token)");
    $stmt->execute([
        'email' => $email,
        'pin' => $pin,
        'token' => $token
    ]);

    // send reset email
    $phpmailer = new PHPMailer();
    $phpmailer->isSMTP();
    $phpmailer->Host = $emailHost;
    $phpmailer->SMTPAuth = true;
    $phpmailer->Port = $emailPort;
    $phpmailer->Username = $emailUsername;
    $phpmailer->Password = $emailPassword;

    $phpmailer->setFrom('noreply@yourdomain.com', 'Artist Investigators');
    $phpmailer->addAddress($email);

    $resetLink = 'http://localhost/final-project/set-password.php?pin=' . $pin . '&token=' . $token;
    
    $phpmailer->isHTML(true);
    $phpmailer->Subject = 'Password Reset Request';
    $phpmailer->Body = '
        <html>
        <head>
            <style>
                body, html {
                    display: flex;
                    flex-direction: column;
                    min-height: 100vh;
                    margin: 0;
                    padding: 0;
                    height: 100%;
                    font-family: Arial, sans-serif;
                    background-color: #f8f8f8ff;
                }

                .email-wrapper {
                    width: 100%;
                    max-width: 600px;
                    margin: auto;
                    background-color: #f2f2f2ff;
                    border: 1px solid #7f8c8dff;
                    border-radius: 8px;
                    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                    overflow: hidden;
                }

                header {
                    background-color: #333333ff;
                    color: #f8f8f8ff;
                    padding: 20px;
                    text-align: center;
                }

                .branding {
                    font-size: 24px;
                }

                main {
                    padding: 20px;
                    color: #333333ff;
                }

                h1, h2 {
                    color: #333333ff;
                }

                p {
                    line-height: 1.6;
                }

                footer {
                    background-color: #333333ff;
                    color: #f8f8f8ff;
                    padding: 10px;
                    text-align: center;
                }

                @media (max-width: 768px) {
                    .email-wrapper {
                        width: 100%;
                        padding: 20px;
                    }
                }
            </style>
        </head>
        <body>
            <div class="email-wrapper">
                <header>
                    <div class="branding">Artist Investigators</div>
                </header>
                <main>
                    <h1>Password Reset Request</h1>
                    <p>We received a request to reset your password.</p>
                    <p>Click the link below to reset your password:</p>
                    <p><a href="' . htmlspecialchars($resetLink) . '">Reset Password</a></p>
                    <p>If you did not request a password reset, please ignore this email.</p>
                    <p>Warm regards,<br>The Artist Investigators Team</p>
                </main>
                <footer>
                    <p>&copy; 2024 Artist Investigators. All rights reserved.</p>
                </footer>
            </div>
        </body>
        </html>
    ';
    
    $phpmailer->AltBody = "We received a request to reset your password. Click the link below to reset your password: " . $resetLink . " If you did not request a password reset, please ignore this email. Warm regards, The Artist Investigators Team";

    if (!$phpmailer->send()) {
        echo json_encode(['errors' => ["Mail could not be sent. Mailer Error: " . $phpmailer->ErrorInfo]]);
        exit;
    }

    echo json_encode(['success' => true]);
}
?>