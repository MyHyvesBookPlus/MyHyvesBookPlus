<?php
if ($pagetype == "user") {
    $pages = countSomeUsersByStatus($search, $status);
} else {
    $pages = countSomeGroupsByStatus($search, $groupstatus);
}
$countresults = $pages->fetchColumn();

?>
Pagina:
<select class="admin-pageselect"
        name="currentpage"
        id="currentpage"
        form="admin-searchform"
        onchange="adminSearch();">
    <?php
    for ($i=1; $i <= ceil($countresults / $entries); $i++) {
        if ($currentpage == $i) {
            echo "<option value='$i' selected>$i</option>";
        } else {
            echo "<option value='$i'>$i</option>";
        }
    }
    ?>
</select>
<?php
$n = min($offset + 1, $countresults);
$m = min($offset + $entries, $countresults);
echo " $n tot $m ($countresults totaal)";
?>