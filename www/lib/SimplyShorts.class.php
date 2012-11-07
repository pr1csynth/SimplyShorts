<?php
/*
## FILE : SimplyShorts.class.php
Main Program.
*/

class SimplyShorts{

	private $page;
	
	public function __construct(){

		$title = "";

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
			$title = "";
		}

		$title .= " Testing page";

		// Testing
		$this->page = new Page($title);

		$this->page->addCSS('css/fonts.php');
		$this->page->addCSS('css/common.css');
		$this->page->addCSS('css/custom.php');

		$this->page->addBlocks(array(
			array(
				'classes' => array('error'),
				'content' => 'Coucou :3'
				),			array(
				'classes' => array('u2'),
				'content' => 'Coucou :3'
				),			array(
				'classes' => array('u1'),
				'content' => 'Coucou :3'
				),
			array(
				'classes' => array('u1'),
				'content' => 'Youhou youpi yiha tralala pouet !'
				)
			),"normal");

	}

	public function renderPage(){
		echo $this->page->compute();
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