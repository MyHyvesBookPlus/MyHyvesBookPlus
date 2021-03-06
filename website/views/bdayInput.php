<!--All the days-->
<select name="day_date" autocomplete="bday-day">
    <option>Dag</option>
    <?php
    for($i=1; $i<32; $i++) {
        $i = sprintf("%02d", $i);
        ?>
        <option value="<?= $i ?>" <?php submitselect($day_date, $i)?>><?= $i ?></option>
        <?php
    }
    ?>
</select>
<!--All the months-->
<select name="month_date" autocomplete="bday-month">
    <option>Maand</option>
    <option value="01" <?php submitselect($month_date, "01")?>>januari</option>
    <option value="02" <?php submitselect($month_date, "02")?>>februari</option>
    <option value="03" <?php submitselect($month_date, "03")?>>maart</option>
    <option value="04" <?php submitselect($month_date, "04")?>>april</option>
    <option value="05" <?php submitselect($month_date, "05")?>>mei</option>
    <option value="06" <?php submitselect($month_date, "06")?>>juni</option>
    <option value="07" <?php submitselect($month_date, "07")?>>juli</option>
    <option value="08" <?php submitselect($month_date, "08")?>>augustus</option>
    <option value="09" <?php submitselect($month_date, "09")?>>september</option>
    <option value="10" <?php submitselect($month_date, "10")?>>oktober</option>
    <option value="11" <?php submitselect($month_date, "11")?>>november</option>
    <option value="12" <?php submitselect($month_date, "12")?>>december</option>
</select>
<!--All the year from 1900 till current year-->
<select name="year_date" autocomplete="bday-year">
    <option>Jaar</option>
    <?php
    $year = (new DateTime)->format("Y");
    for($i=$year; $i >= 1900; $i--) {
        ?>
        <option value="<?= $i ?>" <?php submitselect($year_date, $i)?>><?= $i ?></option>
        <?php
    }
    ?>
</select>
