<?php
session_start();
header('Content-Type: application/json');

$response = array();
$errors = array();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    $errors[] = 'User not logged in.';
}

// Validate the input fields
$title = trim($_POST['title'] ?? '');
$content = trim($_POST['content'] ?? '');
$mediaCategory = $_POST['media_categories'] ?? '';
$themesCategory = $_POST['themes_categories'] ?? '';
$artMovementsCategory = $_POST['art_movements_categories'] ?? '';

// Title validation
if (empty($title)) {
    $errors[] = 'Please provide a title.';
} elseif (strlen($title) > 100) {
    $errors[] = 'Please provide a title that is less than 100 characters.';
} elseif (strlen($title) < 10) {
    $errors[] = 'Please provide a title that is more than 10 characters.';
}

// Content validation
if (empty($content)) {
    $errors[] = 'Please provide content for your investigation.';
} elseif (strlen($content) > 1000) {
    $errors[] = 'The content of your investigation may not be longer than 1000 characters.';
}

// Image validation
$image = $_FILES['image'] ?? null;
$imagePath = null;

if ($image) {
    // Check for specific upload errors
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
            $targetDirectory = __DIR__ . '/../uploads/';
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

// Validate categories
if (empty($mediaCategory) || empty($themesCategory) || empty($artMovementsCategory)) {
    $errors[] = 'One item from each category must be chosen.';
}

// Handle database operations if no errors
if (empty($errors)) {
    require_once '../vendor/autoload.php';
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
    $dotenv->load();

    try {
        // Set up the database connection
        $dsn = "mysql:host={$_ENV['DB_HOSTNAME']};port={$_ENV['DB_PORT']};dbname={$_ENV['DB_DATABASE']};charset=utf8";
        $pdo = new PDO($dsn, $_ENV['DB_USERNAME'], $_ENV['DB_PASSWORD']);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        $errors[] = 'Database connection failed: ' . $e->getMessage();
    }

    if (empty($errors)) {
        try {
            // Prepare and execute the SQL statement to insert the post
            $stmt = $pdo->prepare("INSERT INTO posts (user_id, title, content, image_url, media_categories, themes_categories, art_movements_categories) 
                                   VALUES (:user_id, :title, :content, :image_url, :media_categories, :themes_categories, :art_movements_categories)");
            $stmt->execute([
                ':user_id' => $_SESSION['email'], 
                ':title' => $title,
                ':content' => $content,
                ':image_url' => $imagePath,
                ':media_categories' => $mediaCategory,
                ':themes_categories' => $themesCategory,
                ':art_movements_categories' => $artMovementsCategory
            ]);

            $response['success'] = true;
            $response['message'] = 'Post created successfully!';
        } catch (PDOException $e) {
            $errors[] = 'Failed to create post: ' . $e->getMessage();
        }
    }
}

// Return the response
if (!empty($errors)) {
    $response['success'] = false;
    $response['errors'] = $errors;
}

echo json_encode($response);
?>