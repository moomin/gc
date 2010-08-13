<div id="userBar">
<?php
    if ($user->isSignedIn())
    {
?>
<?= $text->hello.', '.$user->name ?>
&nbsp;
<?= $html->getTag('a', $text->signout, array('href' => $site->getUrl('SignOut'))) ?>
<?php
    }
    else
    {
        switch ($user->authResult)
        {
           case User::AUTH_RES_FAIL:
             $message = $text->signinfailed;
             break;
           case User::AUTH_RES_CANCEL:
             $message = $text->signincancel;
             break;
           case User::AUTH_RES_NONE:
           default:
        }

?>
<?= (isset($message) ? $html->getTag('p', $message) : '') ?>
<form method="post" name="signin" action="<?= $site->getUrl('SignIn') ?>">
  <?= $html->getTag('label', $text->openid . ':', array('for' => 'openid')); ?>

  <?= $html->getTag('input', false, array('type'=>'text', 'name'=>'openid_identifier', 'id' => 'openid')) ?>

  <?= $html->getTag('input', false, array('type'=>'submit', 'value' => $text->signin )) ?>

</form>

<?php
     }
?>
</div>