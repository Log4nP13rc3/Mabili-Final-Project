$(document).ready(function() {
    function getPostIdFromUrl() {
        const urlParams = new URLSearchParams(window.location.search);
        return urlParams.get('post_id');
    }

    const postId = getPostIdFromUrl();

    function loadComments() {
        $.ajax({
            url: 'ajax/comments-handler.php',
            type: 'POST',
            data: { action: 'fetch_comments', post_id: postId },
            success: function(response) {
                $('#comments-list').html(response);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error("AJAX Error: ", textStatus, errorThrown);
            }
        });
    }

    function postComment() {
        const content = $('#comment-input').val();
        if (content.trim() === '') {
            alert('Comment cannot be empty.');
            return;
        }

        $.ajax({
            url: 'ajax/comments-handler.php',
            type: 'POST',
            data: { action: 'post_comment', post_id: postId, content: content },
            success: function(response) {
                if (response === 'Comment posted successfully.') {
                    $('#comment-input').val('');
                    loadComments();
                } else {
                    alert(response);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error("AJAX Error: ", textStatus, errorThrown);
            }
        });
    }

    function deleteComment(commentId) {
        $.ajax({
            url: 'ajax/comments-handler.php',
            type: 'POST',
            data: { action: 'delete_comment', comment_id: commentId },
            success: function(response) {
                if (response === 'Comment deleted successfully.') {
                    loadComments();
                } else {
                    alert(response);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error("AJAX Error: ", textStatus, errorThrown);
            }
        });
    }

    $('#comment-submit').click(function(event) {
        event.preventDefault();
        postComment();
    });

    $(document).on('click', '.delete-comment-btn', function() {
        const commentId = $(this).data('comment-id');
        if (confirm('Are you sure you want to delete this comment?')) {
            deleteComment(commentId);
        }
    });

    // Load comments on page load
    loadComments();
});