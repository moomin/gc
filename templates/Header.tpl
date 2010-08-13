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
