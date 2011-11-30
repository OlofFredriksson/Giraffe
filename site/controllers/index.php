<?php
class index extends Controller {
	function __construct() {
		//$this->loadModel('model_blog');
	}

	function index() {
		$this->loadView('index',"heeej");
	}
}
?>