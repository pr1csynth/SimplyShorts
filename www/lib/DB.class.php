<?php
/*
## FILE : DB.class.php
DB manager.
*/

class DB{

	private $db;
	private $prefix;

	public function __construct($params){
		$options = array(	PDO::MYSQL_ATTR_INIT_COMMAND    => "SET NAMES utf8" ,
							PDO::ATTR_PERSISTENT => $params->persitent
						);

		try{
			$this->db = new PDO('mysql:host='.$params->host.';dbname='.$params->base, $params->user, $params->password, $options);
		}catch(Exception $e){
			throw new Exception("DB connection error : ".$e->getMessage()." (error ".$e->getCode().")", 1, $e);
		}	

		$this->prefix = $params->prefix;	

		$count = $this->query('SELECT * FROM '.$this->prefix.'blocks');

		if($count == array()){
			throw new Exception("Not installed or bad prefix", 1);
		}

	}

	private function query($queryString, $params = array()){
		try{
			$query = $this->db->prepare($queryString);

			foreach ($params as $key => $value) {
				$query->bindValue(':'.$key, $value, $this->PDOTypeOf($value));
			}

			$query->execute();

			$results = $query->fetchAll(PDO::FETCH_ASSOC);

			$query->closeCursor();

			return $results;
		}catch(Exception $e){
			throw new Exception("Query error : ".$e->getMessage, 1, $e);
			return null;
		}
	}

	private function PDOTypeOf($var){
		if(is_int($var))
			$param = PDO::PARAM_INT;
		elseif(is_bool($var))
			$param = PDO::PARAM_BOOL;
		elseif(is_null($var))
			$param = PDO::PARAM_NULL;
		elseif(is_string($var))
			$param = PDO::PARAM_STR;
		else
			$param = PDO::PARAM_STR;	
		return $param;
	}

	public function issetId($id)
	{
		$results = $this->query('SELECT COUNT(*) AS count FROM '.$this->prefix."cat WHERE url = :url", array('url' => $id));
		if($results[0]["count"] != 0){
			return "cat";
		}else{
			$results = $this->query('SELECT COUNT(*) AS count FROM '.$this->prefix."blocks WHERE id = :id AND visible = 1", array('id' => $id));	
			if($results[0]["count"] != 0){
				return "block";
			}else{
				return false;
			}
		}
	}

	public function getIndexedBlocks($skip, $count){
		$blocks = $this->query('
			SELECT 
				b.id,
				b.time,
				b.unit,
				b.typo,
				b.size,
				b.type,
				b.content,
				c.url
			FROM
				'.$this->prefix.'cat c
			INNER JOIN 
				'.$this->prefix.'blocks b
			ON
				b.cat = c.id
			WHERE 
				b.visible = 1 
			AND
				c.in_index = 1
			LIMIT 
				:skip,
				:count
			', array("skip" => $skip*$count, "count" => $count +1));

		$blockData = array();

		foreach ($blocks as $key => $block) {
			$blockData[] = array("classes" => array("u".$block['unit'], "s".$block['size'], $block['typo'], $block['type']), "content" => $block['content']);	
		}

		$blockData = array_reverse($blockData);

		if($count == count($blockData)){
			array_pop($blockData);
			$isNextPage = true;
		}else{
			$isNextPage = false;
		}

		return array("blocks" => $blockData, "nextPage" => $isNextPage);
	}

	public function getCat($cat, $skip, $count){
		$blocks = $this->query('
			SELECT 
				b.id,
				b.time,
				b.unit,
				b.typo,
				b.size,
				b.type,
				b.content,
				c.header,
				c.nav,
				c.name,
				c.typo title_typo,
				c.size title_size,
				c.time_sorted
			FROM
				'.$this->prefix.'blocks b
			INNER JOIN
				'.$this->prefix.'cat c				 
			ON
				b.cat = c.id
			WHERE 
				b.visible = 1 
			AND
				c.url = :cat
			LIMIT 
				:skip,
				:count
			', 
			array("cat" => $cat, "skip" => $skip*$count, "count" => $count + 1));

		$blockData = array();

		foreach ($blocks as $key => $block) {
			$blockData[] = array("classes" => array("u".$block['unit'], "s".$block['size'], $block['typo'], $block['type']), "content" => $block['content']);	
		}

		if($blocks[0]['time_sorted'])
			$blockData = array_reverse($blockData);

		if($count == count($blockData)){
			array_pop($blockData);
			$isNextPage = true;
		}else{
			$isNextPage = false;
		}

		return array("blocks" => $blockData, "header" => intval($blocks[0]['header']), "name" => $blocks[0]['name'], "nav" => intval($blocks[0]['nav']), "classes" => array("s".$blocks[0]['title_size'],$blocks[0]['title_typo']));
	}

	public function getBlock($id){
		$blocks = $this->query('
			SELECT 
				b.id,
				b.time,
				b.unit,
				b.typo,
				b.size,
				b.type,
				b.content,
				c.header,
				c.nav,
				c.name,
				c.typo title_typo,
				c.size title_size
			FROM
				'.$this->prefix.'blocks b
			INNER JOIN
				'.$this->prefix.'cat c				 
			ON
				b.cat = c.id
			WHERE 
				b.visible = 1 
			AND
				b.id = :id
			', 
			array("id" => $id));

		$blockData = array();

		foreach ($blocks as $key => $block) {
			$blockData[] = array("classes" => array("u".$block['unit'], "s".$block['size'], $block['typo'], $block['type']), "content" => $block['content']);	
		}

		return array("blocks" => $blockData, "header" => intval($blocks[0]['header']), "name" => $blocks[0]['name'], "nav" => intval($blocks[0]['nav']), "classes" => array("s".$blocks[0]['title_size'],$blocks[0]['title_typo']));
	}

	public function getMenu(){
		$items = $this->query('
			SELECT
				name,
				url
			FROM
				'.$this->prefix.'cat
			WHERE
				in_nav = 1
			');

		return $items;

	}

}
?>