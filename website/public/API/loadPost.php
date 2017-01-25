<?php

require_once("../../queries/connect.php");
require_once("../../queries/post.php");
require_once("../../queries/checkInput.php");
require_once("../../queries/nicetime.php");

if(isset($_GET['postID'])) {
    $postID = $_GET['postID'];
    $post = selectPostById($postID)->fetch(PDO::FETCH_ASSOC);
    $fullname = $post['fname'] . " " . $post['lname'] . " (" . $post['username'] . ")";

echo "
<div class='post-header'>
    <h4>" . $post['title'] . "</h4>
    <span class='postinfo'>
        gepost door $fullname,
            <span class='posttime' title='" . $post['creationdate'] . "'>
                " . nicetime($post['creationdate']) . "
            </span>
    </span>
</div>

<div class='post-content'>
    <p>" . $post['content'] . "</p>
</div>

<div class='post-comments'>
    <div class=\"commentfield\">
        <form name=\"newcomment\" method=\"post\">
            <textarea>Vul in</textarea> <br>
            <input type=\"submit\" value=\"Reageer\">
        </form>
    </div>";

    $q = selectCommentsByPostId($postID);
    while($comment = $q->fetch(PDO::FETCH_ASSOC)) {
        $commentauthor = $comment['fname'] . " " . $comment['lname'] . " (" . $comment['username'] . ")";
        $commentdate = $comment['creationdate'];
        $commentnicetime = nicetime($commentdate);
        $commentcontent = $comment['content'];

        echo("
                <div class='comment'>
                    <div class='commentinfo'>
                        $commentauthor
                            <span class='commentdate', title='$commentdate'>
                                $commentnicetime
                            </span>
                    </div>
                    <div class='commentcontent'>
                        $commentcontent
                    </div>
                </div>
            ");
    }
echo "</div>";

} else {
    echo "Failed to load";
}