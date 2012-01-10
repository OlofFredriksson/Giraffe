<?php
class Admin {
	private $db;
	private $site_name;
	public $config;
	
	public function __construct() {
		$this->db = Database::Instance();
	}
	
	public function set_site_name($name) {
		$this->site_name = $this->db->escape($name);
		$this->update_config();
	}
	
	private function update_config() {
		$this->config = array();
		$sql = "SELECT * FROM ".DB_PREFIX."options WHERE site = '".$this->site_name."' OR site = '' ORDER BY site ASC";
		$query = $this->db->get_results($sql);
		while ($row = $query->fetch_object()) {
				$this->config[$row->option_key] = trim($row->option_value);
		}
	}

	public function update_value($key,$value) {
		$key = $this->db->escape($key);
		$value = $this->db->escape($value);
		$sql = "UPDATE ".DB_PREFIX."options SET option_value = '".$value."' WHERE option_key = '".$key."' AND site = '".$this->site_name."'";
		$query = $this->db->query($sql);
	}
}
?>