$(document).ready(function() {
    // Function to get the post_id from the URL
    function getPostIdFromUrl() {
        const urlParams = new URLSearchParams(window.location.search);
        return urlParams.get('post_id');
    }

    const postId = getPostIdFromUrl();

    function updateLikeButton(likeCount, liked) {
        $('#like-count').text(likeCount);
        $('#like-btn').toggleClass('liked', liked); // Toggle class based on whether it's liked
    }

    function fetchInitialLikeData() {
        $.ajax({
            url: 'ajax/like-handler.php',
            type: 'POST',
            dataType: 'json',
            data: { action: 'fetch_likes', post_id: postId },
            success: function(response) {
                if (response.status === 'success') {
                    updateLikeButton(response.like_count, response.liked);
                }
            }
        });
    }

    function toggleLike() {
        $.ajax({
            url: 'ajax/like-handler.php',
            type: 'POST',
            dataType: 'json',
            data: { action: 'toggle_like', post_id: postId },
            success: function(response) {
                if (response.status === 'success') {
                    updateLikeButton(response.like_count, response.liked);
                } else {
                    alert(response.message);
                }
            }
        });
    }

    $('#like-btn').click(function(event) {
        event.preventDefault();
        toggleLike();
    });

    // Fetch the initial like data when the page loads
    fetchInitialLikeData();
});