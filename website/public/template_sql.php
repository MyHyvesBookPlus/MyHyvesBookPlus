<html>
<head>
</head>
<body>
<?php

// database gegevens zijn elders opgeslagen
include_once("../queries/connect.php");
include_once("../queries/friendship.php");

$friends = selectAllFriends($db, 666);
while($friend = $friends->fetch(PDO::FETCH_ASSOC)) {
    echo $friend['username'].' '.$friend['onlinestatus'] . "<br />";
}

?>
</body>
</html>