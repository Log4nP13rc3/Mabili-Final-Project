$(document).ready(function() {
    $('#sign-in-button').click(function(event) {
        event.preventDefault();

        //collecting user data from the form fields
        let userData = {
            email: $('#email').val(),
            password: $('#password').val(),
        };

        //then sending ajax request to server
        $.ajax({
            url: 'ajax/sign-in.php',
            type: 'POST',
            data: userData,
            success: function(response) {
                //display the server's response in the message div
                $('#message').html(response);
            },
            error: function(xhr, status, error) {
                //if error then display error instead
                $('#message').html('An error occurred: ' + error);
            }
        });
    });
});