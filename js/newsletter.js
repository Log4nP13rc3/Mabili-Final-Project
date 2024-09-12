document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('newsletter-form');
    const messageDiv = document.getElementById('newsletter-message');
    const emailPopup = document.getElementById('emailPopup');
    const emailContent = document.getElementById('emailContent');

    form.addEventListener('submit', function(event) {
        event.preventDefault();
        
        const email = document.getElementById('email').value;

        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'ajax/newsletter.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    messageDiv.innerHTML = xhr.responseText; // Display success or error message

                    // Fetch and display email content in the popup
                    fetchEmailContent();
                } else {
                    messageDiv.innerHTML = 'There was a problem with your subscription. Please try again.';
                }
            }
        };

        xhr.send('email=' + encodeURIComponent(email));
    });

    function fetchEmailContent() {
        const xhr = new XMLHttpRequest();
        xhr.open('GET', 'ajax/get-email-content.php', true);
        
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    // Ensure email content is set and displayed
                    emailContent.innerHTML = xhr.responseText;
                    emailPopup.style.display = 'block'; // Show the popup
                } else {
                    console.error('Failed to fetch email content.');
                }
            }
        };
        
        xhr.send();
    }

    // Close the popup
    document.getElementById('closePopup').addEventListener('click', function() {
        emailPopup.style.display = 'none';
    });
});