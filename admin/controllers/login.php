<?php
class login extends Controller {

	public $giraffe;
	private $data = array();
	function __construct() {
		parent::__construct();
		global $giraffe;
		$this->giraffe = $giraffe;
		$this->data["site_title"] = "Login - Giraffe MVC";
		$this->data["info_bar"] = "";
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
		$this->load->view('login',$this->data);
	}
	
	public function error($type = "") {
		$this->data["info_bar"] = '<div class="alert-message error"><p><strong>Oh snap!</strong> Wrong password or password</p></div>';
		$this->load->view('login',$this->data);
	}
	
	public function success() {
		$this->data["info_bar"] = '<div class="alert-message success"><p><strong>Welcome '.$_SESSION["auth_username"].'</strong> You successfully logged in.</p></div>';
		$this->load->view('login',$this->data);
	}
	public function logout() {
		$this->giraffe->auth->logout();
		$this->giraffe->request_handler->forwardTo("login/");
	}
}
?>