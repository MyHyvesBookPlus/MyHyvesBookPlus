<?php

session_start();

require_once ("../../queries/connect.php");
require_once ("../../queries/private_message.php");

echo selectAllUnreadChat();