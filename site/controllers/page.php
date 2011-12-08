<?php
class Page extends Controller {
	function __construct() {
		//$this->loadModel('model_blog');
	}

	function index() {
		$data["text"] = "PAGE CMS";
		$this->loadView('page',$data);
	}
	
	function show($title = "") {
		$data["id"] = $title;
		$data["text"] = "Post ...";
		$this->loadView('page',$data);
	}
}
?>