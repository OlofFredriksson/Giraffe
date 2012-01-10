<?php
class Page extends Controller {
	private $data = array();
	function __construct() {
		parent::__construct();
		$this->data["meta_description"] = "";
		$this->data["meta_keywords"] = "";
	}

	function index() {
		$this->data["h1"] = "PAGE CMS";
		$this->data["site_title"] = "PAGE CMS";
		$this->load->view('page',$this->data);
	}
	
	function show($title = "") {
		$this->data["id"] = $title;
		$this->data["text"] = "Post ...";
		$this->load->model("Cms","cms");
		$this->data["post"] = $this->cms->get_post($title);
		$this->data["h1"] = $this->data["post"]["title"];
		$this->data["meta_description"] = $this->data["post"]["meta_description"];
		$this->data["meta_keywords"] = $this->data["post"]["meta_keywords"];
		$this->data["site_title"] = $this->data["h1"];
		$this->load->view('page',$this->data);
	}
}
?>