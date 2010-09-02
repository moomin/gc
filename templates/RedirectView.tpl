<p><?= $message ?></p>
     <p><?= $txt->get('redirectMessage', array($targetName, $seconds)) ?>. <?= $txt->forceRedirectMessage ?><a href="<?= $targetUrl ?>" title="<?= $targetName ?>"><?= $txt->clickHere ?></a>.<p>
<script>setTimeout("location.href='<?= $targetUrl ?>'", <?= $seconds * 1000 ?>);</script>
