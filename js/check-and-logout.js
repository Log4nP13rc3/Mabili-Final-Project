// To check and logout if non-secure pages are accessed
document.addEventListener("DOMContentLoaded", function () {
    fetch('check-session.php')
        .then(response => response.json())
        .then(data => {
            if (data.authenticated) {
                fetch('sign-out.php')
                    .then(() => {
                        window.location.href = 'bye.html';
                    })
                    .catch(error => {
                        console.error('Error signing out:', error);
                    });
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
});