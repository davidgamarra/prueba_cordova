<?php
class Controller {
	static function handle(){
		$action = Request::req("action");
		$target = Request::req("target");
		$metodo = $action.ucfirst($target);
		if(method_exists(get_class(), $metodo)){
			self::$metodo();
		} else {
			self::viewIndex();
		}
	}
	
	private static function viewIndex(){
        header('content-type: application/json; charset=utf-8');
        header("access-control-allow-origin: *");
        $db = new DataBase();
        $managerItem = new ManageItem($db);
        $managerImage = new ManageImage($db);
        $items = $managerItem->getList();
        $json = '{"items":[';
        foreach($items as $item){
            $images = $managerImage->getList($item->getId());
            $json .= '{"item":'.$item->getJson().',"image":'.$images[0]->getJson().'},';
        }
        $json = substr($json, 0, -1);
        $json .= ']}';
        $db->close();
        echo $json;
	}
    
    private static function viewItem(){
        header('content-type: application/json; charset=utf-8');
        header("access-control-allow-origin: *");
        $db = new DataBase();
        $managerItem = new ManageItem($db);
        $managerImage = new ManageImage($db);
        $id = Request::req('id');
        $item = $managerItem->get($id);
        $images = $managerImage->getList($id);
        $json = '{"item":'.$item->getJson().',"images":[';
        foreach($images as $image){
            $json .= $image->getJson().",";
        }
        $json = substr($json, 0, -1);
        $json .= ']}';
        $db->close();
        echo $json;
	}
    
    private static function loginUser(){
        header('content-type: application/json; charset=utf-8');
        header("access-control-allow-origin: *");
		$db = new DataBase();
		$manager = new ManageUser($db);
		
		$user = Request::req("email");
		$pass = Request::req("pass");
		
		$usuario = $manager->get($user);
		$sesion = new Session();
        
		if($usuario !== null && $usuario->getPass() === sha1($pass)){
			$sesion->setUser($user);
			echo '{"response":1}';
		} else {
			$sesion->destroy();
			echo '{"response":0}';
		}
		$db->close();
	}
		
}