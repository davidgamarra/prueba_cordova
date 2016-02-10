<?php 
class Item {
	private $id, $title, $description;
	
	function __construct($id = null, $title = null, $description = null) {
		$this->id = $id;
		$this->title = $title;
		$this->description = $description;
	}
	
	function getId() {
		return $this->id;
	}
	
	function getTitle(){
		return $this->title;
	}
	
	function getDescription(){
		return $this->description;
	}
    
    function getArray($values=true) {
		$r = array();
		foreach($this as $key => $value) {
			if($values){
				$r[$key] = $value;
			} else {
				$r[$key] = null;
			}
		}
		return $r;
	}
	
	function getJson() {
		$r = '{';
		foreach($this as $key => $value) {
			$r .= '"' . $key . '":' . json_encode(htmlspecialchars_decode($value)) . ',';
		}
		$r = substr($r, 0, -1);
		$r .= '}';
		return $r;
	}

	function set($values, $index=0) {
		$i = 0;
		foreach($this as $key => $value) {
			$this->$key = $values[$i+$index];
			$i++;
		}
	}
	
	function read(){
		foreach($this as $key => $value) {
			$this->$key = Request::req($key);
		}
	}
}