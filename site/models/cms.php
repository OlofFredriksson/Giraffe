<?php
class Cms {

	function __construct() {
	}
	public function get_post($slug) {
		global $giraffe;
		$post = array();
		$slug = $giraffe->db->real_escape_string($slug);
		$query = "SELECT * FROM ".DB_PREFIX."post WHERE slug = '".$slug."'";
		$result = $giraffe->db->query($query) or die("Query error");
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
}
?>