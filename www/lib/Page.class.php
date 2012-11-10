<?php

/*
## FILE : PageComputer.class.php
Give HTML code for blocks data.
*/

class Page{

	// HEAD
	private $metas = array();
	private $links = array();
	private $headScripts = array();

	private $pageTitle = "";

	//BODY

	private $header = true;
	private $navigation = true;
	private $headerClasses = array();

	private $navItems = array();
	private $current = 'index';

	private $asideItems = array();

	private $pinnedBlocks = array();
	private $classicBlocks = array();
	private $footerBlocks = array();

	private $bodyScripts = array();

	public function __construct(){
		$this->addMeta(array('charset' => 'utf-8'));
	}

	public function setTitle($title){
		$this->pageTitle = $title;
	}

	public function setHeader($header, $navigation, $classes = array()){
		$this->header = $header;
		if($this->header){
			$this->navigation = $navigation;
		}else{
			$navigation = false;
		}

		$this->headerClasses = $classes;
	}

	public function setMenu($items, $current){
		$this->navItems = $items;
		$this->current = $current;
	}

	public function addCSS($filePath, $media = "screen"){
		$item = array(	'rel' => 'stylesheet',
						'type' => 'text/css',
						'href' => $filePath,
						'media'=>$media
						);
		$this->links[] = $item;
	}

	public function addMeta($attributs){
		$this->metas[] = $attributs;
	}

	public function addScript($js,$headScript = true){
			if(strpos($js, ";")){
				$type = "inline";
			}else{
				$type = "file";
			}
			$script = array("type" => $type, "js" => $js);
			if($headScript){
				$this->headScripts[] = $script;
			}else{
				$this->bodyScripts[] = $script;
			}
	}

	public function addBlocks($blocks, $position = "normal"){
		if($position == "normal")
			$this->classicBlocks[] = $blocks;
		if($position == "pinned")
			$this->pinnedBlocks[] = $blocks;
		if($position == "footer")
			$this->footerBlocks[] = $blocks;
	}

	public function displayError($message){
		$this->addBlocks(array(array('classes' => array('error'),'content' => $message)));
	}

	public function gen404(){
		$this->setTitle('404');
		$this->addBlocks(array(array('classes' => array('u2'),'content' => "404")));
		$this->addBlocks(array(array('classes' => array('u1'),'content' => "<a href='".BASEURL."'>Go back</a>")));
	}

	public function compute(){
		$page = "<!DOCTYPE html>\n";
		$page .= "<html>\n";
		$page .= "\t<head>\n";

		// Metas
		foreach ($this->metas as $key => $meta) {
			$page .= "\t\t".$this->dataToTag($meta,"meta")."\n";
		}
		// CSS
		foreach ($this->links as $key => $link) {
			$page .= "\t\t".$this->dataToTag($link,"link")."\n";
		}

		// Scripts
		foreach ($this->headScripts as $key => $script) {
			$page .= "\t\t".$this->scriptDataToHTML($script)."\n";
		}

		$page .="\t\t<title>".$this->pageTitle."</title>\n";
		$page .="\t</head>\n";
		$page .="\t<body onload='init();'>\n";

		$page .="\t\t<div id='background'></div>\n";

		// TODO asides

		$page .="\t\t<section>\n";

		if($this->header){
			$page .="\t\t\t<header id='header' class='";
			foreach ($this->headerClasses as $key => $class) {
				$page .= $class." ";
			}
			$page .= "'>";
			$page .= $this->pageTitle;
			if($this->navigation){
				$page .= "<nav>";
				$page .= $this->navItemsToHTML($this->navItems);
				$page .= "</nav>";
			}
			$page .="</header>";
		}

		foreach ($this->pinnedBlocks as $key => $block) {
			$page .= $this->blockDataToHTML($block);
		}

		foreach ($this->classicBlocks as $key => $block) {
			$page .= $this->blockDataToHTML($block);
		}

		foreach ($this->footerBlocks as $key => $block) {
			$page .= $this->blockDataToHTML($block);
		}

		$page .="\n\t\t</section>\n";

		// Scripts
		foreach ($this->headScripts as $key => $script) {
			$page .= "\t\t".$this->scriptDataToHTML($script)."\n";
		}

		$page .="\t</body>\n";
		$page .="</html>";

		return $page;
	}

	private function dataToTag($data, $tagName){
		$tag = "<".$tagName;
		foreach ($data as $attribut => $value) {
			$tag .= ' '.$attribut.'="'.$value.'"';
		}
		$tag .= " >";
		return $tag;	
	}
	private function scriptDataToHTML($script){
		if($script["type"] == "inline"){
			return "<script type='text/javascript'>".$script['js']."</script>";
		}else{
			return "<script type='text/javascript' src='".$script['js']."'></script>";
		}
	}
	private function asideDataToHTML(){

	}
	private function navItemsToHTML($navItems){
		$nav = "";

		foreach ($navItems as $key => $item) {
			$class = "";
			if($item['url'] == $this->current){
				$class = "active"; 
			}
			$nav .= "<a class='".$class."' href='".BASEURL.$item['url']."'>".$item['name']."</a> - ";
		}

		if($this->current == "index"){
			$nav .= "<a class='active' href='".BASEURL."'>".SITENAME."</a>";
		}else{
			$nav .= "<a href='".BASEURL."'>".SITENAME."</a>";
		}


		return $nav;
	}
	private function blockDataToHTML($blockData){
		$html = '';
		foreach ($blockData as $key => $block) {
			$html .= "<article class=' ";
			foreach ($block['classes'] as $key => $class) {
				$html .= $class." ";
			}
			$html .= "' >".$block['content']."</article>";
		}
		return $html;
	}

}
?>