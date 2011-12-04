<?php
class Controller {
	function __construct() {
	}
	function loadView($view,$data="") {
		global $giraffe;
		if(is_array($data) && count($data) > 0) {
			extract($data, EXTR_PREFIX_SAME, "wddx");
		}
		$theme = $giraffe->getConfig();
		require_once('site/themes/'.$theme["theme"].'/'.$view.'.php');
	}
	
	function loadModel($model) {
		require_once('model/'.$model.'.php');
		$this->$model = new $model;
	}

}
?>