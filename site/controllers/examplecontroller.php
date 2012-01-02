<?php
class examplecontroller extends Controller {
	function __construct() {
		//$this->loadModel('model_blog');
	}

	function index() {
		$this->loadView('examplecontroller',"heeej");
	}
}
?>