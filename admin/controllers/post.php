<?php
class post extends Controller {
	function __construct() {
	}

	function index() {
		$this->loadView('post');
	}
	
	function create() {
		$this->loadView('post');
	}
}
?>