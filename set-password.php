<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Set Password</title>
    <link rel="icon" href="media/branding/icon.jpeg" type="image/jpeg">
    <link rel="stylesheet" href="css/style.css">
    <script src="js/jquery-3.7.1.min.js"></script>
    <script src="js/set-password.js"></script>
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
                    <h1 class="page-heading">Set Password</h1>
                    <form id="set-password-form" aria-labelledby="set-password-heading" class="sign-in-form">
                        <div class="form-group">
                            <label for="new-password">New Password</label>
                            <input type="password" id="new-password" name="new-password" required aria-required="true" placeholder="Enter your new password" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="confirm-password">Confirm New Password</label>
                            <input type="password" id="confirm-password" name="confirm-password" required aria-required="true" placeholder="Confirm your new password" class="form-control">
                        </div>
                        <button type="submit" class="btn btn-primary" id="set-password-button">Set Password</button>
                    </form>
                    <div id="message"></div>
                </div>
            </div>
        </section>
    </main>
    <footer>
        <p>&copy; 2024 Artist Investigators. All rights reserved.</p>
    </footer>
</body>
</html>