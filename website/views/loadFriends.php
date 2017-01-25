<?php

echo json_encode(selectAllFriends($_SESSION["userID"])->fetchAll());