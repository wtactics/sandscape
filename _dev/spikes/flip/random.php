<?php

$imgs = array('DoubttheViolence.png', 'ElvishArcher.png', 'ElvishFighter.png', 'ElvishMarksman.png',
    'ElvishRanger.png', 'ElvishScout.png', 'ElvishShaman.png', 'ElvishSharpshooter.png',
    'ElvishShyde.png', 'MermanBrawler.png', 'MermanHoplite.png'
);

$v = rand(0, count($imgs) - 1);
$v = $imgs[$v];

echo $v;
?>
