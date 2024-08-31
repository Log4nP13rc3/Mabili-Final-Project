<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Renaissance</title>
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
                <h1 class="page-heading">Renaissance</h1>
                
                <h3>Introduction:</h3>
                <p>The Renaissance spanned from the 14th to the 17th century, originating in Italy, particularly in cities like Florence, Venice, and Rome, before spreading across Europe. It marked a period of renewed interest in the classical arts, science, and philosophy of Ancient Greece and Rome, emerging in response to medieval religious and feudal constraints. Emphasizing humanism, exploration, and individual expression, the Renaissance laid the groundwork for modern Western culture.</p>
                
                <h3>Characteristics:</h3>
                <p>Renaissance art is characterized by the use of perspective, naturalism, anatomical accuracy, and balance in compositions. Artists focused on realism and accurate representation of the human form. The philosophy celebrated humanism, emphasizing individual potential and achievement. Innovations included the development of linear perspective, chiaroscuro (contrast of light and shadow), and sfumato (soft blending of colors).</p>
                
                <h3>Key Artists:</h3>
                <ul>
                    <li>Leonardo da Vinci: Known for his mastery of technique and intellectual depth.</li>
                    <li>Michelangelo: Renowned for his sculptures and the ceiling of the Sistine Chapel.</li>
                    <li>Raphael: Celebrated for his harmonious and graceful compositions.</li>
                </ul>

                <h3>Examples:</h3>
                <div class="examples-container">
                    <div class="example">
                        <img src="../media/artworks/mona-lisa.jpg" alt="Mona Lisa" class="artwork-image">
                        <h4>Artwork Title: Mona Lisa</h4>
                        <p>Artist: Leonardo da Vinci</p>
                        <p>Year: 1503-1506</p>
                        <p>Description: Mona Lisa exemplifies the Renaissance's focus on realism and human emotion, with its lifelike depiction of the subject's enigmatic expression and the use of atmospheric perspective.</p>
                    </div>
                    <div class="example">
                        <img src="../media/artworks/david.jpg" alt="David" class="artwork-image">
                        <h4>Artwork Title: David</h4>
                        <p>Artist: Michelangelo</p>
                        <p>Year: 1501-1504</p>
                        <p>Description: Michelangelo's David is a symbol of the Renaissance's ideal of human beauty and strength. Its anatomical accuracy and the tension in the figure represent the movement's fascination with the human body and classical ideals.</p>
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