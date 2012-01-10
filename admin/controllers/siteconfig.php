<?php
class siteconfig extends Controller {
	private $giraffe;

	public function __construct() {
		parent::__construct();
		$this->giraffe = Giraffe::Instance();
		$this->load->model("Admin","admin");
		
		// We are pretty doomed if user changes the default site name
		$this->admin->set_site_name("default");
	}
	
	public function index() {
		if(isset($_POST["title"])) {
			$this->admin->update_value("title",$_POST["title"]);
			$this->admin->update_value("sub_title",$_POST["sub_title"]);
			$this->giraffe->request_handler->forwardTo("siteconfig/");
		}
		$data["site_title"] = "Site configuration";
		$data["site_config"] = $this->admin->config;
		$this->load->view('siteconfig',$data);
	}
}
?>