<?php 
$xd = [true, false,true];


var_dump(array_reduce($xd, fn ($prev, $curr) => is_numeric($curr) ? $prev + $curr : $prev) ?? 0);
