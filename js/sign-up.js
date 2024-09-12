$(document).ready(function() {
    $('#sign-up-button').click(function(event) {
        event.preventDefault();

        // Collecting user data from the form fields
        let userData = {
            username: $('#username').val(),
            email: $('#email').val(),
            password: $('#password').val(),
            confirmPassword: $('#confirm-password').val(),
            website: $('#website').val() // Honeypot field
        };

        // Sending AJAX request to server
        $.ajax({
            url: 'ajax/sign-up.php',
            type: 'POST',
            data: userData,
            success: function(response) {
                console.log('Server Response:', response); // Debugging: Output server response
                // If the request works then display the server's response in the message div
                $('#message').html(response);
                
                // Fetch email content and show the popup
                fetch('ajax/get-email-content.php')
                    .then(response => response.text())
                    .then(emailContent => {
                        console.log('Email Content:', emailContent); // Debugging: Output email content
                        $('#emailContent').html(emailContent);
                        $('#emailPopup').show();
                    })
                    .catch(error => {
                        console.error('Error fetching email content:', error); // Debugging: Output fetch error
                    });
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', error); // Debugging: Output AJAX error
                $('#message').html('An error occurred: ' + error);
            }
        });
    });

    // Peek mechanism for password fields
    $('.toggle-password').on('click', function() {
        // Toggle the type attribute of the password field
        let input = $(this).siblings('input');
        if (input.attr('type') === 'password') {
            input.attr('type', 'text');
            $(this).removeClass('fa-eye').addClass('fa-eye-slash');
        } else {
            input.attr('type', 'password');
            $(this).removeClass('fa-eye-slash').addClass('fa-eye');
        }
    });
});