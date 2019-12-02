<?php
$separator = "\r\n";
$line = strtok($subject, $separator);
$sum = 0;

while ($line !== false) {
  $lineval = intval($line);
  $lineval = floor($lineval / 3) - 2;
  $sum += $lineval;
  
  $additional = floor($lineval / 3) - 2;
  while ($additional > 0) {
    $sum += $additional;
    $additional = floor($lineval / 3) - 2;
  }
  $line = strtok( $separator );
}

echo "$sum";
?>
