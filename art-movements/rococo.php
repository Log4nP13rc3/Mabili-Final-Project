<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rococo</title>
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
                <h1 class="page-heading">Rococo</h1>
                
                <h3>Introduction:</h3>
                <p>Rococo emerged in the early to mid-18th century in France and spread across Europe. It arose as a reaction to the grandeur and seriousness of the Baroque, reflecting the aristocracy's taste for a decorative, light-hearted style that mirrored the decadence of the time.</p>
                
                <h3>Characteristics:</h3>
                <p>Rococo is characterized by delicate, ornate decoration, light colors (especially pastels), playful themes, and asymmetrical designs. It often depicted scenes of leisure and love, emphasizing beauty and the carefree lifestyle of the aristocracy. Innovations included intricate details and ornamental designs in both painting and architecture.</p>
                
                <h3>Key Artists:</h3>
                <ul>
                    <li>Jean-Honoré Fragonard: Known for his romantic and playful scenes.</li>
                    <li>François Boucher: Celebrated for his mythological and pastoral scenes with a light, airy touch.</li>
                    <li>Antoine Watteau: His works often depicted elegant gatherings and the pleasures of life.</li>
                </ul>

                <h3>Examples:</h3>
                <div class="examples-container">
                    <div class="example">
                        <img src="../media/artworks/swing.jpg" alt="The Swing" class="artwork-image">
                        <h4>Artwork Title: The Swing</h4>
                        <p>Artist: Jean-Honoré Fragonard</p>
                        <p>Year: 1767</p>
                        <p>Description: This iconic Rococo painting captures the playful and romantic spirit of the movement. The light color palette, soft brushwork, and whimsical subject matter are all hallmarks of Rococo style.</p>
                    </div>
                    <div class="example">
                        <img src="../media/artworks/toilette-of-venus.jpg" alt="The Toilette of Venus" class="artwork-image">
                        <h4>Artwork Title: The Toilette of Venus</h4>
                        <p>Artist: François Boucher</p>
                        <p>Year: 1751</p>
                        <p>Description: Boucher’s work exemplifies Rococo's focus on beauty and sensuality. The soft, pastel colors and delicate rendering of mythological themes are typical of the movement.</p>
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