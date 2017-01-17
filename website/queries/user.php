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

?>
