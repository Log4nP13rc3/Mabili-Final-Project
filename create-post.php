<?php
session_start();
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    die("User not logged in.");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Post</title>
    <link rel="icon" href="media/branding/icon.jpeg" type="image/jpeg">
    <link rel="stylesheet" href="css/style-create.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
    <script src="js/create-post.js" defer></script>
</head>
<body>
    <header>
        <div class="branding">
            <img src="media/branding/icon-dark.jpeg" alt="Icon" class="header-icon">
            <span>ARTIST INVESTIGATORS</span>
        </div>
    </header>
    <main>
        <section>
            <h1>Create a New Post</h1>

            <form id="create-post-form" enctype="multipart/form-data">
                <!--Title of Post-->
                <div class="form-group">
                    <h2>Title</h2>
                    <p>Provide a title for your investigation:</p>
                    <label for="title"></label>
                    <input type="text" id="title" name="title" maxlength="100" required>
                    <div id="title-count">0/100</div>
                </div>

                <!--Content of Post-->
                <div class="form-group">
                    <h2>Investigate</h2>
                    <p>Write the content for your investigation:</p>
                    <label for="content"></label>
                    <textarea id="content" name="content"></textarea>
                    <div id="content-count">0/1000</div>
                </div>

                <script>
                    CKEDITOR.replace('content'); // Add CKEditor
                </script>

                <!--Image for Post-->
                <div class="form-group">
                    <h2>Artwork</h2>
                    <p>Upload an image of the artwork:</p>
                    <label for="image"></label>
                    <input type="file" id="image" name="image" accept="image/*" required>
                    <div id="image-preview"></div>
                </div>

                <!--Categories of Post-->
                <h2>Categories</h2>
                <p>Choose one item from each category that matches the artwork investigated:</p>
                <div class="categories-container">
                    <div class="form-group">
                        <label for="media-categories">Media</label>
                        <select id="media-categories" name="media_categories" required>
                            <option value="">Select a Media</option>
                            <option value="acrylic-paint">Acrylic Paint</option>
                            <option value="oil-paint">Oil Paint</option>
                            <option value="watercolour-paint">Watercolour Paint</option>
                            <option value="gouache">Gouache</option>
                            <option value="ink">Ink</option>
                            <option value="charcoal">Charcoal</option>
                            <option value="graphite">Graphite</option>
                            <option value="pastel">Pastel</option>
                            <option value="polymer-clay">Polymer Clay</option>
                            <option value="mixed-media">Mixed Media</option>
                            <option value="digital-art">Digital Art</option>
                            <option value="collage">Collage</option>
                            <option value="sculpture">Sculpture</option>
                            <option value="ceramics">Ceramics</option>
                            <option value="photography">Photography</option>
                            <option value="printmaking">Printmaking</option>
                            <option value="textiles">Textiles</option>
                        </select>
                    </div>

                    <div class="form-group">  
                        <label for="themes-categories">Themes</label>
                        <select id="themes-categories" name="themes_categories" required>
                            <option value="">Select a Theme</option>
                            <option value="nature">Nature</option>
                            <option value="identity">Identity</option>
                            <option value="power-politics">Power and Politics</option>
                            <option value="war-conflict">War and Conflict</option>
                            <option value="love-relationships">Love and Relationships</option>
                            <option value="mythology-religion">Mythology and Religion</option>
                            <option value="urban-life">Urban Life</option>
                            <option value="social-issues">Social Issues</option>
                            <option value="dreams-fantasy">Dreams and Fantasy</option>
                            <option value="history-memory">History and Memory</option>
                            <option value="technology-innovation">Technology and Innovation</option>
                            <option value="environment-sustainability">Environment and Sustainability</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="art-movements-categories">Art Movements</label>
                        <select id="art-movements-categories" name="art_movements_categories" required>
                            <option value="">Select an Art Movement</option>
                            <option value="renaissance">Renaissance</option>
                            <option value="baroque">Baroque</option>
                            <option value="rococo">Rococo</option>
                            <option value="neoclassicism">Neoclassicism</option>
                            <option value="romanticism">Romanticism</option>
                            <option value="realism">Realism</option>
                            <option value="impressionism">Impressionism</option>
                            <option value="post-impressionism">Post-Impressionism</option>
                            <option value="symbolism">Symbolism</option>
                            <option value="art-nouveau">Art Nouveau</option>
                            <option value="fauvism">Fauvism</option>
                            <option value="expressionism">Expressionism</option>
                            <option value="cubism">Cubism</option>
                            <option value="futurism">Futurism</option>
                            <option value="dada">Dada</option>
                            <option value="surrealism">Surrealism</option>
                            <option value="abstract-expressionism">Abstract Expressionism</option>
                            <option value="pop-art">Pop Art</option>
                            <option value="minimalism">Minimalism</option>
                            <option value="conceptual-art">Conceptual Art</option>
                            <option value="op-art">Op Art</option>
                            <option value="photorealism">Photorealism</option>
                            <option value="street-art">Street Art</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <input type="submit" value="Create Post">
                </div>
                <div id="message"></div>
            </div>
            </form>  
        </section>
    </main>
    
    <footer>
        <p>&copy; 2024 Artist Investigators. All rights reserved.</p>
    </footer>
</body>
</html>