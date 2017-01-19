<?php

function select20UsersFromN($db, $n) {
    return $db->query("
    SELECT
        `userID`,
        `username`,
        `role`,
        `bancomment`
    FROM
        `user`
    ORDER BY
        `role`,
        `username`
    LIMIT
        $n, 20
    ");
}

function search20UsersFromN($db, $n, $keyword) {
    $q = $db->prepare("
    SELECT
        `userID`,
        `username`,
        `role`,
        `bancomment`
    FROM
        `user`
    WHERE
        `username` LIKE :keyword
    ORDER BY
        `username`
    LIMIT
        :n, 20
    ");

    $keyword = "%$keyword%";
    $q->bindParam(':keyword', $keyword);
    $q->bindParam(':n', $n, PDO::PARAM_INT);
    $q->execute();
    return $q;
}

function search20UsersFromNByStatus($db, $n, $keyword, $status) {
    $q = $db->prepare("
    SELECT
        `userID`,
        `username`,
        `role`,
        `bancomment`
    FROM
        `user`
    WHERE
        `username` LIKE :keyword AND
        FIND_IN_SET (`role`, :statuses)
    ORDER BY
        `role`,
        `username`
    LIMIT
        :n, 20
    ");

    $keyword = "%$keyword%";
    $q->bindParam(':keyword', $keyword);
    $q->bindParam(':n', $n, PDO::PARAM_INT);
    $statuses = implode(',', $status);
    $q->bindParam(':statuses', $statuses);
    $q->execute();
    return $q;
}

function changeUserStatusByID($db, $id, $status) {
    $q = $db->query("
    UPDATE
        `user`
    SET
        `role` = $status
    WHERE
        `userID` = $id
    ");

    return $q;
}

function changeMultipleUserStatusByID($db, $ids, $status) {
    $q = $db->prepare("
    UPDATE
        `user`
    SET
        `role` = :status
    WHERE
        FIND_IN_SET (`userID`, :ids)
    ");

    $ids = implode(',', $ids);
    $q->bindParam(':ids', $ids);
    $q->bindParam(':status', $status);
    $q->execute();
    return $q;
}

?>
