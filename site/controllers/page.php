<?php
class Page extends Controller {
	function __construct() {
		//$this->loadModel('model_blog');
	}

	function index() {
		$data["h1"] = "PAGE CMS";
		$this->loadView('page',$data);
	}
	
	function show($title = "") {
		$data["id"] = $title;
		$data["text"] = "Post ...";
		$this->loadModel("Cms");
		$data["post"] = $this->Cms->get_post($title);
		$data["h1"] = $data["post"]["title"];
		$this->loadView('page',$data);
	}
}
?>