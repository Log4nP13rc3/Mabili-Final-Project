//Finalised
$(document).ready(function() {
    // Initialize CKEditor for the content field
    CKEDITOR.replace('content');

    // Image preview
    $('#image').on('change', function() {
        let file = this.files[0];
        if (file) {
            let reader = new FileReader();
            reader.onload = function(e) {
                $('#image-preview').html('<img src="' + e.target.result + '" width="200" />');
            };
            reader.readAsDataURL(file);
        }
    });

    // Character count for title
    $('#title').on('input', function() {
        $('#title-count').text($(this).val().length + '/100');
    });

    // Character count for content (using CKEditor)
    CKEDITOR.instances['content'].on('change', function() {
        let content = CKEDITOR.instances['content'].getData();
        let text = $(content).text(); // Get plain text
        $('#content-count').text(text.length + '/1000');
    });

    // Form submission with AJAX
    $('#create-post-form').submit(function(event) {
        event.preventDefault();

        let formData = new FormData(this);
        formData.append('draft', $('#save-draft').is(':checked'));

        $.ajax({
            url: 'ajax/create-post.php',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function(response) {
                if (response.errors) {
                    // Display errors
                    let errorHtml = '<ul class="error-message">';
                    response.errors.forEach(function(error) {
                        errorHtml += '<li>' + error + '</li>';
                    });
                    errorHtml += '</ul>';
                    $('#message').html(errorHtml);
                } else if (response.success) {
                    // Show success message
                    $('#message').html('<p class="success-message">' + response.message + '</p>');
                    
                    // Redirect to dashboard after 0 seconds
                    setTimeout(function() {
                        window.location.href = 'dashboard.php';
                    }, 0);
                }
            },
            error: function(xhr, status, error) {
                $('#message').html('An error occurred: ' + error);
            }
        });
    });
});