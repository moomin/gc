<div id="geocache">
<?php
    $html = $Site->html;
    $txt = $Site->text;

    if ($edit)
    {
        $edit = true;
        echo '<form method="post" name="cache" action="'.$Site->getUrl('Cache', 'submit').'">'."\n";
        echo $html->getTag('label', $txt->cacheTitle, array('for' => 'cacheTitle'));
        echo $html->getTag('input', '', array('type' => 'text', 'name' => 'title', 'id' => 'cacheTitle'))."<br>\n";

        echo $html->getTag('label', $txt->latitude, array('for' => 'cacheLatitude'));
        echo '<select name="latitudeSign"><option value="+">N</option><option value="-">S</option></select>';
        echo '<input type="text" name="latitudeDegree" size="2" maxlength="2">&deg;';
        echo '<input type="text" name="latitideMinutes" size="2" maxlength="2">.';
        echo '<input type="text" name="latitudeDecimal" size="3" maxlength="3">&prime;<br>'."\n";
//        echo $html->getTag('input', '', array('type' => 'text', 'name' => 'latitude', 'id' => 'cacheLatitude'))."<br>\n";

        echo $html->getTag('label', $txt->longtitude, array('for' => 'cacheLongtitude'));
        echo '<select name="longtitideSign"><option value="+">E</option><option value="-">W</option></select>';
        echo '<input type="text" name="longtitudeDegree" size="3" maxlength="3">&deg;';
        echo '<input type="text" name="longtitudeMinutes" size="2" maxlength="2">.';
        echo '<input type="text" name="longtitudeDecimal" size="3" maxlength="3">&prime;<br>'."\n";
//        echo $html->getTag('input', false, array('type' => 'text', 'name' => 'longtitude', 'id' => 'cacheLongtitude'))."<br>\n";

        echo $html->getTag('label', $txt->cacheBirthDate, array('for' => 'cacheTimestamp'));
//        echo '<select name="setYear"><option value="2010">2010</option><option value="2011">2011</option></select>';
        echo $html->getTag('input', '', array('type' => 'text', 'name' => 'timestamp', 'id' => 'cacheTimestamp'))."<br>\n";

        echo $html->getTag('label', $txt->cacheDescription, array('for' => 'cacheDescription'));
        echo $html->getTag('textarea', '', array('type' => 'text', 'name' => 'cacheDescription', 'id' => 'cacheDescription'))."<br>\n";

        echo $html->getTag('label', $txt->locationDescription, array('for' => 'cacheLocationDescription'));
        echo $html->getTag('textarea', '', array('type' => 'text', 'name' => 'locationDescription', 'id' => 'cacheLocationDescription'))."<br>\n";

        echo $html->getTag('input', $txt->submitCache, array('type' => 'submit'))."\n";
        echo '</form>'."\n";
    }
    else
    {
        
    }
?>

</div>
