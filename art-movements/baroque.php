<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Baroque</title>
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
                <h1 class="page-heading">Baroque</h1>
                
                <h3>Introduction:</h3>
                <p>The Baroque period spanned from the 17th to the mid-18th century, originating in Italy and spreading throughout Europe, particularly in Catholic regions. It coincided with the Counter-Reformation, during which the Catholic Church sought to reassert its influence. Baroque art is marked by grandeur, drama, and emotional intensity.</p>
                
                <h3>Characteristics:</h3>
                <p>Baroque art features dramatic use of light and shadow (tenebrism), intense emotion, dynamic compositions, and a sense of movement and tension. It aimed to evoke strong emotional responses, often through religious themes and the grandeur of the divine. Innovations included mastery of chiaroscuro and advancements in theatricality and large-scale compositions.</p>
                
                <h3>Key Artists:</h3>
                <ul>
                    <li>Caravaggio: Known for his dramatic use of light and shadow and intense realism.</li>
                    <li>Peter Paul Rubens: Celebrated for his dynamic compositions and vibrant color palette.</li>
                    <li>Gian Lorenzo Bernini: A master of Baroque sculpture, known for his dramatic and lifelike works.</li>
                </ul>

                <h3>Examples:</h3>
                <div class="examples-container">
                    <div class="example">
                        <img src="../media/artworks/calling-of-st-matthew.jpg" alt="The Calling of St. Matthew" class="artwork-image">
                        <h4>Artwork Title: The Calling of St. Matthew</h4>
                        <p>Artist: Caravaggio</p>
                        <p>Year: 1599-1600</p>
                        <p>Description: This work exemplifies Baroque's dramatic use of light and shadow, with a strong diagonal composition and intense emotional expression. The moment of spiritual awakening is captured with gripping realism.</p>
                    </div>
                    <div class="example">
                        <img src="../media/artworks/ecstasy-of-saint-teresa.jpg" alt="The Ecstasy of Saint Teresa" class="artwork-image">
                        <h4>Artwork Title: The Ecstasy of Saint Teresa</h4>
                        <p>Artist: Gian Lorenzo Bernini</p>
                        <p>Year: 1647-1652</p>
                        <p>Description: This sculpture captures the emotional and spiritual intensity characteristic of Baroque art. Bernini's use of flowing drapery and expressive faces creates a sense of divine presence and movement.</p>
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