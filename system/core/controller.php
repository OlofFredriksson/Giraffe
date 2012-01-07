<?php
class Controller {

	public $load;
	private static $instance;
	private $cached_vars = array();
	public function __construct() {
		$this->load = new Load($this);
	}
	
	// Singleton
	public static function &get_instance() {
		if(!isset(self::$instance)) {
			self::$instance = new Controller();
		}
		return self::$instance;
	}

}
?>