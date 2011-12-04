<?php
class Giraffe {

	private static $giraffe;
	private $config;
	private $db;
	private $theme;
	private $array_uri;
	public $header;
	private $status;
	public static $instance = NULL;
	
	private function __construct() {
		// Create database connection
		$this->db = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
		if ($this->db->connect_errno) {
			echo "<h2>Database connection failed, please check if your system/config.php is correct. Mysql Error: ".$this->db->connect_error."</h2>";
			exit();
		}
		$status = true;
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

	public function frontController() {
		//Take the initial PATH.
		$path = $this->config["url_prefix"];
		$uri = $_SERVER['REQUEST_URI'];

		// Remove prefix from URI
		$uri = str_replace($path,"",$uri);

		# TBD - I DONT LIKE THIS
		//creates an array from the rest of the URL
		$array_uri = preg_split('[\\/]', $uri, -1, PREG_SPLIT_NO_EMPTY);
		print_r($array_uri);
		
		
		//Here, we will define what is what in the URL
		if(!empty($array_uri[0])) {
			$array_tmp_uri[0] = strtolower($array_uri[0]);
			$this->array_uri['controller'] = $array_uri[0];
		} else {
			// Get default controller from database config
			$this->array_uri['controller'] = $this->config['default_controller'];
		}
		if(!empty($array_uri[1])) {
			$array_uri[1] = strtolower($array_uri[1]);
			$this->array_uri['method']	= $array_uri[1];
		}
		if(!empty($array_tmp_uri[2])) {
			$this->array_uri['var'] = $array_uri[2];
		}
		
	}
	public function templateEngine() {
		// Loads the application
		$application = new Application($this->array_uri);
	}
	public function getConfig() {
		return $this->config;
	}
}
?>