<?php
class Controller {
	public $giraffe;
	function __construct($uri) {
	}
	function loadView($view,$data="") {
		if(is_array($data) && count($data) > 0) {
			extract($data, EXTR_PREFIX_SAME, "wddx");
		}
		require_once('site/themes/'.THEME.'/'.$view.'.php');
	}

}
?>