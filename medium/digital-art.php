<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Digital Art</title>
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
                <h1 class="page-heading">Digital Art</h1>
                
                <h3>Introduction:</h3>
                <p>Digital art is created using digital tools and technology, often involving software like Adobe Photoshop or Illustrator. It encompasses a range of styles and techniques and can be as varied as traditional art forms, including drawing, painting, and 3D modeling.</p>
                
                <h3>History:</h3>
                <p>Digital art emerged with the advent of computer technology in the late 20th century. Early digital artists used simple tools and software, but advancements have led to increasingly sophisticated techniques and forms of digital expression.</p>

                <h3>Characteristics:</h3>
                <ul>
                    <li><strong>Flexibility:</strong> Digital art allows for easy manipulation and experimentation with different elements and styles.</li>
                    <li><strong>Precision:</strong> Software tools provide precise control over details and effects.</li>
                    <li><strong>Reproducibility:</strong> Digital works can be easily duplicated and shared without loss of quality.</li>
                    <li><strong>Integration:</strong> Can integrate with other digital media such as video and animation.</li>
                </ul>

                <h3>Techniques:</h3>
                <ul>
                    <li><strong>Digital Painting:</strong> Creating artwork using brushes and tools within digital painting software.</li>
                    <li><strong>Vector Art:</strong> Using vector graphics software to create scalable and clean images.</li>
                    <li><strong>3D Modeling:</strong> Designing three-dimensional objects and scenes using specialized software.</li>
                    <li><strong>Photo Manipulation:</strong> Altering or combining photographs to create new visuals.</li>
                </ul>

                <h3>Care and Preservation:</h3>
                <p>Digital art is stored in digital formats and should be backed up to prevent loss. Ensure files are saved in standard formats to ensure compatibility with various software and hardware.</p>

                <h3>Examples:</h3>
                <div class="examples-container">
                    <div class="example">
                        <img src="../media/artworks/into-time.jpg" alt="Into Time by Rafaël Rozendaal" class="artwork-image">
                        <h4>Artwork Title: Into Time</h4>
                        <p>Artist: Rafaël Rozendaal</p>
                        <p>Year: 2010</p>
                        <p>Description: A visually striking digital piece that utilizes glitches and bright colors to create an abstract form.</p>
                    </div>
                    <div class="example">
                        <img src="../media/artworks/everydays-the-first-5000-days.jpg" alt="Everydays: The First 5000 Days by Beeple" class="artwork-image">
                        <h4>Artwork Title: Everydays: The First 5000 Days</h4>
                        <p>Artist: Beeple (Mike Winkelmann)</p>
                        <p>Year: 2021</p>
                        <p>Description: A futuristic digital art piece showcasing surreal and fantastical elements in a digital landscape.</p>
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