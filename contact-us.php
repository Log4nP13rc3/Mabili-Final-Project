<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <link rel="icon" href="media/branding/icon.jpeg" type="image/jpeg">
    <link rel="stylesheet" href="css/style.css">
    <script src="js/jquery-3.7.1.min.js"></script>
    <script src="js/contact-us.js"></script>
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
                    <h1 class="page-heading">Contact Us</h1>
                    <form id="contact-us-form" class="sign-in-form"> <!-- Added ID here -->
                        <div class="form-group">
                            <label for="email">Email Address</label>
                            <input type="email" id="email" name="email" required aria-required="true" placeholder="Enter your email address" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="subject">Subject</label>
                            <input type="text" id="subject" name="subject" required aria-required="true" placeholder="Enter the subject" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="message">Message</label>
                            <textarea id="message" name="message" rows="5" required aria-required="true" placeholder="Enter your message" class="form-control"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary" id="contact-us-button">Send Message</button>
                    </form>
                    <div id="js-message"></div>
                </div>
            </div>
        </section>
    </main>

    <!-- Popup structure -->
    <div id="emailPopup" style="display:none;">
        <div class="popup-content">
            <h2>What the email would look like:</h2>
            <div id="emailContent"></div>
            <button id="closePopup" class="btn btn-primary">Close</button>
        </div>
    </div>

    <footer>
        <p>&copy; 2024 Artist Investigators. All rights reserved.</p>
    </footer>

    <script>
        // On form submission, fetch the email content and show the popup
        document.getElementById('contact-us-form').addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent actual form submission
            
            // Get email content from the session (via AJAX call)
            fetch('ajax/get-email-content.php') 
              .then(response => response.text())
              .then(emailContent => {
                document.getElementById('emailContent').innerHTML = emailContent;
                document.getElementById('emailPopup').style.display = 'block';
              });
        });

        // Close the popup
        document.getElementById('closePopup').addEventListener('click', function() {
            document.getElementById('emailPopup').style.display = 'none';
        });
    </script>

    <style>
        /* Basic CSS for the popup */
        #emailPopup {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: white;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0,0,0,0.5);
            z-index: 1000;
        }

        .email-wrapper main {
            display: block;
            flex: none;
        }

        #closePopup {
            background-color: #ff6f61ff;
            color: #fff;
            padding: 10px;
            border: none;
            cursor: pointer;
        }

        .popup-content {
            max-height: 500px;
            max-width: 500px;
            overflow-y: auto;
        }
    </style>

</body>
</html>