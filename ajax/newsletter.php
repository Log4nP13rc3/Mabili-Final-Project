<?php
require '../vendor/autoload.php'; // Configure vendor classes

use Dotenv\Dotenv;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Load environment variables
$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

// DB and email config from env vars
$hostname = $_ENV['DB_HOSTNAME'];
$username = $_ENV['DB_USERNAME'];
$password = $_ENV['DB_PASSWORD'];
$database = $_ENV['DB_DATABASE'];

$emailHost = $_ENV['EMAIL_HOST'];
$emailPort = $_ENV['EMAIL_PORT'];
$emailUsername = $_ENV['EMAIL_USERNAME'];
$emailPassword = $_ENV['EMAIL_PASSWORD'];

// Connect to DB using PDO
try {
    $pdo = new PDO("mysql:host=$hostname;dbname=$database", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Sanitize input
function sanitizeInput($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

// Validate email and check if it is already subscribed
function validateEmail($email, $pdo) {
    $errors = [];

    if (empty($email)) {
        $errors[] = "Email is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Please provide a valid email address.";
    }

    $stmt = $pdo->prepare("SELECT COUNT(*) FROM newsletters WHERE email = :email");
    $stmt->execute(['email' => $email]);
    if ($stmt->fetchColumn() > 0) {
        $errors[] = "Looks like you've already signed up for our newsletter.";
    }

    return $errors;
}

// Function to send confirmation email using PHPMailer
function sendConfirmationEmail($email, $emailHost, $emailPort, $emailUsername, $emailPassword) {
    $phpmailer = new PHPMailer();
    $phpmailer->isSMTP();
    $phpmailer->Host = $emailHost;
    $phpmailer->SMTPAuth = true;
    $phpmailer->Port = $emailPort;
    $phpmailer->Username = $emailUsername;
    $phpmailer->Password = $emailPassword;

    $phpmailer->setFrom('noreply@yourdomain.com', 'Artist Investigators');
    $phpmailer->addAddress($email);

    $phpmailer->isHTML(true);
    $phpmailer->Subject = 'Newsletter Subscription Confirmation';
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
                    <h1>Thank you for subscribing to our newsletter!</h1>
                    <p>You will start receiving our monthly updates soon.</p>
                    <p>Warm regards,<br>The Artist Investigators Team</p>
                </main>
                <footer>
                    <p>&copy; 2024 Artist Investigators. All rights reserved.</p>
                </footer>
            </div>
        </body>
        </html>
    ';
    
    $phpmailer->AltBody = "Thank you for subscribing to our newsletter!\n\nYou will start receiving our monthly updates soon.";

    try {
        $phpmailer->send();
    } catch (Exception $e) {
        echo "Email could not be sent. Mailer Error: {$phpmailer->ErrorInfo}";
    }
}

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = sanitizeInput($_POST['email']);

    // Validate email
    $validationErrors = validateEmail($email, $pdo);

    if (!empty($validationErrors)) {
        // Return validation errors
        echo '<style>
            .error-message {
                color: #FF7F50;
                font-weight: bold;
            }
        </style>';
        echo "<div class='error-message'>";
        foreach ($validationErrors as $error) {
            echo "<p>$error</p>";
        }
        echo "</div>";
    } else {
        // Insert email into DB
        $stmt = $pdo->prepare("INSERT INTO newsletters (email) VALUES (:email)");
        $stmt->execute(['email' => $email]);

        // Send confirmation email
        sendConfirmationEmail($email, $emailHost, $emailPort, $emailUsername, $emailPassword);

        echo "<div class='success-message' style='color: green; font-weight: bold;'><p>Subscription successful! Please check your email.</p></div>";
    }
}
?>