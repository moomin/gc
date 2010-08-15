<div id="userBar">
<?php
   if ($Site->user->isSignedIn()) 
   {
?>
<?= $Site->text->hello.', '.$Site->user->name ?>
&nbsp;

<?= $Site->html->getTag('a', $Site->text->addCache, array('href' => $Site->getUrl('Cache', 'add'))) ?>
&nbsp;
<?= $Site->html->getTag('a', $Site->text->myCaches, array('href' => $Site->getUrl('Cache', 'showList', array('filter'=>'my')))) ?>
&nbsp;
<?= $Site->html->getTag('a', $Site->text->Preferences, array('href' => $Site->getUrl('User', 'preferences'))) ?>
&nbsp;
<?= $Site->html->getTag('a', $Site->text->signout, array('href' => $Site->getUrl('SignOut'))) ?>
<?php
    }
    else
    {
        switch ($Site->user->authResult)
        {
           case User::AUTH_RES_FAIL:
             $message = $Site->text->signinfailed;
             break;
           case User::AUTH_RES_CANCEL:
             $message = $Site->text->signincancel;
             break;
           case User::AUTH_RES_NONE:
           default:
        }

?>
<?= (isset($message) ? $Site->html->getTag('p', $message) : '') ?>
<form method="post" name="signin" action="<?= $Site->getUrl('SignIn') ?>">
  <?= $Site->html->getTag('label', $Site->text->openid . ':', array('for' => 'openid')); ?>

  <?= $Site->html->getTag('input', '', array('type'=>'text', 'name'=>'openid_identifier', 'id' => 'openid')) ?>

  <?= $Site->html->getTag('input', $Site->text->signin, array('type'=>'submit')) ?>

</form>
<?php
     }
?>
</div>
