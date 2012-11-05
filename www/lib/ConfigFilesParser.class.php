<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

class ConfigFileParser{

	public static function parse($filePath){
		if(is_file($filePath.".json")){

			// Get default config file and his patch.
			$jsonBase = implode('', file($filePath.".default.json"));
			$jsonPatch = implode('',file($filePath.".json"));

			// Convert it in object
			$base = json_decode($jsonBase);
			$patch = json_decode($jsonPatch);

			// Patch it
			return self::patch($base, $patch);

		}else{
			trigger_error("File is unreachable.");
			return;
		}
	}

	private static function patch($base, $patch){
		// Patch $base with values of $patch
		foreach ($base as $key => $value) {
			if (isset($patch->$key)) {
				if(gettype($value) != "object"){
					$base->$key = $patch->$key;
				}else{
					$base->$key = self::patch($value, $patch->$key);
				}
			}
		}
		return $base;	
	}
}

var_dump( ConfigFileParser::parse("../config/config") );

?>