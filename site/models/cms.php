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
	
	public function get_post_with_id($id) {
		
		$post = array();
		$id = $this->db->escape($id);
		$query = "SELECT * FROM ".DB_PREFIX."post WHERE id = '".$id."'";
		$result = $this->db->get_results($query);
		if(!$result->num_rows == 1) {
			throw new Exception('Post with id '.$id.' is not found');
		}
		$row = $result->fetch_object();
		$post["slug"] = $row->slug;
		$post["title"] = $row->title;
		$post["content"] = $row->content;
		$post["id"] = $row->id;
		$post["date"] = $row->date;
		return $post;
	}
	public function update_post($id, $title,$slug,$content) {
		$id = $this->db->escape($id);
		$title = $this->db->escape($title);
		$slug = $this->db->escape($slug);
		$content = $this->db->escape($content);
		$query = "UPDATE ".DB_PREFIX."post SET title = '".$title."', slug = '".$slug."', content = '".$content."' WHERE id = '".$id."' LIMIT 1";
		return $this->db->query($query);
	}
	public function get_post_list() {
		$query = "SELECT * FROM ".DB_PREFIX."post";
		return $this->db->query($query);
	}
	
	public function create_post_empty($id_user) {
		$query = "INSERT INTO ".DB_PREFIX."post (idUser,date) VALUES ('".$id_user."',NOW())";
		return $this->db->insert($query);
	}

}
?>