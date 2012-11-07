<?php
/*
## FILE : font.php
When debug mode is active, this php code return up to date css with fontfaces.
*/

header('Content-type: text/css');

require '../lib/CSSComputer.class.php';

echo CSSComputer::genFont();

?>