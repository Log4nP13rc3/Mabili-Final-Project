$(document).ready(function() {
    $('#forgotten-password-button').click(function(event) {
        event.preventDefault();

        // Collect user input
        let userData = {
            email: $('#email').val()
        };

        // Send AJAX request
        $.ajax({
            url: 'ajax/forgotten-password.php',
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
                    // Display success message
                    $('#message').html('<p>Reset link sent. Check your email for further instructions.</p>');
                }
            },
            error: function(xhr, status, error) {
                $('#message').html('An error occurred: ' + error);
            }
        });
    });
});