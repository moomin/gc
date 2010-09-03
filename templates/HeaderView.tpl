<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title><?= $Site->title ?></title>
<?php
foreach ($Site->getHeaders() as $header)
{
   echo $Site->html->getTag($header['tag'], $header['value'], $header['attributes'])."\n";
}
?>
</head>
<body>
