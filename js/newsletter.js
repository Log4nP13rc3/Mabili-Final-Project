document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('newsletter-form');
    const messageDiv = document.getElementById('newsletter-message');

    form.addEventListener('submit', function(event) {
        event.preventDefault();
        
        const email = document.getElementById('email').value;

        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'ajax/newsletter.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    messageDiv.innerHTML = 'Subscription successful! Please check your email.';
                } else {
                    messageDiv.innerHTML = 'There was a problem with your subscription. Please try again.';
                }
            }
        };

        xhr.send('email=' + encodeURIComponent(email));
    });
});