<?php
/*
## FILE : SimplyShorts.class.php
Main Program.
*/

class SimplyShorts{
	
	public function __construct(){
		
		try{
			$config = ConfigFilesParser::parse("config/config");
		}catch(Exception $e){
			throw new Exception("Failed to parse config file: ".$e->getMessage(), 1,$e);
			return;
		}

		self::defineConstants($config);
	}

	private function defineConstants($config){
		
	}
}

?>