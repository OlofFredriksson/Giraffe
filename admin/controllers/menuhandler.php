<?php
class Menuhandler extends Controller {
	private $giraffe;

	public function __construct() {
		parent::__construct();
		$this->giraffe = Giraffe::Instance();
		$this->load->model("Admin","admin");
		
		// We are pretty doomed if user changes the default site name
		$this->admin->set_site_name("default");
	}
	
	public function index() {
		$data["list"] = $this->admin->get_menu_table();
		$data["site_title"] = "Menu handler";
		$data["site_config"] = $this->admin->config;
		$url = get_siteinfo("theme_url");
		$data["header_inner"] = <<<EOD
		<script type="text/javascript" src="$url/includes/jquery.tablesorter.min.js"></script> 
		<script type="text/javascript">
			$(document).ready(function()  { 
				$("#table").tablesorter(); 
			} 
			); 
		</script>
EOD;
		$this->load->view('menu_handler',$data);
	}
	
	public function create() {
		$id = $this->admin->create_link_empty();
		$this->giraffe->request_handler->forwardTo("menuhandler/edit/".$id);
	}
	
	public function delete($id) {
		if(isset($id) && is_numeric($id) && $this->giraffe->auth->isLoggedIn()) {
			$this->admin->delete_link($id);
			$this->giraffe->request_handler->forwardTo("menuhandler/");
		}
	}
	public function edit($id ="") {
		if(isset($_POST["id"]) && is_numeric($_POST["id"])) {
			$this->admin->update_link($_POST["id"],$_POST["site"],$_POST["title"],$_POST["url"],$_POST["anchor"],$_POST["menu_group"],$_POST["menu_priority"]);
			$this->giraffe->request_handler->forwardTo("menuhandler/edit/".$_POST["id"]);
		}
		$data["site_title"] = "Edit link";
		$data["link"] = $this->admin->get_link_with_id($id);
		$this->load->view('menu_handler_edit',$data);
	}
}
?>