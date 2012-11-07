<?php

/*
## FILE CSSComputer.class.php
Generate cascade style sheets.
*/

header("Content-type: text/css");


class CSSComputer{

	private static $CSSData = array();
	private static $vendors = array("", "-webkit-", "-moz-", "-ms-", "-o-");

	public static function genFont(){
		return "";
	}
	
	public static function genCustomisation($stylesSettings){

		
		$font = $stylesSettings->style->font;
		
		self::addProperty('html', 'color', self::tabToRGB($font->color));
		self::addProperty('a', 'color', self::tabToRGB($font->linkColor));
		self::addProperty('a', 'border-color', self::tabToRGB($font->linkColor));
		self::addProperty('a:hover', 'color', self::tabToRGB($font->color));
		self::addProperty('a:hover', 'border-color', self::tabToRGB($font->color));
		$defaultFont = "default".$font->defaultStyle;
		self::addProperty('html', 'font-family', $font->$defaultFont);
		self::addProperty('html', 'font-size', $font->defaultSize."px");
		self::addProperty('html', 'text-align', $font->defaultAlignment);
		self::addProperty('article, header', 'text-align', $font->defaultAlignment);

		self::addProperty('article', 'line-height', $font->interline);
		
		self::addProperty('#background, html', 'background-color', self::tabToRGB($stylesSettings->style->backgroundColor));
		
		$backgrounds = $stylesSettings->style->backgrounds;

		if($backgrounds->gradientType == "linear"){
			self::addProperty("#background","background","linear-gradient(top, ".self::tabToRGB($backgrounds->from).", ".self::tabToRGB($backgrounds->to).")",true,true);
		}elseif ($backgrounds->gradientType == "radial") {
			self::addProperty("#background","background","radial-gradient(50% 50%, circle cover, ".self::tabToRGB($backgrounds->from).", ".self::tabToRGB($backgrounds->to).")",true,true);
		}

		if($backgrounds->raw != ""){
			self::addProperty('body','background',$backgrounds->raw);
			if($backgrounds->size != "")
				self::addProperty('body','background-size',$backgrounds->size);
		}

		
		$block = $stylesSettings->style->blocks;

		$margin = $block->margin;
		$padding = $block->padding;
		$oneUnit = $block->width; 		
		$twoUnits = 2*($oneUnit+$padding+$margin);
		$video2UHeight = $twoUnits*(9/16);
		$threeUnits = 4*$margin+4*$padding+3*$oneUnit;
		$video3UHeight = $threeUnits*(9/16);

		$totalWidth = 3*(2*$margin+2*$padding+$oneUnit);

		self::addProperty('section','width',$totalWidth."px");

		self::addProperty('.u2.video iframe','width',$twoUnits."px");
		self::addProperty('.u2.video iframe','height',$video2UHeight."px");

		self::addProperty('.u3.video iframe','width',$threeUnits."px");
		self::addProperty('.u3.video iframe','height',$video3UHeight."px");
				
		self::addProperty('article, header','background-color', self::tabToRGB($block->backgroundColor));
		self::addProperty('article, header','border-radius', $block->borderRadius."px", true);
		self::addProperty('article, header','box-shadow', self::tabToShadow($block->shadow), true);
		if($block->alignment != "default")
		self::addProperty('article','text-align', $block->alignment);
		self::addProperty('article, header','margin', $block->margin."px");
		self::addProperty('article, header','padding', $block->padding."px");		
		
		self::addProperty('.u1, .u1 img','width', $oneUnit."px");
		self::addProperty('.u2, .u2 img','width', $twoUnits."px");
		self::addProperty('.u3, .u3 img, header','width', $threeUnits."px");

		self::addProperty('header','margin-top','0px');
		
		$title = $stylesSettings->style->title;

		if($title->alignment != 'default')		
		self::addProperty('header', 'text-align', $title->alignement); 
		if($title->font != 'default')		
		self::addProperty('header', 'font-family', $title->font); 
		if($title->size != 'default')		
		self::addProperty('header', 'font-size', $title->size."px"); 	
		
		$nav = $stylesSettings->style->navigation;

		if($nav->alignment != 'default')		
		self::addProperty('navigation', 'text-align', $nav->alignement); 
		if($nav->font != 'default')		
		self::addProperty('navigation', 'font-family', $nav->font); 
		if($nav->size != 'default')		
		self::addProperty('navigation', 'font-size', $nav->size."px"); 	
		
		$error = $stylesSettings->style->error;

		if($error->alignment != 'default')		
		self::addProperty('.error', 'text-align', $error->alignment); 
		if($error->font != 'default')		
		self::addProperty('.error', 'font-family', $error->font); 
		if($error->size != 'default')		
		self::addProperty('.error', 'font-size', $error->size."px"); 
		
		self::addProperty('.footer', 'opacity',$stylesSettings->style->footer->opacity); 		

		return self::renderFile();
	}
	
	private static function tabToRGB($tab){
	  if(count($tab) == 4){
	  	return "rgba(".$tab[0].",".$tab[1].",".$tab[2].",".$tab[3].")";
	  }else{
	  	return "rgb(".$tab[0].",".$tab[1].",".$tab[2].")";
	  }
	}
	
	private static function tabToShadow($tab){
		return $tab[0]."px ".$tab[1]."px ".$tab[2]."px ".self::tabToRGB($tab[3]);
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

?>
