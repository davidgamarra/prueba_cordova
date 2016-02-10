<?php

class User {
	
	private $email, $pass;
    
    function __construct($email = null, $pass = null) {
        $this->email = $email;
		$this->pass = $pass === null ? $pass : sha1($pass);
    }
    
    function getEmail() {
        return $this->email;
    }
	
	function getPass() {
		return $this->pass;
	}
	
    function setEmail($email) {
        $this->email = $email;
    }
	
	function setPass($pass) {
		$this->pass = sha1($pass);
	}
	
	function getJson() {
		$r = '{';
		foreach($this as $key => $value) {
			$r .= '"' . $key . '":"' . $value . '",';
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
	
	function read(){
		foreach($this as $key => $value) {
			$this->$key = Request::req($key);
		}
	}
	
}