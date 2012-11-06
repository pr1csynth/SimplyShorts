<?php
/*
## FILE : index.php
Entry point. 
*/

function loadClass($class){
    require 'lib/'.$class.'.class.php';
}

spl_autoload_register('loadClass');

define('ROOTPATH',realpath('.')."/");

try{
    $SimplyShorts = new SimplyShorts;
    $SimplyShorts->renderPage();
}catch(Exception $e){
    echo "FATAL ERROR: ".$e->getMessage();
}

?>