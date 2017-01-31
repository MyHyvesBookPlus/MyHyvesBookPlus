<?php

/**
 * Uploads Avatar, checks it, and removes the old one.
 * @param bool $group
 * @throws AngryAlert
 * @throws HappyAlert
 */
function updateAvatar(bool $group = false) {
    $publicDir = "/var/www/html/public/";
    $tmpImg = $_FILES["pp"]["tmp_name"];
    $avatarDir = $group ? "uploads/groupavatar/" : "uploads/profilepictures/";
    checkAvatarSize($tmpImg);
    
    if (getimagesize($tmpImg)["mime"] == "image/gif") {
        if ($_FILES["pp"]["size"] > 4000000) {
            throw new AngryAlert("Bestand is te groot, maximaal 4MB toegestaan.");
        }
        $relativePath = $avatarDir . $_SESSION["userID"] . "_avatar.gif";
        $group ? removeOldGroupAvatar($_POST["groupID"]) : removeOldUserAvatar();
        move_uploaded_file($tmpImg, $publicDir . $relativePath);
    } else {
        $relativePath = $avatarDir . $_SESSION["userID"] . "_avatar.png";
        $scaledImg = scalePicture($tmpImg);
        $group ? removeOldGroupAvatar($_POST["groupID"]) : removeOldUserAvatar();
        imagepng($scaledImg, $publicDir . $relativePath);
    }

    $group ? setGroupAvatarToDatabase("../" . $relativePath, $_POST["groupID"]) : setUserAvatarToDatabase("../" . $relativePath);
    throw new HappyAlert("Profielfoto veranderd.");
}

function uploadPostPicture($userID) {
    $publicDir = "/var/www/html/public/";
    $tmpImg = $_FILES["picture"]["tmp_name"];
    $photoDir = "uploads/post/";
    if (getimagesize($tmpImg)["mime"] == "image/gif") {
        if ($_FILES["picture"]["size"] > 4000000) {
            throw new AngryAlert("Bestand is te groot, maximaal 4MB toegestaan.");
        }
        $relativePath = $photoDir . date_format(new DateTime(), "YmdHis") . "_" . $userID . ".gif";
        move_uploaded_file($tmpImg, $publicDir . $relativePath);
    } else {
        $relativePath = $photoDir . date_format(new DateTime(), "YmdHis") . "_" . $userID . ".png";
        $scaledImg = scalePicture($tmpImg);
        imagepng($scaledImg, $publicDir . $relativePath);
    }
    return $relativePath;
}

/**
 * Removes the old avatar from the uploads folder, for a user.
 */
function removeOldUserAvatar() {
    $stmt = prepareQuery("
    SELECT
        `profilepicture`
    FROM 
        `user`
    WHERE 
        `userID` = :userID
    ");
    $stmt->bindParam(":userID", $_SESSION["userID"]);
    $stmt->execute();
    $old_avatar = $stmt->fetch()["profilepicture"];
    if ($old_avatar != NULL) {
        unlink("/var/www/html/public/uploads/" . $old_avatar);
    }
}
/**
 * Removes the old avatar from the uploads folder, for a group.
 * @param int $groupID
 */
function removeOldGroupAvatar(int $groupID) {
    $stmt = prepareQuery("
    SELECT
        `picture`
    FROM
        `group_page`
    WHERE 
        groupID = :groupID
    ");
    $stmt->bindParam(":groupID", $groupID);
    $stmt->execute();
    $old_avatar = $stmt->fetch()["picture"];
    if ($old_avatar != NULL) {
        unlink("/var/www/html/public/uploads/" . $old_avatar);
    }
}

/**
 * Inserts the the path to the avatar into the database, for Users.
 * @param string $url path to the avatar
 */
function setUserAvatarToDatabase(string $url) {
    $stmt = prepareQuery("
    UPDATE
        `user`
    SET
        `profilepicture` = :avatar
    WHERE
        `userID` = :userID
    ");

    $stmt->bindParam(":avatar", $url);
    $stmt->bindParam(":userID", $_SESSION["userID"]);
    $stmt->execute();
}

/**
 * Inserts the the path to the avatar into the database, for Groups.
 * @param string $url path to the avatar
 * @param int $groupID
 */
function setGroupAvatarToDatabase(string $url, int $groupID) {
    $stmt = prepareQuery("
    UPDATE
        `group_page`
    SET
        `picture` = :avatar
    WHERE
        `groupID` = :groupID
    ");
    $stmt->bindParam(":avatar", $url);
    $stmt->bindParam(":groupID", $groupID);
    $stmt->execute();
}

/**
 * Checks the resoluton of a picture.
 * @param string $img
 * @throws AngryAlert
 */
function checkAvatarSize(string $img) {
    $minResolution = 200;
    $imgSize = getimagesize($img);
    if ($imgSize[0] < $minResolution or $imgSize[1] < $minResolution) {
        throw new AngryAlert("Afbeelding te klein, minimaal 200x200 pixels.");
    }
}

/**
 * Scales a picture, standard width is 600px.
 * @param string $imgLink Path to a image file
 * @param int $newWidth Custom image width.
 * @return bool|resource Returns the image as an Resource.
 * @throws AngryAlert
 */
function scalePicture(string $imgLink, int $newWidth = 600) {
    $img = imagecreatefromstring(file_get_contents($imgLink));
    if ($img) {
        return imagescale($img, $newWidth);
    } else {
        throw new AngryAlert("Afbeelding wordt niet ondersteund.");
    }
}