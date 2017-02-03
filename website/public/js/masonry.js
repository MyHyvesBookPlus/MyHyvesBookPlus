// Vertical margin between two posts.
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

// Get post from the server.
function requestPost(postID) {
    // Make the modal view visible.
    $(".modal").show();

    // Send get request to the server to load the post.
    $.get("API/loadPost.php", { postID : postID }).done(function(data) {
        $('.modal-default').hide();
        var scrollBarWidth = window.innerWidth - document.body.offsetWidth;
        scrollbarMargin(scrollBarWidth, 'hidden');
        $('#modal-response').show();
        $('#modal-response').html(fancyText(data));
    });
}

// Create a new post.
function postPost() {
    title = $("input.newpost[name='title']").val();
    content = $("textarea.newpost[name='content']").val();

    // Masonrymode 2: when on group page and user is an admin.
    if (masonryMode == 2) {
        // Create the new group post.
        $.post("API/postPost.php", { title: title,
                                     content : content,
                                     group : groupID })
            .done(function(data) {
                if (data == "empty") {
                    $('#alertbox').show();
                    $('#alerttext').html("Geen titel of inhoud; vul a.u.b. in.");
                    window.scrollTo(0,0);
                } else if (data == "logged out") {
                    window.location.href = "login.php?url=" + window.location.pathname;
                } else if (data == "frozen") {
                    alert("Je account is bevroren, dus je kan geen posts plaatsen. Contacteer een admin als je denkt dat dit onjuist is.");
                } else {
                    $('#alertbox').hide();
                    masonry(masonryMode);
                }
            });
    } else {
        // Create the new user post.
        $.post("API/postPost.php", { title: title,
                                     content : content })
            .done(function(data) {
                if (data == "empty") {
                    $('#alertbox').show();
                    $('#alerttext').html("Geen titel of inhoud; vul a.u.b. in.");
                    window.scrollTo(0,0);
                } else if (data == "logged out") {
                    window.location.href = "login.php?url=" + window.location.pathname;
                } else if (data == "frozen") {
                    alert("Je account is bevroren, dus je kan geen posts plaatsen. Contacteer een admin als je denkt dat dit onjuist is.");
                } else {
                    $('#alertbox').hide();
                    masonry(masonryMode);
                }
            });
    }


}

var masonryMode = 0;
var windowWidth;
var columnCount;
var columns;
var postLimit;
var postAmount = 0;
var noposts = false;

$(document).ready(function () {
    // Initialise variables for masonry.
    windowWidth = $(window).width();
    columnCount = Math.floor($(".posts").width() / 250);
    columns = new Array(columnCount);
    postLimit = columnCount * 7;
});

$(window).on("load", function() {
    $(".modal-close").click(function (){closeModal()});

    // http://stackoverflow.com/questions/9439725/javascript-how-to-detect-if-browser-window-is-scrolled-to-bottom
    // Infinite scroll.
    window.onscroll = function(ev) {
        if($(window).scrollTop() + $(window).height() == $(document).height() ) {
            loadMorePosts(userID, groupID, postAmount, postLimit);
        }
    };

    $(document).keyup(function(e) {
        if (e.keyCode == 27) {
            closeModal();
        }
    });

    $('.modal').click(function() {
        closeModal();
    });

    $('.modal-content').click(function(event){
        event.stopPropagation();
    });

});

// Hide modal view from the screen.
function closeModal() {
    $(".modal").hide();
    scrollbarMargin(0, 'auto');
    $('#modal-response').hide();
    $('.modal-default').show();
}

// Will fire when user resizes the window.
$(window).resize(function() {
    clearTimeout(window.resizedFinished);
    window.resizeFinished = setTimeout(function() {
        // Check if the width of the screen changed.
        if ($(window).width() != windowWidth) {
            // Save width.
            windowWidth = $(window).width();
            // Check if there fit more or less columns in the new width.
            if (columnCount != Math.floor($(".posts").width() / 250)) {
                columnCount = Math.floor($(".posts").width() / 250);
                // Respawn the masonry grid.
                masonry(masonryMode);
            }
        }
    }, 250);
});

// Select the container for masonry.
var $container = $(".posts");

// Spawn the masonry grid.
function masonry(mode) {
    // save the masonry mode.
    masonryMode = mode;
    $container.children().remove();

    // reinit posts
    noposts = false;
    postAmount = 0;

    // Initialise columns.
    for (i = 0; i < columnCount; i++) {
        $column = $("<div class=\"column\">");
        $column.width(100/columnCount + "%");
        $container.append($column);
        columns[i] = [0, $column];
    }

    // Place the form for new posts.
    if(mode > 0) {
        $postInput = $("<div class=\"post platform\">");
        $form = $("<form class=\"newpost\" action=\"API/postPost.php\" method=\"post\" onsubmit=\"postPost(); return false;\">");
        $postInput.append($form);

        //Add extra input for group posts.
        if(mode == 2) {
            $form.append($("<input class=\"newpost\" type=\"hidden\" name=\"group\" value=\"" + groupID + "\">"));
        }

        $form.append($("<input class=\"newpost\" name=\"title\" placeholder=\"Titel\" type=\"text\">"));
        $form.append($("<textarea class=\"newpost\" name=\"content\" placeholder=\"Schrijf een berichtje...\" maxlength='1000'></textarea><span></span>"));
        $form.append($("<button type=\"submit\"><i class='fa fa-sticky-note-o'></i> Plaats!</button>"));
        columns[0][1].append($postInput);

        columns[0][0] = $postInput.height() + margin;
    }

    // Get the posts from the server.
    loadMorePosts(userID, groupID, 0, postLimit);
}

// Find the column with the shortest hight.
function getShortestColumn(columns) {
    column = columns[0];

    for (i = 1; i < columnCount; i++) {
        if (column[0] > columns[i][0]) {
            column = columns[i];
        }
    }
    return column;
}

// Load certain range of posts.
function loadMorePosts(uID, gID, offset, limit) {
    if (noposts) {
        return;
    }

    // Get a list of posts from the server.
    $.post("API/getPosts.php", { usr : uID,
                                 grp : gID,
                                 offset : offset,
                                 limit : limit})
        .done(function(data) {
            if (!data) {
                // No posts were found, show noposts bar to user.
                $('.noposts').show();
                noposts = true;
                return;
            }

            posts = JSON.parse(data);

             // Rearange the objects.
            $.each(posts, function() {
                $post = $("<div class=\"post platform\" onclick=\"requestPost(\'"+this['postID']+"\')\">");
                $post.append($("<h2>").html(this["title"]));
                $post.append($("<p>").html(fancyText(this["content"])));
                $post.append($("<p class=\"subscript\">").text(this["nicetime"]));
                $post.append($("<p class=\"subscript\">").text("comments: " + this["comments"] + ", niet slechts: " + this["niet_slechts"]));

                shortestColumn = getShortestColumn(columns);
                shortestColumn[1].append($post);
                shortestColumn[0] = shortestColumn[0] + $post.height() + margin;
            });
        });

    postAmount += limit;
}