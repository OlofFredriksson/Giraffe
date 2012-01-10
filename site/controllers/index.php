<?php
class index extends Controller {
	private $data = array();
	function __construct() {
		parent::__construct();
		$this->data["meta_description"] = "";
		$this->data["meta_keywords"] = "";
		$this->data["site_title"] = "Test title";
	}

	function index() {
		$this->data["text"] = "index construct";
		$this->load->view('index',$this->data);
	}
	
	function example($one="",$two="",$plus="") {
		echo $one." ".$two.$plus;
		$this->data["text"] = "example controller";
		$this->load->view('index',$this->data);
	}
}
?>