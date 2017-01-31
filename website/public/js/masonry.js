margin = 20;

// scrolling modal taken from http://stackoverflow.com/questions/10476632/how-to-scroll-the-page-when-a-modal-dialog-is-longer-than-the-screen
function scrollbarMargin(width, overflow) {
    $('body').css({
        marginRight: width,
        overflow: overflow
    });
    $('.profile-menu').css({
        marginRight: width
    });
}

function requestPost(postID) {
    $(".modal").show();

    $.get("API/loadPost.php", { postID : postID }).done(function(data) {
        $('.modal-default').hide();
        var scrollBarWidth = window.innerWidth - document.body.offsetWidth;
        scrollbarMargin(scrollBarWidth, 'hidden');
        $('#modal-response').show();
        $('#modal-response').html(data);
    });
}

function postPost() {
    title = $("input.newpost[name='title']").val();
    content = $("textarea.newpost[name='content']").val();

    if (masonryMode == 2) {
        $.post("API/postPost.php", { title: title,
                                     content : content,
                                     group : groupID })
            .done(function() {
                masonry(masonryMode);
            });
    } else {
        $.post("API/postPost.php", { title: title,
                                     content : content })
            .done(function() {
                masonry(masonryMode);
            });
    }


}

$(window).on("load", function() {
    $(".modal-close").click(function () {
        $(".modal").hide();
        scrollbarMargin(0, 'auto');
        $('#modal-response').hide();
        $('.modal-default').show();
    });
});

var masonryMode = 0;
var windowWidth = $(window).width();

$(window).resize(function() {
    clearTimeout(window.resizedFinished);
    window.resizeFinished = setTimeout(function() {
        if ($(window).width() != windowWidth) {
            windowWidth = $(window).width();
            masonry(masonryMode);
        }
    }, 250);
});

var $container = $(".posts");

function masonry(mode) {
    masonryMode = mode;
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

    if(mode > 0) {
        $postInput = $("<div class=\"post platform\">");
        $form = $("<form class=\"newpost\" action=\"API/postPost.php\" method=\"post\" onsubmit=\"postPost(); return false;\">");
        $postInput.append($form);

        if(mode == 2) {
            $form.append($("<input class=\"newpost\" type=\"hidden\" name=\"group\" value=\"" + groupID + "\">"));
        }

        $form.append($("<input class=\"newpost\" name=\"title\" placeholder=\"Titel\" type=\"text\">"));
        $form.append($("<textarea class=\"newpost\" name=\"content\" placeholder=\"Schrijf een berichtje...\">"));
        $form.append($("<input value=\"Plaats!\" type=\"submit\">"));
        columns[0][1].append($postInput);

        columns[0][0] = $postInput.height() + margin;
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
    $.post("API/getPosts.php", { usr : userID, grp : groupID })
           .done(function(data) {
               posts = JSON.parse(data);

               /*
                * Rearange the objects.
                */
               $.each(posts, function() {
                   $post = $("<div class=\"post platform\" onclick=\"requestPost(\'"+this['postID']+"\')\">");
                   $post.append($("<h2>").html(this["title"]));
                   $post.append($("<p>").html(this["content"]));
                   $post.append($("<p class=\"subscript\">").text(this["nicetime"]));
                   $post.append($("<p class=\"subscript\">").text("comments: " + this["comments"] + ", niet slechts: " + this["niet_slechts"]));

                   shortestColumn = getShortestColumn(columns);
                   shortestColumn[1].append($post);
                   shortestColumn[0] = shortestColumn[0] + $post.height() + margin;
               });
           });
}

