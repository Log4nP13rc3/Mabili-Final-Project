<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Printmaking</title>
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
                <h1 class="page-heading">Printmaking</h1>
                
                <h3>Introduction:</h3>
                <p>Printmaking is the process of creating artworks by printing, normally on paper. It encompasses various techniques such as etching, lithography, and screen printing, each producing distinct effects and textures.</p>
                
                <h3>History:</h3>
                <p>Printmaking has a long history dating back to ancient China and Japan. In the West, it became prominent during the Renaissance with techniques like woodcut and engraving, which revolutionized the distribution of art.</p>

                <h3>Characteristics:</h3>
                <ul>
                    <li><strong>Reproducibility:</strong> Allows for the creation of multiple copies of a single artwork.</li>
                    <li><strong>Texture:</strong> Each print can exhibit unique textures and details, depending on the technique.</li>
                    <li><strong>Variety:</strong> Includes various techniques and methods, offering diverse results.</li>
                    <li><strong>Layering:</strong> Some techniques involve layering colors and textures for complex effects.</li>
                </ul>

                <h3>Techniques:</h3>
                <ul>
                    <li><strong>Etching:</strong> Involves carving into a metal plate and using acid to create a print.</li>
                    <li><strong>Screen Printing:</strong> Uses a mesh screen to transfer ink onto paper or fabric through stencils.</li>
                    <li><strong>Woodcut:</strong> Involves carving a design into a wooden block and inking it for printing.</li>
                    <li><strong>Lithography:</strong> Uses a flat stone or metal plate and a greasy medium to create prints.</li>
                </ul>

                <h3>Care and Preservation:</h3>
                <p>Prints should be stored in a cool, dry place and framed under glass to protect them from dust and light. Avoid direct sunlight and excessive handling to maintain their quality.</p>

                <h3>Examples:</h3>
                <div class="examples-container">
                    <div class="example">
                        <img src="../media/artworks/the-rhinoceros.jpg" alt="The Rhinoceros" class="artwork-image">
                        <h4>Artwork Title: The Rhinoceros</h4>
                        <p>Artist: Albrecht Dürer</p>
                        <p>Year: 1515</p>
                        <p>Description: A detailed woodcut print depicting a rhinoceros, renowned for its intricate linework and realistic detail.</p>
                    </div>
                    <div class="example">
                        <img src="../media/artworks/marilyn-diptych.jpg" alt="Marilyn Diptych" class="artwork-image">
                        <h4>Artwork Title: Marilyn Diptych</h4>
                        <p>Artist: Andy Warhol</p>
                        <p>Year: 1962</p>
                        <p>Description: A bold screenprint featuring repeated images of Marilyn Monroe, highlighting the Pop Art movement’s emphasis on celebrity culture and mass production.</p>
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