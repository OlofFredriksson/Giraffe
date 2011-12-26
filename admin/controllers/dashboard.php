<?php
class dashboard extends Controller {
	function __construct() {
	}

	function index() {
		$this->loadView('index');
	}
}
?>