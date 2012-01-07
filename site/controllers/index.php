<?php
class index extends Controller {
	function __construct() {
		parent::__construct();
	}

	function index() {
		$data["text"] = "index construct";
		$data["site_title"] = "Test title";
		$this->load->view('index',$data);
	}
	
	function example($one="",$two="",$plus="") {
		echo $one." ".$two.$plus;
		$data["text"] = "example controller";
		$this->load->view('index',$data);
	}
}
?>