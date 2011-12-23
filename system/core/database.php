<?php
class Database {
	public static $instance = NULL;
	private $db;
	private $prefix;
	
	private function __construct() {
		$this->prefix = DB_PREFIX;
		// Create database connection
		$this->db = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
		if ($this->db->connect_errno) {
			echo "<h2>Database connection failed, please check if your system/config.php is correct. Mysql Error: ".$this->db->connect_error."</h2>";
			exit();
		}
		
		// Force database to communicate with UTF-8 as charset
		$this->db->set_charset('utf8');
	}

	// Singleton
	public static function instance() {
		if(!isset(self::$instance)) {
			self::$instance = new Database();
		}
		return self::$instance;
	}
	
	public function get_results($query) {
		$result = $this->db->query($query) or die($this->db->error);
		return $result;
	}
	
	public function escape($value) {
		return $this->db->real_escape_string($value);
	}

}
?>
