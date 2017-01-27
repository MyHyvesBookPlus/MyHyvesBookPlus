<?php
if ($pagetype == "user") {
    $pages = countSomeUsersByStatus($search, $status);
} else {
    $pages = countSomeGroupsByStatus($search, $groupstatus);
}
$countresults = $pages->fetchColumn();
$mincount = min($listm, $countresults);
$minlist = min($listn + 1, $countresults);
?>
    Pagina: <form class="admin-pageselector"
                  action="<?php htmlspecialchars(basename($_SERVER['REQUEST_URI'])) ?>"
                  method="post">
    <select class="admin-pageselect"
            name="pageselect"
            onchange="this.form.submit()"
            value="">
        <?php
        for ($i=1; $i <= ceil($countresults / $perpage); $i++) {
            if ($currentpage == $i) {
                echo "<option value='$i' selected>$i</option>";
            } else {
                echo "<option value='$i'>$i</option>";
            }
        }
        ?>
    </select>
</form>
<?php
echo "$minlist tot $mincount ($countresults totaal)";
?>