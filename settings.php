<?php
session_start();

// Load environment variables from .env file
require_once 'vendor/autoload.php';

use Dotenv\Dotenv;

// Initialize dotenv and load the .env file
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$response = ['success' => false, 'message' => ''];

// Establish database connection
$servername = $_ENV['DB_HOSTNAME'];
$username = $_ENV['DB_USERNAME'];
$password = $_ENV['DB_PASSWORD'];
$dbname = $_ENV['DB_DATABASE'];
$conn = new mysqli($servername, $username, $password, $dbname, $_ENV['DB_PORT']);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $errors = [];
    
    // Validate bio length
    $bio = trim($_POST['bio']);
    if (strlen($bio) > 100) {
        $errors[] = 'Bio must not exceed 100 characters.';
    }

    // Image validation
    $image = $_FILES['image'] ?? null;
    $imagePath = null;

    if ($image) {
        if ($image['error'] !== UPLOAD_ERR_OK) {
            switch ($image['error']) {
                case UPLOAD_ERR_INI_SIZE:
                case UPLOAD_ERR_FORM_SIZE:
                    $errors[] = 'File is too large.';
                    break;
                case UPLOAD_ERR_PARTIAL:
                    $errors[] = 'File was only partially uploaded.';
                    break;
                case UPLOAD_ERR_NO_FILE:
                    $errors[] = 'No file was uploaded.';
                    break;
                case UPLOAD_ERR_NO_TMP_DIR:
                    $errors[] = 'Missing a temporary folder.';
                    break;
                case UPLOAD_ERR_CANT_WRITE:
                    $errors[] = 'Failed to write file to disk.';
                    break;
                case UPLOAD_ERR_EXTENSION:
                    $errors[] = 'File upload stopped by extension.';
                    break;
                default:
                    $errors[] = 'Unknown upload error.';
                    break;
            }
        } else {
            // Validate image file type
            $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/gif'];
            $imageMimeType = mime_content_type($image['tmp_name']);

            if (!in_array($imageMimeType, $allowedMimeTypes)) {
                $errors[] = 'Invalid image file type.';
            } else {
                // Generate unique image path and move the uploaded file
                $imagePath = uniqid() . '-' . basename($image['name']);
                $targetDirectory = __DIR__ . '/uploads/';
                if (!is_dir($targetDirectory)) {
                    if (!mkdir($targetDirectory, 0755, true)) {
                        $errors[] = 'Failed to create upload directory.';
                    }
                }
                if (!move_uploaded_file($image['tmp_name'], $targetDirectory . $imagePath)) {
                    $errors[] = 'Failed to move uploaded file.';
                }
            }
        }
    }

    // If no errors, insert or update data in the database
    if (empty($errors)) {
        $email = $_SESSION['email']; // Assuming you store user email in session
        $bioEscaped = $conn->real_escape_string($bio);

        // Check if a settings record already exists for the user
        $sql = "SELECT * FROM settings WHERE email = '$email'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Update existing record
            $sql = "UPDATE settings SET bio = '$bioEscaped', image_url = '$imagePath' WHERE email = '$email'";
        } else {
            // Insert new record
            $sql = "INSERT INTO settings (email, bio, image_url) VALUES ('$email', '$bioEscaped', '$imagePath')";
        }

        if ($conn->query($sql) === TRUE) {
            $response['success'] = true;
            $response['message'] = 'Settings updated successfully.';
        } else {
            $response['message'] = 'Database error: ' . $conn->error;
        }
    } else {
        $response['message'] = implode(' ', $errors);
    }
}

// Close the connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings</title>
    <link rel="icon" href="media/branding/icon.jpeg" type="image/jpeg">
    <link rel="stylesheet" href="css/style.css">
    <script src="js/jquery-3.7.1.min.js"></script>
    
</head>
<body>
    <header>
        <div class="branding">
            <img src="media/branding/icon-dark.jpeg" alt="Icon" class="header-icon">
            <span>ARTIST INVESTIGATORS</span>
        </div>
    </header>
    <main>
        <section class="sign-in-section">
            <div class="sign-in-container">
                <div class="logo-container">
                    <img src="media/branding/logo.jpeg" alt="Artist Investigators Logo" class="logo">
                </div>
                <div class="sign-in-form-container">
                    <h1 class="page-heading">Settings</h1>
                    <form id="settings-form" class="sign-in-form" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="message">Bio</label>
                            <textarea id="bio" name="bio" rows="5" required aria-required="true" placeholder="Add your bio" class="form-control"></textarea>
                        </div>
                        <div class="form-group">
                            <p>Upload an image for your profile:</p>
                            <label for="image"></label>
                            <input type="file" id="image" name="image" accept="image/*" required>
                            <div id="image-preview"></div>
                        </div>
                        <button type="submit" class="btn btn-primary" id="contact-us-button">Apply Changes</button>
                    </form><br>
                    <!-- Display PHP response messages -->
                    <?php if (!empty($response['message'])): ?>
                        <div id="js-message"><?php echo $response['message']; ?></div>
                    <?php endif; ?>
                    <a href="dashboard.php" class="btn btn-link">Back to Dashboard</a>
                </div>
            </div>
        </section>
    </main>
    <footer>
        <p>&copy; 2024 Artist Investigators. All rights reserved.</p>
    </footer>
</body>
</html>