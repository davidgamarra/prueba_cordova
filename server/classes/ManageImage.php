<?php
class ManageImage {
	
	private $db = null;
	private $table = "image";
	
	function __construct(DataBase $db) {
		$this->db = $db;
	}
	
	function get($id) {
		$params = array();
		$params["id"] = $id;
		$this->db->select($this->table, "*", "id=:id", $params);
		$row = $this->db->getRow();
		$image = new Image();
		$image->set($row);
		return $image;
	}
    
    function insert(Image $image) {
		return $this->db->insert($this->table, $image->getArray(), false);
	}
	
	function set(Image $image) {
		$conditions = array();
		$conditions["id"] = $image->getId();
		return $this->db->update($this->table, $image->getArray(), $conditions);
	}
	
	function delete($id) {
		$params = array();
		$params["id"] = $id;
		return $this->db->delete($this->table, $params);
	}
	
	function getList($id) {
		$this->db->query($this->table, ["*"], array("id_item" => $id));
		$r = array();
		while($row = $this->db->getRow()) {
			$image = new Image();
			$image->set($row);
			$r[] = $image;
		}
		return $r;
	}
	
}