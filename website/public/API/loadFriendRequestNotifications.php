<?php

session_start();

require_once ("../../queries/connect.php");
require_once ("../../queries/friendship.php");

echo selectAllFriendRequests();