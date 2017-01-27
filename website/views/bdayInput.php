<select name="day_date" >
    <option>dag</option>
    <?php
    for($i=1; $i<32; $i++) {
        $i = sprintf("%02d", $i);
        ?>
        <option value="<?= $i ?>" <?php submitselect($day_date, $i)?>><?= $i ?></option>
        <?php
    }
    ?>
</select>
<select name="month_date">
    <option>Maand</option>
    <option value="01" <?php submitselect($month_date, "01")?>>Januari</option>
    <option value="02" <?php submitselect($month_date, "02")?>>Februari</option>
    <option value="03" <?php submitselect($month_date, "03")?>>Maart</option>
    <option value="04" <?php submitselect($month_date, "04")?>>April</option>
    <option value="05" <?php submitselect($month_date, "05")?>>Mei</option>
    <option value="06" <?php submitselect($month_date, "06")?>>Juni</option>
    <option value="07" <?php submitselect($month_date, "07")?>>Juli</option>
    <option value="08" <?php submitselect($month_date, "08")?>>Augustus</option>
    <option value="09" <?php submitselect($month_date, "09")?>>September</option>
    <option value="10" <?php submitselect($month_date, "10")?>>Oktober</option>
    <option value="11" <?php submitselect($month_date, "11")?>>November</option>
    <option value="12" <?php submitselect($month_date, "12")?>>December</option>
</select>
<select name="year_date">
    <option>Jaar</option>
    <?php
    $year = (new DateTime)->format("Y");
    for($i=$year; $i > $year - 100; $i--) {
        ?>
        <option value="<?= $i ?>" <?php submitselect($year_date, $i)?>><?= $i ?></option>
        <?php
    }
    ?>
</select>
