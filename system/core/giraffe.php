<?php
class Giraffe {

	private static $giraffe;
	private $config;
	private $db;
	private $theme;
	private $array_uri;
	private $uri_array;
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
		
		// Get specific theme options
		require_once(PATH."/site/themes/".$this->config["theme"]."/theme.php");
	}

	// Singleton
	public static function instance() {
		if(!isset(self::$instance)) {
			self::$instance = new Giraffe();
		}
		return self::$instance;
	}

	public function frontController() {
	
		$uri = $_SERVER['REQUEST_URI'];
		// Remove prefix from URI
		$prefix_count = 0;
		$uri = str_replace($this->config["url_prefix"],"",$uri,$prefix_count);
		
		// Remove suffix from URI
		$suffix_count = 0;
		$uri = str_replace($this->config["url_suffix"],"",$uri,$suffix_count);
	
	
		# TBD - I DONT LIKE THIS
		//creates an array from the rest of the URL
		$array_uri = preg_split('[\\/]', $uri, -1, PREG_SPLIT_NO_EMPTY);
		$this->uri_array = $array_uri;
		// Remove duplicate content if prefix or suffix not is empty -- TBD NOT WORKING 100%
		if(count($array_uri) != 0 && ((!empty($this->config["url_suffix"]) && $suffix_count == 0) || (!empty($this->config["url_prefix"]) && $prefix_count == 0))) {
			fourofour("Wrong format on url");
		}
	}
	public function templateEngine() {
		// Loads the application
		$application = new Application($this->uri_array);
		try {
		$application->loadController();
		} catch (Exception $e) {
			fourofour();
		}
	}
	public function getConfig() {
		return $this->config;
	}
}
?>