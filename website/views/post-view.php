<?php
$postID = $_GET['postID'];
$post = selectPostById($postID)->fetch(PDO::FETCH_ASSOC);
$fullname = $post['fname'] . " " . $post['lname'] . " (" . $post['username'] . ")";

echo("
<div class='post-header header'>
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
"); ?>

<div class='post-comments'>
    <div class="commentfield">
        <form action="API/postComment.php" name="newcomment" method="post">
            <input type="hidden" name="postID" value="<?= $postID ?>">
            <textarea name="newcomment-content" Laat een reactie achter..."></textarea> <br>
            <input type="submit" value="Reageer!">
        </form>
    </div>

    <?php
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
    } ?>
</div>