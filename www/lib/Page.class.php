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

	private $navItems = array();

	private $asideItems = array();

	private $pinnedBlocks = array();
	private $classicBlocks = array();
	private $footerBlocks = array();

	private $bodyScripts = array();

	public function __construct($title){
		$this->pageTitle = $title;
		$this->addMeta(array('charset' => 'utf-8'));
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
			$script = array("type" => $type);
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

	public function compute($header = true, $navigation = true){
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
			$page .= "\t\t".scriptData($script)."\n";
		}

		$page .="\t\t<title>".$this->pageTitle."</title>\n";
		$page .="\t</head>\n";
		$page .="\t<body>\n";

		$page .="\t\t<div id='background'></div>\n";

		// TODO asides

		$page .="\t\t<section>\n";

		if($header){
			$page .="\t\t\t<header>";
			$page .= $this->pageTitle;
			if($navigation){
				$page .= "<nav>";
				$page .= $this->navItemsToHTML($this->navItems);
				$page .= "</nav>";
			}
			$page .="</header>";
		}

		foreach ($this->pinnedBlocks as $key => $block) {
			$page .= $t
		}

		$page .="\t\t</section>\n";

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
	private function scriptDataToHTML($scriptData){
		if($script["type"] == "inline"){
			return "<script type='text/javascript'>".$script['js']."</script>";
		}else{
			return "<script type='text/javascript' src='".$script['js']."'></script>";
		}
	}
	private function asideDataToHTML(){

	}
	private function navItemsToHTML($navItems){
		return "";
	}
	private function blockDataToHTML($blockData){
		foreach ($blockData as $key => $block) {
			$block = "<article class=' ";
			foreach ($block['classes'] as $key => $class) {
				$block .= $class." ";
			}
			$block .= "' >".$block['content']."</article>";
			return $block;
		}
	}

}
?>