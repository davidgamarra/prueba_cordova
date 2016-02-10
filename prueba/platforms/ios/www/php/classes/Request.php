<?php

class Request {
    static function get($item, $filtrar = true, $index = null){
        if(isset($_GET[$item])){
            return self::read($_GET[$item], $filtrar, $index);
        }
        return null;
    }
    
    static function post($item, $filtrar = true, $index = null){
        if(isset($_POST[$item])){
            return self::read($_POST[$item], $filtrar, $index);
        }
        return null;
    }
    
    static function req($item, $filtrar = true, $index = null){
        $value = self::post($item, $filtrar, $index);
        if($value !== null){
            return $value;
        } 
        return self::get($item, $filtrar, $index);
    }
    
    static function readArray($item, $index = null){
        if(isset($_GET[$item])){
            if($index === null){
                $array = array();
                foreach($_GET[$item] as $value){
                    $array[] = self::clean($value);
                }
                return $array;
            } else if(isset($_GET[$item][$index])) {
                return self::clean($_GET[$item][$index]);
            }
        } else {
            return self::clean($_GET[$item]);
        }
    }
    
    private static function read($item, $filtrar = true, $index = null){
        if(is_array($item)){
            if($index === null){
                $array = array();
                foreach($item as $value){
					$r = self::clean($value, $filtrar);
					if($r === ""){
						$r = null;
					}
                    $array[] = $r;
                }
                return $array;
            } else if(isset($item[$index])) {
                $r = self::clean($item[$index], $filtrar);
				if($r === ""){
					$r = null;
				}
				return $r;
            }
        } else {
            $r = self::clean($item, $filtrar);
			if($r === ""){
				$r = null;
			}
			return $r;
        }
    }
	
	private static function clean($value, $filtrar){
		if($filtrar === true){
			return htmlspecialchars($value);
		}
		return trim($value);
	}
	
	
}