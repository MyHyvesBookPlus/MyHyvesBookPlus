<html>
<head>
</head>
<body>
<?php

include_once("../queries/connect.php");
include_once("../queries/friendship.php");

$friends = selectAllFriends(666);
while($friend = $friends->fetch(PDO::FETCH_ASSOC)) {
    echo $friend['username'].' '.$friend['onlinestatus'] . "<br />";
}

?>
</body>
</html>