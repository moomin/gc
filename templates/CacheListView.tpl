<div id="cacheList">
<?php if (!$caches): ?>
No caches yet! :(
<?php else:
echo "<ul>\n";
foreach ($caches as $c): ?>
  <li><a href="<?= $Site->getUrl('cache', 'view', array('id' => $c->id)) ?>"><?= $c->title ?></a></li>

<? endforeach;
   echo "</ul>\n";
   endif; ?>
</div>