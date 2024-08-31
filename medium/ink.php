<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ink</title>
    <link rel="icon" href="../media/branding/icon.jpeg" type="image/jpeg">
    <link rel="stylesheet" href="../css/style-library.css">
    <script src="../js/jquery-3.7.1.min.js"></script>
</head>
<body>
    <header>
        <div class="branding">
            <img src="../media/branding/icon-dark.jpeg" alt="Icon" class="header-icon">
            <span>ARTIST INVESTIGATORS</span>
        </div>
    </header>
    <main>
        <section class="content-section">
            <div class="content-container">
                <h1 class="page-heading">Ink</h1>
                
                <h3>Introduction:</h3>
                <p>Ink is a versatile medium used for drawing and writing, known for its rich black color and varied applications. It can be used with pens, brushes, or quills to create detailed line work and expressive marks.</p>
                
                <h3>History:</h3>
                <p>Ink has been used since ancient times, with early inks made from natural sources like charcoal and plant extracts. It has evolved over centuries and remains a fundamental medium for artists and writers.</p>

                <h3>Characteristics:</h3>
                <ul>
                    <li><strong>Rich Color:</strong> Produces deep, intense blacks and other colors depending on the ink type.</li>
                    <li><strong>Line Quality:</strong> Can create fine lines, bold strokes, and varying textures.</li>
                    <li><strong>Drying Time:</strong> Inks can vary in drying time, affecting how they interact with the paper.</li>
                    <li><strong>Application Methods:</strong> Can be applied with pens, brushes, or other tools for diverse effects.</li>
                </ul>

                <h3>Techniques:</h3>
                <ul>
                    <li><strong>Cross-Hatching:</strong> Building up tone and texture through intersecting lines.</li>
                    <li><strong>Stippling:</strong> Creating texture and depth with dots of ink.</li>
                    <li><strong>Wash Technique:</strong> Diluting ink with water to create gradient effects.</li>
                    <li><strong>Calligraphy:</strong> Using special tools and techniques to create decorative writing.</li>
                </ul>

                <h3>Care and Preservation:</h3>
                <p>Ink drawings should be kept from moisture and direct sunlight to prevent fading. Store in a protective sleeve or frame under glass to preserve the work.</p>

                <h3>Examples:</h3>
                <div class="examples-container">
                    <div class="example">
                        <img src="../media/artworks/shrimp.jpg" alt="Shrimp by Qi Baishi" class="artwork-image">
                        <h4>Artwork Title: Shrimp</h4>
                        <p>Artist: Qi Baishi</p>
                        <p>Year: 1940</p>
                        <p>Description: A traditional Chinese ink painting with flowing lines and delicate brushstrokes depicting nature scenes.</p>
                    </div>
                    <div class="example">
                        <img src="../media/artworks/chief.jpg" alt="Chief by Franz Kline" class="artwork-image">
                        <h4>Artwork Title: Chief</h4>
                        <p>Artist: Franz Kline</p>
                        <p>Year: 1950</p>
                        <p>Description: A bold and abstract ink piece with thick, dynamic strokes creating a striking contrast.</p>
                    </div>
                </div>

                <a href="../dashboard.php" class="btn btn-primary">Return to Dashboard</a>
            </div>
        </section>
    </main>
    <footer>
        <p>&copy; 2024 Artist Investigators. All rights reserved.</p>
    </footer>
</body>
</html>