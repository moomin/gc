<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title><?= $title ?></title>
<?php
foreach ($headers as $header)
{
   echo $html->getTag($header['tag'], $header['value'], $header['attributes'])."\n";
}
?>
</head>
<body>
