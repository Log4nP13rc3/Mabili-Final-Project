$(document).ready(function() {
    $('#sign-up-button').click(function(event) {
        event.preventDefault();

        //collecting user data from the form fields
        let userData = {
            username: $('#username').val(),
            email: $('#email').val(),
            password: $('#password').val(),
            confirmPassword: $('#confirm-password').val()
        };

        //then sending ajax request to server
        $.ajax({
            url: 'ajax/sign-up.php',
            type: 'POST',
            data: userData,
            success: function(response) {
                //if the request works then display the server's response in the message div
                $('#message').html(response);
            },
            error: function(xhr, status, error) {
                //if error then display error instead
                $('#message').html('An error occurred: ' + error);
            }
        });
    });
});