<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

header("Content-type: text/css");


class CSSComputer{

	private static $CSSData = array();
	private static $vendors = array("", "-webkit-", "-moz-", "-ms-", "-o-");
	
	public static function genCustomisation($stylesSettings){

		$block = $stylesSettings->style->blocks;

		$margin = $block->margin;
		$padding = $block->padding;
		$oneUnit = $block->width; 

		$totalWidth = 3*(2*$margin+2*$padding+$oneUnit);

		self::addProperty('section','width',$totalWidth."px");

		return self::renderFile();
	}

	private static function addProperty($selector, $property, $value, $putVendors = false, $vendorOnValue = false){
		if($putVendors){
			foreach (self::$vendors as $i => $vendor) {
				if($vendorOnValue){
					self::addProperty($selector,$property,$vendor.$value);
				}else{
					self::addProperty($selector,$vendor.$property,$value);
				}
			}
		}else{
			if(!isset(self::$CSSData[$selector])){
				self::$CSSData[$selector] = array();	
			}
			array_push(self::$CSSData[$selector], $property.":".$value);
		}
	}

	private static function renderFile(){

		$CSSText = "/* CSSComputer is the stronger. */\n";
		if(true){
			$endChar = "\n";
			$tabChar = "\t";
		}else{
			$endChar = "";
			$tabChar = "";
		}

		foreach (self::$CSSData as $selector => $instructions) {
			$CSSText .= $selector."{".$endChar;
			foreach ($instructions as $key => $instruction) {
				$CSSText .= $tabChar.$instruction.";".$endChar;
			}
			$CSSText .= "}".$endChar.$endChar;
		}

		self::$CSSData = array();
		return $CSSText;
	}

}

require("ConfigFilesParser.class.php");

echo CSSComputer::genCustomisation(ConfigFilesParser::parse('../config/styles'));
?>