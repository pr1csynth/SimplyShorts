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
			$styles = ConfigFilesParser::parse("config/styles");
		}catch(Exception $e){
			throw new Exception("Failed to parse config files: ".$e->getMessage(), 1,$e);
			return;
		}

		$this->defineConstants($config);

		$blocksMetrics = CSSComputer::getMetrics($styles);

		if(DEBUG){
			ini_set('display_errors', 1);
			error_reporting(E_ALL);	
			//header("Content-type: text/txt");
		}

		// Create minimal page

		$title = SITENAME;
		$this->page = new Page();
		$this->page->addCSS('css/fonts.php');
		$this->page->addCSS('css/common.css');
		$this->page->addCSS('css/custom.php');
		$this->page->addScript('var margin = '.$blocksMetrics['margin'].'; var padding = '.$blocksMetrics['padding'].';');
		$this->page->addScript('js/parser.js');

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
					$this->page->setHeader(AFFHEADER,AFFNAV);
					$this->page->setTitle(SITENAME);
					$index = $this->db->getIndexedBlocks($skip, MAXBLOCKS);
					if(AFFNAV)
						$this->page->setMenu($this->db->getMenu(), 'index');
					$this->page->addBlocks($index['blocks']);
					break;
			}
		}elseif($type = $this->db->issetId($identifiant)) {
			if($type == "cat"){
				switch ($action) {
					case 'add':
						# add block gen
					break;
					case 'edit':
						# edit cat gen
					break;
					case 'del':
						# del cat gen 
					break;
					case 'view':
					default:
					$cat = $this->db->getCat($identifiant, $skip, MAXBLOCKS);
					$this->page->setHeader($cat['header'],$cat['nav'], $cat['classes']);
					if($cat['nav'])
						$this->page->setMenu($this->db->getMenu(), $identifiant);
					$this->page->setTitle($cat['name']);
					$this->page->addBlocks($cat['blocks']);
					break;
				}
			}elseif ($type == "block") {
					switch ($action) {
					case 'edit':
						# edit block gen
					break;
					case 'del':
						# del block gen 
					break;
					case 'view':
					default:
					$block = $this->db->getBlock($identifiant);
					$this->page->setHeader($block['header'],$block['nav'], $block['classes']);
					if($block['nav'])
						$this->page->setMenu($this->db->getMenu(), $identifiant);
					$this->page->setTitle($block['name']);
					$this->page->addBlocks($block['blocks']);
					break;
				}
			}

			
		}else{
			$this->page->setHeader(AFFHEADER,AFFNAV);
			$this->page->gen404();
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
		define('MAXBLOCKS', intval($ss->maxBlocks));
		
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