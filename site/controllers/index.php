<?php
class index extends Controller {
	function __construct() {
		//$this->loadModel('model_blog');
	}

	function index() {
		$data["text"] = "index construct";
		$data["site_title"] = "Test title";
		$this->loadView('index',$data);
	}
	
	function example($one="",$two="",$plus="") {
		echo $one." ".$two.$plus;
		$data["text"] = "example controller";
		$this->loadView('index',$data);
	}
}
?>