<?php
class Cms {
	private $db;
	function __construct() {
		$this->db = Database::Instance();
	}
	public function get_post($slug) {
		
		$post = array();
		$slug = $this->db->escape($slug);
		$query = "SELECT * FROM ".DB_PREFIX."post WHERE slug = '".$slug."'";
		$result = $this->db->get_results($query);
		if(!$result->num_rows == 1) {
			throw new Exception('Post with slug '.$slug.' is not found');
		}
		$row = $result->fetch_object();
		$post["title"] = $row->title;
		$post["content"] = $row->content;
		$post["id"] = $row->id;
		$post["date"] = $row->date;
		return $post;
	}
	
	public function get_post_list() {
		$query = "SELECT * FROM ".DB_PREFIX."post";
		return $this->db->query($query);
	}
	
	public function create_post_empty($id_user) {
		$query = "INSERT INTO ".DB_PREFIX."post (idUser) VALUES ('".$id_user."')";
		return $this->db->insert($query);
	}

}
?>