<?php
/*
## FILE : custom.php
When debug mode is active, this php code return up to date customisation css.
*/

header('Content-type: text/css');

require '../lib/ConfigFilesParser.class.php';
require '../lib/CSSComputer.class.php';

$stylesSettings = ConfigFilesParser::parse("../config/styles");
echo CSSComputer::genCustomisation($stylesSettings);

?>