<div id="geocache">
<?php
    $html = $Site->html;
    $txt = $Site->text;

    if ($edit)
    {
        $edit = true;
        echo '<form method="post" name="cache" action="'.$Site->getUrl('Cache', 'addSubmit').'">'."\n";
        echo $html->getTag('label', $txt->cacheTitle, array('for' => 'cacheTitle'));
        echo $html->getTag('input', '', array('type' => 'text', 'name' => 'title', 'id' => 'cacheTitle'))."<br>\n";

        echo $html->getTag('label', $txt->latitude, array('for' => 'cacheLatitude'));
        echo $html->getTag('input', '', array('type' => 'text', 'name' => 'latitude', 'id' => 'cacheLatitude'))."<br>\n";

        echo $html->getTag('label', $txt->longtitude, array('for' => 'cacheLongtitude'));
        echo $html->getTag('input', false, array('type' => 'text', 'name' => 'longtitude', 'id' => 'cacheLongtitude'))."<br>\n";

        echo $html->getTag('label', $txt->cacheBirthDate, array('for' => 'cacheTimestamp'));
        echo $html->getTag('input', '', array('type' => 'text', 'name' => 'timestamp', 'id' => 'cacheTimestamp'))."<br>\n";

        echo $html->getTag('label', $txt->cacheDescription, array('for' => 'cacheDescription'));
        echo $html->getTag('input', '', array('type' => 'text', 'name' => 'cacheDescription', 'id' => 'cacheDescription'))."<br>\n";

        echo $html->getTag('label', $txt->locationDescription, array('for' => 'cacheLocationDescription'));
        echo $html->getTag('input', '', array('type' => 'text', 'name' => 'locationDescription', 'id' => 'cacheLocationDescription'))."<br>\n";

        echo $html->getTag('input', $txt->submitCache, array('type' => 'submit'))."\n";
        echo '</form>'."\n";
    }
    else
    {
        
    }
?>

</div>
