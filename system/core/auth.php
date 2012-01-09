<?php
class Auth {
	// Makes it possible to use a secondary or external database
	private $db;
	private $prefix;
	public function __construct($db = null,$prefix = "") {
		global $giraffe;
		$this->prefix = $prefix;
		$this->db = $db;
		// If $db is null, we take same database as Giraffe use
		if(empty($db)) {
			$this->db = $giraffe->db;
		}
	}
	
	public function isLoggedIn() {
		$logged_in = false;
		
		// Not really a good way to do this, but works for now..  ;)
		if(isset($_SESSION["auth_id"])) {
			$logged_in = true;
		}
		return $logged_in;
	}
	
	public function login($username,$password) {
		$success = false;
		$username = $this->db->escape($username);
		$password= $this->db->escape($password);
		$salted_password = $this->saltPassword($password);
		$result = $this->db->query("SELECT * FROM ".$this->prefix."users WHERE username = '".$username."' AND password = '".$salted_password."'");
		
		// Check if result contains exactly one match
		if($result->num_rows == 1) {
			$user = $result->fetch_assoc();
			$success = true;
			$_SESSION["auth_username"] = $user["username"];
			$_SESSION["auth_id"] = $user["id"];
		}
		return $success;
	}
	
	public function logout() {
		unset($_SESSION["auth_username"]);
		unset($_SESSION["auth_id"]);
	}
	
	private function saltPassword($password) {
		return sha1(sha1(AUTH_SALT).$password.AUTH_SALT);
	}
	
	public function register($username, $password, $email, $real_name) {
		$username = $this->db->escape($username);
		$password= $this->db->escape($password);
		$email = $this->db->escape($email);
		$real_name = $this->db->escape($real_name);
		$salted_password = $this->saltPassword($password);
		$query = "INSERT INTO ".DB_PREFIX."users (username, password, email, real_name, created) VALUES ('".$username."', '".$salted_password."', '".$email."', '".$real_name."', NOW())";
		return $this->db->query($query);
	}
	
	public function getUsername($id) {
		$name = "";
		$query = "SELECT * FROM ".$this->prefix."users WHERE id = '".$id."' LIMIT 1";
		$result = $this->db->query($query);
		
		if($result->num_rows == 1) {
			$user = $result->fetch_assoc();
			$name = $user["username"];
		}
		return $name;
	}
}
?>