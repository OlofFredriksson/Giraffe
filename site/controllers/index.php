<?php
class index extends Controller {
	function __construct() {
		//$this->loadModel('model_blog');
	}

	function index() {
		$data["text"] = "index construct";
		$this->loadView('index',$data);
	}
	
	function example($value = "") {
		$data["text"] = "example controller";
		$this->loadView('index',$data);
	}
}
?>