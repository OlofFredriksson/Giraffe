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
	
	public function get_menu_table($site = "") {
		if(!empty($site)) {
			$site = $this->db->escape($site);
			$sql = "SELECT * FROM ".DB_PREFIX."menu WHERE site = '".$site."'";
		}
		else {
			$sql = "SELECT * FROM ".DB_PREFIX."menu ";
		}
		return $this->db->query($sql);
	}
	
	public function create_link_empty() {
		$query = "INSERT INTO ".DB_PREFIX."menu () VALUES();";
		return $this->db->insert($query);
	}
	
	public function delete_link($id) {
		$id = $this->db->escape($id);
		$query = "DELETE FROM ".DB_PREFIX."menu WHERE id = '".$id."' LIMIT 1 ";
		return $this->db->insert($query);
	}
	
	public function update_link($id, $site, $title, $url, $anchor, $menu_group, $menu_priority) {
		$id = $this->db->escape($id);
		$site = $this->db->escape($site);
		$title = $this->db->escape($title);
		$url = $this->db->escape($url);
		$anchor = $this->db->escape($anchor);
		$menu_group = $this->db->escape($menu_group);
		$menu_priority = $this->db->escape($menu_priority);
		$query = "UPDATE ".DB_PREFIX."menu SET site = '".$site."', title = '".$title."', url = '".$url."', anchor = '".$anchor."', menu_group = '".$menu_group."', menu_priority = '".$menu_priority."' WHERE id = '".$id."' LIMIT 1";
		return $this->db->query($query);
	}
	
	public function get_link_with_id($id) {
		
		$link = array();
		$id = $this->db->escape($id);
		$query = "SELECT * FROM ".DB_PREFIX."menu WHERE id = '".$id."'";
		$result = $this->db->get_results($query);
		if(!$result->num_rows == 1) {
			throw new Exception('Link with id '.$id.' is not found');
		}
		$row = $result->fetch_object();
		$link["id"] = $row->id;
		$link["site"] = $row->site;
		$link["title"] = $row->title;
		$link["url"] = $row->url;
		$link["anchor"] = $row->anchor;
		$link["menu_group"] = $row->menu_group;
		$link["menu_priority"] = $row->menu_priority;
		return $link;
	}
	
	public function get_region_list($site = "") {
		if(!empty($site)) {
			$site = $this->db->escape($site);
			$sql = "SELECT * FROM ".DB_PREFIX."region WHERE site = '".$site."'";
		}
		else {
			$sql = "SELECT * FROM ".DB_PREFIX."region ";
		}
		return $this->db->query($sql);
	}
	
		public function create_region_empty($site) {
		$site = $this->db->escape($site);
		$query = "INSERT INTO ".DB_PREFIX."region (site) VALUES('".$site."');";
		return $this->db->insert($query);
	}
	
	public function delete_region($id) {
		$id = $this->db->escape($id);
		$query = "DELETE FROM ".DB_PREFIX."region WHERE id = '".$id."' LIMIT 1 ";
		return $this->db->insert($query);
	}
	
	public function update_region($id, $site, $name, $content) {
		$id = $this->db->escape($id);
		$site = $this->db->escape($site);
		$name = $this->db->escape($name);
		$content = $this->db->escape($content);
		$query = "UPDATE ".DB_PREFIX."region SET site = '".$site."', name = '".$name."', content = '".$content."' WHERE id = '".$id."' LIMIT 1";
		return $this->db->query($query);
	}
	
	public function get_region_with_id($id) {
		
		$region = array();
		$id = $this->db->escape($id);
		$query = "SELECT * FROM ".DB_PREFIX."region WHERE id = '".$id."'";
		$result = $this->db->get_results($query);
		if(!$result->num_rows == 1) {
			throw new Exception('Region with id '.$id.' is not found');
		}
		$row = $result->fetch_object();
		$region["id"] = $row->id;
		$region["site"] = $row->site;
		$region["name"] = $row->name;
		$region["content"] = $row->content;
		return $region;
	}
}
?>