<?php

function selectSomeUsers($db, $n) {
    return $db->query("
    SELECT
        `userID`,
        `username`,
        `role`,
        `bancomment`
    FROM
        `user`
    ORDER BY
        `username`
    LIMIT
        $n
    ");
}

?>
