<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['email'])) {
    header('Location: sign-in.php');
    exit();
}

// Load environment variables
require_once __DIR__ . '/vendor/autoload.php'; // Adjust the path as needed

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

// Get the post_id from the URL
$post_id = $_GET['post_id'] ?? null;
if (!$post_id) {
    die("Post ID is missing.");
}

// Fetch the post details
$query = $db->prepare("SELECT * FROM posts WHERE post_id = :post_id");
$query->execute(['post_id' => $post_id]);
$post = $query->fetch(PDO::FETCH_ASSOC);

if (!$post) {
    die("Post not found.");
}

// Fetch the author's details
$query = $db->prepare("SELECT * FROM users WHERE user_id = :user_id");
$query->execute(['user_id' => $post['user_id']]);
$author = $query->fetch(PDO::FETCH_ASSOC);

if (!$author) {
    die("Author not found.");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Post</title>
    <link rel="icon" href="media/branding/icon.jpeg" type="image/jpeg">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="css/style-post.css">
    <script src="js/jquery-3.7.1.min.js"></script>
    <script src="js/newsletter.js"></script>
    <script src="js/like-handler.js"></script>
    <script src="js/comments-handler.js"></script>
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
        <div class="container">
            <!-- Post Detail View -->
            <section class="top">
                <div class="top-container">
                    <div class="img-container">
                        <img src="uploads/<?php echo htmlspecialchars($post['image_url']); ?>" alt="<?php echo htmlspecialchars($post['title']); ?>">
                    </div>
                    <div class="content-container">
                        <h2><?php echo htmlspecialchars(html_entity_decode($post['title'], ENT_QUOTES, 'UTF-8')); ?></h2>
                        <h5>
                            <?php echo htmlspecialchars(ucwords(str_replace('-', ' ', html_entity_decode($post['media_categories'], ENT_QUOTES, 'UTF-8')))); ?> | 
                            <!--<?php echo htmlspecialchars(ucwords(str_replace('-', ' ', html_entity_decode($post['themes_categories'], ENT_QUOTES, 'UTF-8')))); ?> |-->
                            <?php echo htmlspecialchars(ucwords(str_replace('-', ' ', html_entity_decode($post['art_movements_categories'], ENT_QUOTES, 'UTF-8')))); ?>
                        </h5>
                        <h4>by @<?php echo htmlspecialchars(html_entity_decode($author['username'], ENT_QUOTES, 'UTF-8')); ?></h4>
                        <p><?php echo nl2br(html_entity_decode($post['content'], ENT_QUOTES, 'UTF-8')); ?></p>
                    </div>
                </div>
            </section>
            
            <!-- Likes and Comments -->
            <aside class="btm">
                <div class="btm-container">
                    <div class="likes-container">
                        <h2>Liked this investigation?</h2>
                        <button id="like-btn" class="like-button">
                            <i class="fa-solid fa-heart"></i>
                            <span id="like-count">0</span>
                        </button>
                    </div><br>
                    <div class="comments-container">
                        <h2>Comments</h2>
                        <div id="comments-list">
                            <!-- Comments will be dynamically loaded here -->
                        </div>
                        <div class="comment-form">
                            <input type="text" id="comment-input" placeholder="Add a comment...">
                            <button id="comment-submit">Post</button>
                        </div>
                    </div>
                </div>
            </aside>
        </div>
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