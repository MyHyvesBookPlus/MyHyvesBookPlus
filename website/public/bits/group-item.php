<?php

session_start();

include_once ("../../queries/group_member.php");

$groups = json_decode($_POST["groups"]);

foreach($groups as $i => $group) {
    ?>
    <li class='group-item'>
        <form action='group.php' method='get'>
            <button type='submit'
                    name='groupname'
                    value='<?= $group->name ?>'>
                <div class='group'>
                    <img alt='PF' class='group-picture' src='<?= $group->picture ?>'/>
                    <?= $group->name ?>
                </div>
            </button>
        </form>
    </li>
    <?php
}
    ?>
    <li>
        <form action="search.php" method="get">
            <input type="hidden"
                   name="search"
                   value="" />
            <input type="hidden"
                   name="filter"
                   value="groups" />
            <button type="submit">
                Alle groepen...
            </button>
        </form>
    </li>
