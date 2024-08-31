document.addEventListener("DOMContentLoaded", function () {
    fetch('check-session.php')
        .then(response => response.json())
        .then(data => {
            if (!data.authenticated) {
                // First, redirect to whoops.html
                window.location.href = 'whoops.html';
                
                // Then, after a delay, redirect to sign-in.html
                setTimeout(function() {
                    window.location.href = 'sign-in.html';
                }, 2000); 
            }
        })
        .catch(error => {
            console.error('Error:', error);
            // If an error occurs, redirect to whoops.html
            window.location.href = 'whoops.html';
            
            // Then, after a delay, redirect to sign-in.html
            setTimeout(function() {
                window.location.href = 'sign-in.html';
            }, 2000); 
        });
});