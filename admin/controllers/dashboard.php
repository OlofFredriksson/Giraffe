<?php
class dashboard extends Controller {
	
	public function index() {
		$data["site_title"] = "Admin";
		$this->load->view('index',$data);
	}
}
?>