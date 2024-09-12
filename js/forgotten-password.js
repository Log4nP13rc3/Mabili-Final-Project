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
            beforeSend: function() {
                // Show loading indicator
                $('#message').html('<p>Loading...</p>');
            },
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

                    // Fetch and display email content
                    fetchEmailContent();
                }
            },
            error: function(xhr, status, error) {
                $('#message').html('An error occurred: ' + error);
            }
        });
    });

    function fetchEmailContent() {
        $('#emailContent').html('<p>Loading email content...</p>'); // Show loading message
        
        $.ajax({
            url: 'ajax/get-email-content.php',
            success: function(response) {
                $('#emailContent').html(response); // Display the email content
                $('#emailPopup').show(); // Show the popup
            },
            error: function() {
                $('#emailContent').html('<p>Failed to load email content</p>');
            }
        });
    }

    // Close the popup
    $('#closePopup').click(function() {
        $('#emailPopup').hide();
    });
});