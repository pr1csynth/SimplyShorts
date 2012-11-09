<?php
/*
## FILE : SimplyShorts.class.php
Main Program.
*/

class SimplyShorts{

	private $page;
	private $db;
	
	public function __construct(){

		$title = "";

		// Config file parsing

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
		}

		// Create minimal page

		$title = SITENAME;
		$this->page = new Page();
		$this->page->addCSS('css/fonts.php');
		$this->page->addCSS('css/common.css');
		$this->page->addCSS('css/custom.php');

		// Connect database

		try{
			$this->db = new DB($config->ss->db);
		}catch(Exception $e){
			$this->page->setTitle($title);
			$this->page->displayError("DB error: ".$e->getMessage());
			return;
		}

		// Arg parsing

		$args = $_SERVER['QUERY_STRING'];
		$args = explode(SEPARATOR, $args);

		if($args[0] != ''){
			$identifiant = $args[0];
		}else{
			$identifiant = "index";
		}

		if(isset($args[1])){
			$skip = intval($args[1]);
			$action = $args[1];
		}else{
			$skip = 0;
			$action = "0";
		}

		// Decision

		if($identifiant == "index"){
			switch ($action) {
				case 'add':
					# add cat gen
					break;
				case 'edit':
					# edit site gen
					break;
				case 'del':
					# del cat gen 
					break;
				case 'view':
				default:
					# narmol page gen
					break;
			}
		}elseif($this->db->issetId($identifiant)) {
			switch ($action) {
				case 'add':
					# add cat gen
					break;
				case 'edit':
					# edit site gen
					break;
				case 'del':
					# del cat gen 
					break;
				case 'view':
				default:
					# narmol page gen
					break;
			}
		}else{
			$this->page->gen404(AFFHEADER,AFFNAV);
		}

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