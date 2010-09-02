<div id="cacheList">
<?php if (!$caches): ?>
No caches yet! :(
<?php else:
echo "<ul>\n";
foreach ($caches as $cache): ?>
  <li><?= gettype($cache) ?></li>

<? endforeach;
   echo "</ul>\n";
   endif; ?>
</div>