<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

	function parseConfigFile($filePath){

		if(is_file($filePath)){
			$jsonData = implode('',file($filePath));
			
			return json_decode($jsonData);

		}else{
			return false;
		}
	}

	function patch($base, $patch){
		foreach ($base as $key => $value) {
			if (isset($patch->$key)) {
				if(gettype($value) != "object"){
					$base->$key = $patch->$key;
				}else{
					$base->$key = patch($value, $patch->$key);
				}
			}
		}
		return $base;	
	}

	$settings = parseConfigFile("../../config/config.default.json");
	$customs = parseConfigFile("../../config/config.json");

	$settings = patch($settings,$customs);

	var_dump($settings->ss);
?>