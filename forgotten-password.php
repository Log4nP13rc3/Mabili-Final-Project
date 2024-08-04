<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgotten Password</title>
    <link rel="icon" href="media/branding/icon.jpeg" type="image/jpeg">
    <link rel="stylesheet" href="css/style.css">
    <script src="js/jquery-3.7.1.min.js"></script>
    <script src="js/forgotten-password.js"></script>
</head>
<body>
    <header>
        <div class="branding">
            <img src="media/branding/icon-dark.jpeg" alt="Icon" class="header-icon">
            <span>ARTIST INVESTIGATORS</span>
        </div>
    </header>
    <main>
        <section class="sign-in-section">
            <div class="sign-in-container">
                <div class="logo-container">
                    <img src="media/branding/logo.jpeg" alt="Artist Investigators Logo" class="logo">
                </div>
                <div class="sign-in-form-container">
                    <h1 class="page-heading">Forgotten Password</h1>
                    <form id="forgotten-password-form" aria-labelledby="forgotten-password-heading" class="sign-in-form">
                        <div class="form-group">
                            <label for="email">Email Address</label>
                            <input type="email" id="email" name="email" required aria-required="true" placeholder="Enter your email address" class="form-control">
                        </div>
                        <button type="submit" class="btn btn-primary" id="forgotten-password-button">Submit</button>
                    </form>
                    <div id="message"></div>
                    <p><a href="sign-in.html" class="btn btn-link">Back to Sign-In</a></p>
                </div>
            </div>
        </section>
    </main>
    <footer>
        <p>&copy; 2024 Artist Investigators. All rights reserved.</p>
    </footer>
</body>
</html>