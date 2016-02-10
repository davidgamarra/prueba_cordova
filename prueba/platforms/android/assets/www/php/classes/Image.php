<?php 
class Image {
	private $id, $id_item, $route;
	
	function __construct($id = null, $id_item = null, $route = null) {
		$this->id = $id;
		$this->id_item = $id_item;
		$this->route = $route;
	}
	
	function getId() {
		return $this->id;
	}
	
	function getId_item(){
		return $this->id_item;
	}
	
	function getRoute(){
		return $this->route;
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