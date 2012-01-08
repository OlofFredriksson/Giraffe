<?php
class Auth {
	// Makes it possible to use a secondary or external database
	private $db;
	private function __construct($db = null) {
		global $giraffe;
		// If $db is null, we take same database as Giraffe use
		if(empty($db)) {
			$this->db = $giraffe->db
		}
	}
}
?>