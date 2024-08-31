$(document).ready(function() {
    // Define the decodeHtml function
    function decodeHtml(html) {
        var txt = document.createElement("textarea");
        txt.innerHTML = html;
        return txt.value;
    }

    // Fetch posts via AJAX
    $.ajax({
        url: 'ajax/investigations.php', 
        method: 'GET',
        dataType: 'json',
        success: function(data) {
            if (data.error) {
                console.error('Error fetching posts:', data.error);
            } else {
                var feed = $('#feed');
                feed.empty(); // Clear existing content
                $.each(data, function(index, post) {
                    // Create a tile div
                    var tile = $('<div class="tile"></div>');
                    
                    // Create the link element
                    var link = $('<a></a>').attr('href', 'post-detail-view.php?post_id=' + decodeHtml(post.post_id));
                
                    // Construct the correct image path by ensuring it's pointing to the 'uploads' folder
                    var imageUrl = 'uploads/' + decodeHtml(post.image_url);
                    var image = $('<img>').attr('src', imageUrl).attr('alt', decodeHtml(post.title));
                
                    // Handle special characters correctly in the title
                    var title = $('<h3></h3>').html(decodeHtml(post.title));
                
                    // Append the image and title to the link element
                    link.append(image).append(title);
                    
                    // Append the link to the tile div
                    tile.append(link);
                    
                    // Append the tile to the feed container
                    feed.append(tile);
                });
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.error('AJAX Error:', textStatus, errorThrown);
        }
    });
});
