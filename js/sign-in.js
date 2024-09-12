$(document).ready(function() {
    $('#sign-in-button').click(function(event) {
        event.preventDefault();

        //collecting user data from the form fields
        let userData = {
            email: $('#email').val(),
            password: $('#password').val(),
            honeypot: $('#honeypot').val()
        };

        //then sending ajax request to server
        $.ajax({
            url: 'ajax/sign-in.php',
            type: 'POST',
            data: userData,
            dataType : 'json',
            success: function(response) {
                if (response.errors) {
                    //display the server's validation errors
                    let errorHtml = '<ul class="error-message">';
                    response.errors.forEach(function(error) {
                        errorHtml += '<li>' + error + '</li>';
                    });
                    errorHtml += '</ul>';
                    $('#message').html(errorHtml);
                } else if (response.success) {
                    //redirect to dashboard
                    window.location.href = response.redirect;
                }
            },
            error: function(xhr, status, error) {
                //if error then display error instead
                $('#message').html('An error occurred: ' + error);
            }
        });
    });

    //peek mechanism for password fields
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