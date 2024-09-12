<?php
session_start();
require_once 'vendor/autoload.php';

use Dotenv\Dotenv;

// Load environment variables from .env file
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Establish a database connection
$servername = $_ENV['DB_HOSTNAME'];
$username = $_ENV['DB_USERNAME'];
$password = $_ENV['DB_PASSWORD'];
$dbname = $_ENV['DB_DATABASE'];

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname, $_ENV['DB_PORT']);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch user email from the session
$user_email = $_SESSION['email'];

// Query 1: Fetch username
$sql_username = "SELECT username FROM users WHERE email = ?";
$stmt_username = $conn->prepare($sql_username);
$stmt_username->bind_param("s", $user_email);
$stmt_username->execute();
$stmt_username->bind_result($username);
$stmt_username->fetch();
$stmt_username->close();

// Query 2: Fetch bio and profile picture
$sql_settings = "SELECT bio, image_url FROM settings WHERE email = ?";
$stmt_settings = $conn->prepare($sql_settings);
$stmt_settings->bind_param("s", $user_email);
$stmt_settings->execute();
$stmt_settings->bind_result($bio, $image_url);
$stmt_settings->fetch();
$stmt_settings->close();

// Default values if not set
$bio = !empty($bio) ? $bio : 'bio';
$image_url = !empty($image_url) ? 'uploads/' . $image_url : "https://placehold.co/600x400?text=User+Profile+Picture";

// Query 3: Fetch post count
$sql_posts = "SELECT COUNT(*) as post_count FROM posts WHERE user_id = ?";
$stmt_posts = $conn->prepare($sql_posts);
$stmt_posts->bind_param("s", $user_email);
$stmt_posts->execute();
$stmt_posts->bind_result($post_count);
$stmt_posts->fetch();
$stmt_posts->close();

// Query 4: Fetch total like count
$sql_likes = "SELECT COUNT(like_id) as like_count 
              FROM likes l 
              JOIN posts p ON l.post_id = p.post_id 
              WHERE p.user_id = ?";
