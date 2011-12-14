<?php
class Controller {
	function __construct() {
	}
	 protected function loadView($view,$data = "") {
		if(is_array($data) && count($data) > 0) {
			extract($data);
		}
		require_once(SITE_PATH.'/themes/'.get_siteInfo("theme").'/'.$view.'.php');
	}
	public function loadModel($model,$name = "") {
		if(empty($name)) {
			$name = $model;
		}
		$path = strtolower(SITE_PATH."/models/".$model.".php");
		if(file_exists($path)) {
			require_once($path);
			$this->$name = new $model();
		} else {
			echo $path;
			die('Model does not exist');
			
		}

}

}
?>