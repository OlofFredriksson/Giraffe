<?php
class login extends Controller {

	public $giraffe;
	function __construct() {
		parent::__construct();
		global $giraffe;
		$this->giraffe = $giraffe;
	}
	
	public function index() {
		if(isset($_POST["username"]) && isset($_POST["password"])) {
			if($this->giraffe->auth->login($_POST["username"],$_POST["password"])) {
				$this->giraffe->request_handler->forwardTo("login/success");
			}
			else {
				$this->giraffe->request_handler->forwardTo("login/error");
			}
		}
		$data["site_title"] = "Login - Giraffe MVC";
		$data["info_bar"] = "";
		$this->load->view('login',$data);
	}
	
	public function error($type = "") {
		$data["site_title"] = "Login - Giraffe MVC";
		$data["info_bar"] = '<div class="alert-message error"><p><strong>Oh snap!</strong> Wrong password or/and password</p></div>';
		$this->load->view('login',$data);
	}
	
	public function success() {
		$data["site_title"] = "Login - Giraffe MVC";
		$data["info_bar"] = '<div class="alert-message success"><p><strong>Welcome '.$_SESSION["auth_username"].'</strong> You successfully logged in.</p></div>';
		$this->load->view('login',$data);
	}
	public function logout() {
		$this->giraffe->auth->logout();
		$this->giraffe->request_handler->forwardTo("login/");
	}
}
?>