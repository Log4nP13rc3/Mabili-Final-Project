$(document).ready(function() {
    $('#contact-us-form').submit(function(event) { // Updated ID here
        event.preventDefault();

        // Collecting user data from the form fields
        let formData = {
            email: $('#email').val(),
            subject: $('#subject').val(),
            message: $('#message').val(),
        };

        // Sending AJAX request to server
        $.ajax({
            url: 'ajax/contact-us.php',
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function(response) {
                if (response.errors) {
                    // Display the server's validation errors
                    let errorHtml = '<ul class="error-message">';
                    response.errors.forEach(function(error) {
                        errorHtml += '<li>' + error + '</li>';
                    });
                    errorHtml += '</ul>';
                    $('#js-message').html(errorHtml);
                } else if (response.success) {
                    // Display success message or clear the form
                    $('#js-message').html('<p>Your message has been sent successfully.</p>');
                    $('#contact-us-form')[0].reset(); // Updated ID here
                }
            },
            error: function(xhr, status, error) {
                // If error then display error instead
                $('#js-message').html('An error occurred: ' + error);
            }
        });
    });
});