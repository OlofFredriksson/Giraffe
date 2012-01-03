<?php
class post extends Controller {
	private $data = array();
	function __construct() {
		parent::__construct();
		$this->data["site_title"] = "Post";
	}

	function index() {
		$this->loadView('post',$this->data);
	}
	
	function create() {
		$this->loadView('post',$this->data);
	}
}
?>