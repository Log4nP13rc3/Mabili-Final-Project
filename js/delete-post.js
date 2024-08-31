$(document).ready(function() {
    $('.delete-post').on('click', function() {
        const postId = $(this).data('post-id');
        
        if (confirm('Are you sure you want to delete this post?')) {
            $.ajax({
                url: 'ajax/delete-post.php',
                type: 'POST',
                data: { post_id: postId },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        alert('Post deleted successfully.');
                        // Remove the post tile from the DOM
                        $(`button[data-post-id="${postId}"]`).closest('.tile').remove();
                    } else {
                        alert('Failed to delete post: ' + response.message);
                    }
                },
                error: function() {
                    alert('An error occurred. Please try again.');
                }
            });
        }
    });
});