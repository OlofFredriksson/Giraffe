<?php
class Database {
	public static $instance = NULL;
	private $db;
	private $prefix;
	private $lastQuery;
	private function __construct() {
		$this->prefix = DB_PREFIX;
		// Create database connection
		$this->db = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
		if ($this->db->connect_errno) {
			die("<h2>Database connection failed, please check if your system/config.php is correct. Mysql Error: ".$this->db->connect_error."</h2>");
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
	
	public function __destruct() {
		$this->db->close();
	}
	// For now, this does the same as the query function
	public function get_results($query) {
		$this->lastQuery = $this->db->query($query) or die($this->db->error);
		return $this->lastQuery;
	}
	
	public function query($query) {
		$this->lastQuery = $this->db->query($query) or die($this->db->error);
		return $this->lastQuery;
	}
	
	public function multiQuery($query) {
		$this->db->multi_query($query);
		do {
			} while ($this->db->next_result());
	}
	public function insert($query) {
		$this->lastQuery = $this->db->query($query) or die($this->db->error);
		return $this->db->insert_id;
	}
	
	public function escape($value) {
		return $this->db->real_escape_string($value);
	}

}
?>
