<?php
class Menuhandler extends Controller {
	private $giraffe;
	private $data;
	public function __construct() {
		parent::__construct();
		$this->giraffe = Giraffe::Instance();
		$this->load->model("Admin","admin");
		
		// We are pretty doomed if user changes the default site name
		$this->admin->set_site_name("default");
		$this->data["site_title"] = "Menu handler";
	}
	
	public function index() {
		$this->data["list"] = $this->admin->get_menu_table();
		$this->data["site_config"] = $this->admin->config;
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
		$this->load->view('menu_handler',$this->data);
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
		$this->data["site_title"] = "Edit link";
		$this->data["links"] = $this->admin->get_link_with_id($id);
		$this->data["link"] = $this->data["links"][0]; // Just get the first row 
		$this->load->view('menu_handler_edit',$this->data);
	}
}
?>