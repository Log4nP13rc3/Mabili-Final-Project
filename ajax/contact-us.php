<?php
// session security
session_start();

// configure vendor classes
require '../vendor/autoload.php'; 

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
    die("Connection failed: " . $e->getMessage());
}

// to sanitize input
function sanitizeInput($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

// to validate inputs/check for errors
function validateInput($data) {
    $errors = [];

    // required fields
    if (empty($data['email'])) {
        $errors[] = "Email is required.";
    } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Please provide a valid email address.";
    }

    if (empty($data['subject'])) {
        $errors[] = "Subject is required.";
    }

    if (empty($data['message'])) {
        $errors[] = "Message is required.";
    }

    return $errors;
}

// function to send emails using PHPMailer
function sendEmail($to, $subject, $message, $emailHost, $emailPort, $emailUsername, $emailPassword, $replyTo = null) {
    $phpmailer = new PHPMailer(true);
    $phpmailer->isSMTP();
    $phpmailer->Host = $emailHost;
    $phpmailer->SMTPAuth = true;
    $phpmailer->Port = $emailPort;
    $phpmailer->Username = $emailUsername;
    $phpmailer->Password = $emailPassword;

    $phpmailer->setFrom('noreply@yourdomain.com', 'Artist Investigators');
    if ($replyTo) {
        $phpmailer->addReplyTo($replyTo);
    }
    $phpmailer->addAddress($to);

    $phpmailer->isHTML(true);
    $phpmailer->Subject = $subject;
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

                .message-wrapper {
                    width: 80%;
                    max-width: 400px;
                    margin: auto;
                    background-color: #f8f8f8ff;
                    border: 1px solid #7f8c8dff;
                    border-radius: 8px;
                    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                    overflow: hidden;
                }

                .message-wrapper p {
                    padding: 10px;
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
                    <h1>Contact Us Form Submission</h1>
                    <p>Thank you for reaching out to us. We will get back to you as soon as possible.</p>
                    <p>This is a copy of the message you sent us:</p>
                        <div class="message-wrapper">
                            <p><strong>Subject:</strong> ' . htmlspecialchars($subject) . '</p>
                            <p><strong>Message:</strong></p>
                            <p>' . nl2br(htmlspecialchars($message)) . '</p>
                        </div>
                    <p>Warm regards,<br>The Artist Investigators Team</p>
                </main>
                <footer>
                    <p>&copy; 2024 Artist Investigators. All rights reserved.</p>
                </footer>
            </div>
        </body>
        </html>
    ';
    
    $phpmailer->AltBody = "Contact Us Form Submission\n\nSubject: $subject\nMessage: $message";

    try {
        $phpmailer->send();
        // Save email content to session for displaying in the popup
        $_SESSION['emailContent'] = $phpmailer->Body;
    } catch (Exception $e) {
        echo json_encode(['error' => 'Message could not be sent. Mailer Error: ' . $phpmailer->ErrorInfo]);
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = sanitizeInput($_POST['email']);
    $subject = sanitizeInput($_POST['subject']);
    $message = sanitizeInput($_POST['message']);

    $errors = validateInput(['email' => $email, 'subject' => $subject, 'message' => $message]);

    if (empty($errors)) {
        // send email
        sendEmail($email, $subject, $message, $emailHost, $emailPort, $emailUsername, $emailPassword);

        echo json_encode(['success' => true]);
    } else {
        // return errors
        echo json_encode(['errors' => $errors]);
    }
}
?>