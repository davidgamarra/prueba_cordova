<?php
class ManageItem {
	
	private $db = null;
	private $table = "item";
	
	function __construct(DataBase $db) {
		$this->db = $db;
	}
	
	function get($id) {
		$params = array();
		$params["id"] = $id;
		$this->db->select($this->table, "*", "id=:id", $params);
		$row = $this->db->getRow();
		$item = new Item();
		$item->set($row);
		return $item;
	}
    
    function insert(Item $item) {
		return $this->db->insert($this->table, $item->getArray(), false);
	}
	
	function set(Item $item) {
		$conditions = array();
		$conditions["id"] = $item->getId();
		return $this->db->update($this->table, $item->getArray(), $conditions);
	}
	
	function delete($id) {
		$params = array();
		$params["id"] = $id;
		return $this->db->delete($this->table, $params);
	}
	
	function getList() {
		$this->db->query($this->table);
		$r = array();
		while($row = $this->db->getRow()) {
			$item = new Item();
			$item->set($row);
			$r[] = $item;
		}
		return $r;
	}
	
}