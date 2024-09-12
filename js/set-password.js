$(document).ready(function() {
    $('#set-password-button').click(function(event) {
        event.preventDefault();

        // Collect user inputs
        let userData = {
            newPassword: $('#new-password').val(),
            confirmPassword: $('#confirm-password').val(),
            pin: getUrlParameter('pin'),
            token: getUrlParameter('token')
        };

        // Send AJAX request
        $.ajax({
            url: 'ajax/set-password.php',
            type: 'POST',
            data: userData,
            dataType: 'json',
            success: function(response) {
                if (response.errors) {
                    // Display validation errors
                    let errorHtml = '<ul class="error-message">';
                    response.errors.forEach(function(error) {
                        errorHtml += '<li>' + error + '</li>';
                    });
                    errorHtml += '</ul>';
                    $('#message').html(errorHtml);
                } else if (response.success) {
                    // Display success message and redirect to sign-in page
                    $('#message').html('<p>Password successfully updated. Redirecting to sign-in page...</p>');
                    setTimeout(function() {
                        window.location.href = 'index.html';
                    }, 0);
                }
            },
            error: function(xhr, status, error) {
                $('#message').html('An error occurred: ' + error);
            }
        });
    });

    // Function to get URL parameters
    function getUrlParameter(name) {
        let result = null;
        let regex = new RegExp('[?&]' + name + '=([^&#]*)');
        let match = regex.exec(window.location.search);
        if (match) {
            result = decodeURIComponent(match[1]);
        }
        return result;
    }
});