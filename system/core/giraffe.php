<?php
class Giraffe {

	private static $giraffe;
	private $config;
	private $db;
	public $header;
	private $theme;
	public static $instance = NULL;
	private function __construct() {
		// Create database connection
		$this->db = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
		if ($this->db->connect_errno) {
			echo "Database connection failed, please check if your system/config.php is correct. Mysql Error: ".$this->db->connect_error;
		exit();
		}
		
		// Get site options from database
		$query = $this->db->query("SELECT * FROM ".DB_PREFIX."options") or die($this->db->error);
		while ($row = $query->fetch_object()) {
			$this->config[$row->option] = $row->value;
		}
	}
	
	// Singleton
	public static function instance() {
		if(!isset(self::$instance)) {
			self::$instance = new Giraffe();
		}
		return self::$instance;
	}
	public function run() {

		//Take the initial PATH.
		$path = ""; 
		$url = $_SERVER['REQUEST_URI'];
		$url = str_replace($path,"",$url);

		# TBD - I DONT LIKE THIS
		//creates an array from the rest of the URL
		$array_tmp_uri = preg_split('[\\/]', $url, -1, PREG_SPLIT_NO_EMPTY);

		//Here, we will define what is what in the URL
		if(!empty($array_tmp_uri[0])) {
			$array_uri['controller'] = $array_tmp_uri[0];
		} else {
			// Get default controller from database config
			$array_uri['controller'] = $this->config['default_controller'];
		}
		if(!empty($array_tmp_uri[1])) {
			$array_uri['method']	= $array_tmp_uri[1];
		}
		if(!empty($array_tmp_uri[2])) {
			$array_uri['var'] = $array_tmp_uri[2];
		}
		
	
		// Loads our controller
		$application = new Application($array_uri);
	}
	
	public function get_config() {
		return $this->config;
	}
}
?>