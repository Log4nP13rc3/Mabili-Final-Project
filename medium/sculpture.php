<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sculpture</title>
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
                <h1 class="page-heading">Sculpture</h1>
                
                <h3>Introduction:</h3>
                <p>Sculpture is a three-dimensional art form that involves shaping materials into artistic forms. Sculptors work with various materials, including clay, metal, stone, and wood, to create works that can be viewed from multiple angles.</p>
                
                <h3>History:</h3>
                <p>Sculpture has a rich history, from ancient Egyptian statues to Renaissance masterpieces and contemporary installations. Different cultures and periods have contributed to the evolution of sculptural techniques and styles.</p>

                <h3>Characteristics:</h3>
                <ul>
                    <li><strong>Three-Dimensionality:</strong> Allows for viewing and interaction from various perspectives.</li>
                    <li><strong>Material Versatility:</strong> Can be created using a range of materials, each with unique properties.</li>
                    <li><strong>Texture:</strong> Offers diverse textures and surface qualities, depending on the material and technique.</li>
                    <li><strong>Scale:</strong> Can range from small, intricate pieces to large, monumental works.</li>
                </ul>

                <h3>Techniques:</h3>
                <ul>
                    <li><strong>Carving:</strong> Removing material to shape the sculpture, often used with stone or wood.</li>
                    <li><strong>Modeling:</strong> Adding material to create form, commonly used with clay or wax.</li>
                    <li><strong>Casting:</strong> Pouring liquid material into a mold to create a sculpture, used with metals and resins.</li>
                    <li><strong>Assemblage:</strong> Combining different materials or objects to create a new form or composition.</li>
                </ul>

                <h3>Care and Preservation:</h3>
                <p>Sculptures should be maintained according to their material. Stone and metal sculptures need regular cleaning, while clay and wood require protection from moisture and temperature fluctuations. Proper storage and handling are essential to prevent damage.</p>

                <h3>Examples:</h3>
                <div class="examples-container">
                    <div class="example">
                        <img src="../media/artworks/the-thinker.jpg" alt="The Thinker" class="artwork-image">
                        <h4>Artwork Title: The Thinker</h4>
                        <p>Artist: Auguste Rodin</p>
                        <p>Year: 1904</p>
                        <p>Description: A bronze sculpture of a man deep in thought, symbolizing intellectual contemplation and the human condition.</p>
                    </div>
                    <div class="example">
                        <img src="../media/artworks/david.jpg" alt="David" class="artwork-image">
                        <h4>Artwork Title: David</h4>
                        <p>Artist: Michelangelo</p>
                        <p>Year: 1504</p>
                        <p>Description: A marble sculpture of the biblical figure David, celebrated for its extraordinary detail and representation of classical ideals.</p>
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