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
