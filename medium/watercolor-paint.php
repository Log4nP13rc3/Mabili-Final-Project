<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Watercolor Paint</title>
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
                <h1 class="page-heading">Watercolor Paint</h1>
                
                <h3>Introduction:</h3>
                <p>Watercolor paint is a medium consisting of pigments suspended in a water-soluble binder. Known for its transparency and fluidity, watercolor can produce a wide range of effects, from delicate washes to vibrant hues.</p>
                
                <h3>History:</h3>
                <p>Watercolor painting dates back to ancient civilizations such as Egypt and China. In Europe, it became popular during the Renaissance and was widely used by artists such as J.M.W. Turner and Winslow Homer.</p>

                <h3>Characteristics:</h3>
                <ul>
                    <li><strong>Transparency:</strong> Allows underlying layers or the white of the paper to show through.</li>
                    <li><strong>Fluidity:</strong> Creates soft edges and blends effortlessly due to the watery consistency.</li>
                    <li><strong>Vibrancy:</strong> Capable of producing both delicate and vivid colors, depending on the pigment and dilution.</li>
                    <li><strong>Layering:</strong> Builds up color in layers to achieve depth and complexity.</li>
                </ul>

                <h3>Techniques:</h3>
                <ul>
                    <li><strong>Wet-on-Wet:</strong> Applying wet paint onto wet paper to create soft, blended effects.</li>
                    <li><strong>Wet-on-Dry:</strong> Applying wet paint onto dry paper for more defined edges and details.</li>
                    <li><strong>Glazing:</strong> Applying a transparent layer of paint over a dry layer to modify color and create depth.</li>
                    <li><strong>Splattering:</strong> Flicking or splashing paint onto the paper to create texture and random effects.</li>
                </ul>

                <h3>Care and Preservation:</h3>
                <p>Watercolor paintings should be protected from moisture and sunlight. Frame under glass to prevent damage, and store in a climate-controlled environment to avoid warping and fading.</p>

                <h3>Examples:</h3>
                <div class="examples-container">
                    <div class="example">
                        <img src="../media/artworks/shipwreck.jpg" alt="Turner’s Shipwreck" class="artwork-image">
                        <h4>Artwork Title: Shipwreck</h4>
                        <p>Artist: J.M.W. Turner</p>
                        <p>Year: 1805</p>
                        <p>Description: A dramatic watercolor painting capturing the power and turbulence of a storm at sea, showcasing Turner’s mastery of light and atmosphere.</p>
                    </div>
                    <div class="example">
                        <img src="../media/artworks/roses.jpg" alt="Roses" class="artwork-image">
                        <h4>Artwork Title: Roses</h4>
                        <p>Artist: Georgia O'Keeffe</p>
                        <p>Year: 1923</p>
                        <p>Description: A delicate watercolor painting of roses, highlighting O'Keeffe’s emphasis on the natural beauty and form of flowers through soft gradients and vibrant colors.</p>
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