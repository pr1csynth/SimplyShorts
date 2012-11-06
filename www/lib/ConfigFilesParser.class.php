<?php

/*
## FILE configFileParser.class.php
Parse config files and apply patchs.
Usage : `$settings = ConfigFileParser::parse($configFilePath);`
*/

class ConfigFilesParser{

	public static function parse($filePath){
		if(is_file($filePath.".default.json")){

			// Get default config file and his patch.
			$jsonBase = implode('', file($filePath.".default.json"));
			if(is_file($filePath.".json")){
				$jsonPatch = implode('',file($filePath.".json"));
			}else{
				$jsonPatch = "";
			}

			// Convert it in object

			$base = json_decode($jsonBase);
			if(is_null($base)){
				throw new Exception("default file is an invalid JSON file.");
				return;				
			}

			$patch = json_decode($jsonPatch);
			if(is_null($patch)){
				$patch = array();
			}

			// Patch it
			return self::patch($base, $patch);

		}else{
			throw new Exception('Default file is unreachable');
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

?>