$stmt_likes = $conn->prepare($sql_likes);
$stmt_likes->bind_param("s", $user_email);
$stmt_likes->execute();
$stmt_likes->bind_result($like_count);
$stmt_likes->fetch();
$stmt_likes->close();

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Artist Investigators Dashboard</title>
    <link rel="icon" href="media/branding/icon.jpeg" type="image/jpeg">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> <!-- FontAwesome Icons-->
    <link rel="stylesheet" href="css/style-content.css">
    <script src="js/jquery-3.7.1.min.js"></script>
    <script src="js/dashboard.js"></script>
    <script src="js/newsletter.js"></script>
    <script src="js/investigations.js"></script>
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

    <!-- Main Content Section -->
    <main>
            <!-- Left Section: Library -->
            <aside id="left">
                <h2>Art Library</h2>
                <div class="dropdown">
                    <button type="button" onclick="toggleList('media')">Media</button>
                    <ul id="media-list" class="dropdown-list">
                        <li><a href="medium/acrylic-paint.php">Acrylic Paint</a></li>
                        <li><a href="medium/oil-paint.php">Oil Paint</a></li>
                        <li><a href="medium/watercolor-paint.php">Watercolor Paint</a></li>
                        <li><a href="medium/gouache.php">Gouache</a></li>
                        <li><a href="medium/ink.php">Ink</a></li>
                        <li><a href="medium/charcoal.php">Charcoal</a></li>
                        <li><a href="medium/graphite.php">Graphite</a></li>
                        <li><a href="medium/pastel.php">Pastel</a></li>
                        <li><a href="medium/polymer-clay.php">Polymer Clay</a></li>
                        <li><a href="medium/mixed-media.php">Mixed Media</a></li>
                        <li><a href="medium/digital-art.php">Digital Art</a></li>
                        <li><a href="medium/collage.php">Collage</a></li>
                        <li><a href="medium/sculpture.php">Sculpture</a></li>
                        <li><a href="medium/ceramics.php">Ceramics</a></li>
                        <li><a href="medium/photography.php">Photography</a></li>
                        <li><a href="medium/printmaking.php">Printmaking</a></li>
                        <li><a href="medium/textiles.php">Textiles</a></li>
                    </ul>
                </div>
                <!--<div class="dropdown"> Removing due to change of concept, keeping as I might add it back in future.
                    <button type="button" onclick="toggleList('themes')">Themes</button>
                    <ul id="themes-list" class="dropdown-list">
                        <li><a href="#">Nature</a></li>
                        <li><a href="#">Identity</a></li>
                        <li><a href="#">Power and Politics</a></li>
                        <li><a href="#">War and Conflict</a></li>
                        <li><a href="#">Love and Relationships</a></li>
                        <li><a href="#">Mythology and Religion</a></li>
                        <li><a href="#">Urban Life</a></li>
                        <li><a href="#">Social Issues</a></li>
                        <li><a href="#">Dreams and Fantasy</a></li>
                        <li><a href="#">History and Memory</a></li>
                        <li><a href="#">Technology and Innovation</a></li>
                        <li><a href="#">Environment and Sustainability</a></li>
                    </ul>
                </div>-->
                <div class="dropdown">
                    <button type="button" onclick="toggleList('art-movements')">Art Movements</button>
                    <ul id="art-movements-list" class="dropdown-list">
                        <li><a href="art-movements/renaissance.php">Renaissance</a></li>
                        <li><a href="art-movements/baroque.php">Baroque</a></li>
                        <li><a href="art-movements/rococo.php">Rococo</a></li>
                        <li><a href="art-movements/neoclassicism.php">Neoclassicism</a></li>
                        <li><a href="art-movements/romanticism.php">Romanticism</a></li>
                        <li><a href="art-movements/realism.php">Realism</a></li>
                        <li><a href="art-movements/impressionism.php">Impressionism</a></li>
                        <li><a href="art-movements/post-impressionism.php">Post-Impressionism</a></li>
                        <li><a href="art-movements/symbolism.php">Symbolism</a></li>
                        <li><a href="art-movements/art-nouveau.php">Art Nouveau</a></li>
                        <li><a href="art-movements/fauvism.php">Fauvism</a></li>
                        <li><a href="art-movements/expressionism.php">Expressionism</a></li>
                        <li><a href="art-movements/cubism.php">Cubism</a></li>
                        <li><a href="art-movements/futurism.php">Futurism</a></li>
                        <li><a href="art-movements/dada.php">Dada</a></li>
                        <li><a href="art-movements/surrealism.php">Surrealism</a></li>
                        <li><a href="art-movements/abstract-expressionism.php">Abstract Expressionism</a></li>
                        <li><a href="art-movements/pop-art.php">Pop Art</a></li>
                        <li><a href="art-movements/minimalism.php">Minimalism</a></li>
                        <li><a href="art-movements/conceptual-art.php">Conceptual Art</a></li>
                        <li><a href="art-movements/op-art.php">Op Art</a></li>
                        <li><a href="art-movements/photorealism.php">Photorealism</a></li>
                        <li><a href="art-movements/installation-art.php">Installation Art</a></li>
                        <li><a href="art-movements/performance-art.php">Performance Art</a></li>
                        <li><a href="art-movements/street-art.php">Street Art</a></li>
                        <li><a href="art-movements/contemporary-art.php">Contemporary Art</a></li>
                    </ul>
                </div>
                <div class="dropdown">
                    <button type="button" onclick="toggleList('art-elements')">Art Elements</button>
                    <ul id="art-elements-list" class="dropdown-list">
                        <li><a href="art-elements/line.php">Line</a></li>
                        <li><a href="art-elements/shape.php">Shape</a></li>
                        <li><a href="art-elements/form.php">Form</a></li>
                        <li><a href="art-elements/color.php">Color</a></li>
                        <li><a href="art-elements/value.php">Value</a></li>
                        <li><a href="art-elements/texture.php">Texture</a></li>
                        <li><a href="art-elements/space.php">Space</a></li>
                    </ul>
                </div>
                <div class="dropdown">
                    <button type="button" onclick="toggleList('design-principles')">Design Principles</button>
                    <ul id="design-principles-list" class="dropdown-list">
                        <li><a href="design-principles/balance.php">Balance</a></li>
                        <li><a href="design-principles/contrast.php">Contrast</a></li>
                        <li><a href="design-principles/emphasis.php">Emphasis</a></li>
                        <li><a href="design-principles/movement.php">Movement</a></li>
                        <li><a href="design-principles/pattern.php">Pattern</a></li>
                        <li><a href="design-principles/rhythm.php">Rhythm</a></li>
                        <li><a href="design-principles/unity.php">Unity</a></li>
                        <li><a href="design-principles/proportion.php">Proportion</a></li>
                        <li><a href="design-principles/scale.php">Scale</a></li>
                        <li><a href="design-principles/harmony.php">Harmony</a></li>
                        <li><a href="design-principles/variety.php">Variety</a></li>
                        <li><a href="design-principles/repetition.php">Repetition</a></li>
                    </ul>
                </div>
            </aside>
            
            <!-- Middle Section: Activity Feed -->
            <section id="middle">
                <h2>Investigations</h2>
                <div class="activity-feed" id="feed">
                <!-- Will now be updated by ajax request to randomize feed.-->
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
                        <a href="view-posts.php" class="button">View Your Posts</a>
                        <a href="settings.php" class="button">Settings</a>
                    </div>
                </div>
            </aside>
    </main>

    <!-- Popup structure -->
    <div id="emailPopup" style="display:none;">
        <div class="popup-content">
            <h2>What the email would look like:</h2>
            <div id="emailContent"></div>
            <button id="closePopup" class="btn btn-primary">Close</button>
        </div>
    </div>

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

    <!-- JavaScript for Toggle Functionality -->
    <script>
        function toggleList(listId) {
            const list = document.getElementById(`${listId}-list`);
            list.style.display = list.style.display === 'block' ? 'none' : 'block';
        }
    </script>

    <!-- JavaScript for Email Popup -->    
    <script>
        // On form submission, fetch the email content and show the popup
        document.getElementById('newsletter-form').addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent actual form submission
            
            // Get email content from the session (via AJAX call)
            fetch('ajax/get-email-content.php') 
              .then(response => response.text())
              .then(emailContent => {
                document.getElementById('emailContent').innerHTML = emailContent;
                document.getElementById('emailPopup').style.display = 'block';
              });
        });

        // Close the popup
        document.getElementById('closePopup').addEventListener('click', function() {
            document.getElementById('emailPopup').style.display = 'none';
        });
    </script>

    <style>
        /* Basic CSS for the popup */
        #emailPopup {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: white;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0,0,0,0.5);
            z-index: 1000;
        }

        .email-wrapper main {
            display: block;
            flex: none;
        }

        #closePopup {
            background-color: #ff6f61ff;
            color: #fff;
            padding: 10px;
            border: none;
            cursor: pointer;
            border-radius: 4px;
        }

        .popup-content {
            max-height: 500px;
            max-width: 500px;
            overflow-y: auto;
        }
    </style>
   
</body>
</html>