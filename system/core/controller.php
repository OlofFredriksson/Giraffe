<?php
class Controller {
	function __construct() {
	}
	function loadView($view,$data="") {
		if(is_array($data) && count($data) > 0) {
			extract($data);
		}
		require_once('site/themes/'.get_siteInfo("theme").'/'.$view.'.php');
	}
	
	function loadModel($model) {
		require_once('model/'.$model.'.php');
		$this->$model = new $model;
	}

}
?>