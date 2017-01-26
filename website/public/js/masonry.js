margin = 20;

$(window).resize(function() {
    clearTimeout(window.resizedFinished);
    window.resizeFinished = setTimeout(function() {
        masonry();
    }, 250);
});

var $container = $(".posts");

function masonry() {
    $container.children().remove();
    columnCount = Math.floor($(".posts").width() / 250);

    /*
     * Initialise columns.
     */
    var columns = new Array(columnCount);
    var $columns = new Array(columnCount);
    for (i = 0; i < columnCount; i++) {
        $column = $("<div class=\"column\">");
        $column.width(100/columnCount + "%");
        $container.append($column);
        columns[i] = [0, $column];
    }

    /*
     * Function will find the column with the shortest height.
     */
    function getShortestColumn(columns) {
        column = columns[0];

        for (i = 1; i < columnCount; i++) {
            if (column[0] > columns[i][0]) {
                column = columns[i];
            }
        }
        return column;
    }

    /*
     * Get the posts from the server.
     */
    $.post("API/getPosts.php", { usr : userID })
           .done(function(data) {
               posts = JSON.parse(data);

               /*
                * Rearange the objects.
                */
               jQuery.each(posts, function() {
                   $post = $("<div class=\"post platform\" onclick=\"requestPost(this)\">");
                   $post.append($("<h2>").text(this["title"]));
                   $post.append($("<p>").html(this["content"]));

                   shortestColumn = getShortestColumn(columns);
                   shortestColumn[1].append($post);
                   shortestColumn[0] = shortestColumn[0] + $post.height() + margin;
               });
           });
}
