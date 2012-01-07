<?php
class Page extends Controller {
	function __construct() {
		parent::__construct();
	}

	function index() {
		$data["h1"] = "PAGE CMS";
		$data["site_title"] = "PAGE CMS";
		$this->load->view('page',$data);
	}
	
	function show($title = "") {
		$data["id"] = $title;
		$data["text"] = "Post ...";
		$this->load->model("Cms","cms");
		$data["post"] = $this->cms->get_post($title);
		$data["h1"] = $data["post"]["title"];
		$data["site_title"] = $data["h1"];
		$this->load->view('page',$data);
	}
}
?>