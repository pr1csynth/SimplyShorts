<?php
/*
## FILE : SimplyShorts.class.php
Main Program.
*/

class SimplyShorts{

	private $pageComputer; 
	
	public function __construct(){

		try{
			$config = ConfigFilesParser::parse("config/config");
		}catch(Exception $e){
			throw new Exception("Failed to parse config file: ".$e->getMessage(), 1,$e);
			return;
		}

		self::defineConstants($config);

		if(DEBUG){
			ini_set('display_errors', 1);
			error_reporting(E_ALL);	
			echo "◰";
		}


	}

	public function renderPage(){

	}

	private function defineConstants($config){
		$ss = $config->ss;
		define("ONLINE", $ss->online);
		define("DEBUG", $ss->debug);
		define("OFFLINEMSG", $ss->offlineMessage);
		
		define("SITENAME",$ss->name);
		define('SITEDESC', $ss->description);

		define('AFFHEADER', $ss->header);
		define('AFFNAV',$ss->navigation);
		define('AFFMAXBLOCKS', $ss->maxBlocks);
		
		define('DISPLAYNAME',$ss->displayName);

		if($ss->url->urlRewrite){
			define('BASEURL', $ss->url->basedir."");
		}else{
			define('BASEURL', $ss->url->basedir."?");
		}

		define('SEPARATOR', $ss->url->separator);
		
	}
}

?>