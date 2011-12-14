<?php
class dashboard extends Controller {
	function __construct() {
	}

	function index() {
		$this->loadView('index');
	}
	
	function post() {
		$this->loadView('post');
	}
}
?>