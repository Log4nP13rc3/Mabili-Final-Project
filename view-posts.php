<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['email'])) {
    header('Location: sign-in.php');
    exit();
}

// Load environment variables
require_once __DIR__ . '/vendor/autoload.php'; 

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Database connection
try {
    $db = new PDO(
        "mysql:host=" . $_ENV['DB_HOSTNAME'] . ";port=" . $_ENV['DB_PORT'] . ";dbname=" . $_ENV['DB_DATABASE'],
        $_ENV['DB_USERNAME'],
        $_ENV['DB_PASSWORD']
    );
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Fetch user email from the session
$user_email = $_SESSION['email'];

// Query 1: Fetch username
$sql_username = "SELECT username FROM users WHERE email = ?";
$stmt_username = $db->prepare($sql_username);
$stmt_username->execute([$user_email]);
$username = $stmt_username->fetchColumn();

// Query 2: // Fetch bio and profile picture
$sql_settings = "SELECT bio, image_url FROM settings WHERE email = ?";
$stmt_settings = $db->prepare($sql_settings);
$stmt_settings->execute([$user_email]);
$settings = $stmt_settings->fetch(PDO::FETCH_ASSOC);

// Check if the settings are valid
if ($settings === false) {
    // Handle the case where no settings were found or query failed
    $bio = 'bio';
    $image_url = "https://placehold.co/600x400?text=User+Profile+Picture";
} else {
    // Use settings if available
    $bio = !empty($settings['bio']) ? $settings['bio'] : 'bio';
    $image_url = !empty($settings['image_url']) ? 'uploads/' . $settings['image_url'] : "https://placehold.co/600x400?text=User+Profile+Picture";
}

// Query 3: Fetch post count
$sql_posts = "SELECT COUNT(*) as post_count FROM posts WHERE user_id = ?";
$stmt_posts = $db->prepare($sql_posts);
$stmt_posts->execute([$user_email]);
$post_count = $stmt_posts->fetchColumn();

// Query 4: Fetch total like count
$sql_likes = "SELECT COUNT(like_id) as like_count 
              FROM likes l 
              JOIN posts p ON l.post_id = p.post_id 
              WHERE p.user_id = ?";
$stmt_likes = $db->prepare($sql_likes);
$stmt_likes->execute([$user_email]);
$like_count = $stmt_likes->fetchColumn();

// Default values for bio and image_url
$bio = !empty($settings['bio']) ? $settings['bio'] : 'bio';
$image_url = !empty($settings['image_url']) ? 'uploads/' . $settings['image_url'] : "https://placehold.co/600x400?text=User+Profile+Picture";

// Fetch user posts
$query = $db->prepare("SELECT * FROM posts WHERE user_id = :user_id ORDER BY created_at DESC LIMIT 9");
$query->execute(['user_id' => $user_email]);
$posts = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Posts</title>
    <link rel="icon" href="media/branding/icon.jpeg" type="image/jpeg">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> <!-- FontAwesome Icons-->
    <link rel="stylesheet" href="css/style-post.css">
    <script src="js/jquery-3.7.1.min.js"></script>
    <script src="js/dashboard.js"></script>
    <script src="js/newsletter.js"></script>
    <script src="js/delete-post.js"></script>
</head>
<body>
    <!-- Header Section -->
    <header>
        <img src="media/branding/logo-dark.jpeg" alt="Artist Investigators Logo" class="header-logo">
        <div class="header-right">
            <!-- Removing due to change of concept, keeping as I might add it back in future.
            <div class="search-container">
                <input type="text" id="search-bar" placeholder="Investigate...">
                <button type="submit">Search</button>
            </div>-->
            <nav>
                <a href="about-us.php" target="_blank" class="about">About Us</a>
                <a href="contact-us.php" target="_blank" class="contact">Contact Us</a>
                <a href="sign-out.php" class="signout">Sign Out</a>
            </nav>
        </div>
    </header>
<main>
    <!-- User Posts -->
    <section id="left">
        <h2>Your Posts</h2>
        <div class="activity-feed">
            <?php if (count($posts) > 0): ?>
                <?php foreach ($posts as $post): ?>
                    <div class="tile">
                        <a href="post-detail-view.php?post_id=<?php echo htmlspecialchars($post['post_id']); ?>">
                            <img src="uploads/<?php echo htmlspecialchars($post['image_url']); ?>" alt="<?php echo htmlspecialchars($post['title']); ?>">
                            <h3><?php echo html_entity_decode(htmlspecialchars($post['title'])); ?></h3>
                        </a>
                        <button class="delete-post" data-post-id="<?php echo htmlspecialchars($post['post_id']); ?>">
                            <i class="fa-solid fa-trash-can"></i>
                        </button>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>You haven't posted anything yet.</p>
            <?php endif; ?>
        </div>
    </section>

    <!-- Right Section: User Profile -->
    <aside id="right">
        <div class="profile">
            <h2>@<?php echo htmlspecialchars($username); ?></h2>
            <img src="<?php echo htmlspecialchars($image_url); ?>" alt="Profile Picture" class="profile-pic">
            <p><i><?php echo htmlspecialchars($bio); ?></i></p>
            <p>Posts: <?php echo htmlspecialchars($post_count); ?></p>
            <p>Likes: <?php echo htmlspecialchars($like_count); ?></p>
            <div class="quick-links">
                <a href="create-post.php" class="button">Create Post</a>
                <a href="settings.php" class="button">Settings</a>
                <a href="dashboard.php" class="button">Back to Dashboard</a>
            </div>
        </div>
    </aside>
</main>

<!-- Footer Section -->
    <footer>
        <div>
            <form id="newsletter-form"> 
                <h3>Newsletters</h3>
                <p>Subscribe to our monthly newsletter!</p>
                <input type="email" id="email" name="email" placeholder="Enter your email address" required>
                <button type="submit">Subscribe</button>
                <p>By providing your information, you agree to our Terms of Use and Privacy Policy.</p>
                <div id="newsletter-message"></div>
            </form>
        </div>
        <div>
            <h3>Legal</h3>
            <ul>
                <li><a href="terms-conditions.php" target="_blank">Terms and Conditions</a></li>
                <li><a href="privacy-policy.php" target="_blank">Privacy Policy</a></li>
                <p>&copy; 2024 Artist Investigators. <br>All rights reserved.</p>
            </ul>
        </div>
        <div>
            <h3>Follow Us</h3>
            <a href="https://web.facebook.com/" target="_blank" class="social-media-link"><i class="fa-brands fa-facebook" style="color: #ff6f61;"></i>Facebook</a>
            <a href="https://www.instagram.com/" target="_blank" class="social-media-link"><i class="fa-brands fa-instagram" style="color: #ff6f61;"></i>Instagram</a>
            <a href="https://www.tiktok.com/" target="_blank" class="social-media-link"><i class="fa-brands fa-tiktok" style="color: #ff6f61;"></i>TikTok</a>
            <a href="https://www.youtube.com/" target="_blank" class="social-media-link"><i class="fa-brands fa-youtube" style="color: #ff6f61;"></i>YouTube</a>
        </div>
    </footer>
</body>
</html>