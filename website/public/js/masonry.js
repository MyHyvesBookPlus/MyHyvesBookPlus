margin = 20;

$(window).on("load", function() {
    console.log("LOADED");
    container = $("div.posts");
    posts = container.children();
    posts.remove();

    column = $('<div class="column"></div>').append(posts);
    container.append(column);

    mansonry();
    mansonry();
});

$(window).resize(function() {
    clearTimeout(window.resizedFinished);
    window.resizeFinished = setTimeout(function() {
        mansonry();
    }, 250);
});

function mansonry() {

    columnCount = Math.floor($(".posts").width() / 250);
    console.log("columns: " + columnCount);

    /*
     * Initialise columns.
     */
    var columns = new Array(columnCount);
    for (i = 0; i < columnCount; i++) {
        columns[i] = [0, []];
        console.log(columns[i]);
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
     * Rearange the objects.
     */
    j = 0;
    posts.each(function(i) {
        post = posts[i];
        shortestColumn = getShortestColumn(columns);
        shortestColumn[0] = shortestColumn[0] + $(post).height() + margin;
        shortestColumn[1].push(post);

    });
    
    container.children().remove();
    /*
     * Display the objects again in the correct order.
     */
    for (i = 0; i < columnCount; i++) {
        column = $('<div class="column"></div>').append(columns[i][1]);
        console.log(column);
        container.append(column);

    }

    $("div.posts div.column").width(100/columnCount + "%");

    $(".post").click(function () {
        $(".modal").show();
    });

    $(".modal-close").click(function () {
        $(".modal").hide();
    });
}