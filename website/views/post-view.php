<?php
$postID = $_GET['postID'];
$post = selectPostById($postID)->fetch(PDO::FETCH_ASSOC);
$fullname = $post['fname'] . " " . $post['lname'] . " (" . $post['username'] . ")";
?>
<div class='post-header header'>
    <h4><?=$post['title']?></h4>
    <span class='postinfo'>
        gepost door <?=$fullname?>,
            <span class='posttime' title='<?=$post['creationdate']?>'>
                <?=nicetime($post['creationdate'])?>
            </span>
    </span>
</div>
<?php if (checkPermissionOnPost($postID, $_SESSION["userID"])) {?>
    <button class="deleteButton fancy-button"
            onclick="deletePost('<?=$postID?>')"
            type="submit">
        <span>Verwijder post</span>
        <i class="fa fa-trash"></i>
    </button><br />
<?php } ?>
<div class='post-content'>
    <p><?=$post['content']?></p>
</div>

<div class='post-comments'>
    <div class="commentfield">
        <form id="newcommentform" onsubmit="return false;">
            <input type="hidden" id="newcomment-textarea" name="postID" value="<?= $postID ?>">
            <textarea id="newcomment" name="newcomment-content" placeholder="Laat een reactie achter..." maxlength="1000"></textarea><span></span> <br>
            <button onclick="postComment('reaction')" name="button" value="reaction" class="green"><i class="fa fa-comment"></i> Reageer!</button>
            <button onclick="postComment('nietslecht')" name="button" value="nietslecht" class="nietslecht">
            <?php
            if (checkNietSlecht($postID, $_SESSION["userID"])) {
                echo 'Trek <span class="nietslecht-text">"Niet slecht."</span> terug';
            } else {
                echo '<img src="img/nietslecht_small.png" /> <span class="nietslecht-text">"Niet slecht."</span>';
            }
            ?>
            </button>
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
                <span class='commentdate' title='$commentdate'>
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