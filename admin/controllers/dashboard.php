<?php
class dashboard extends Controller {
	
	function index() {
		$data["site_title"] = "Admin";
		$this->load->view('index',$data);
	}
}
?>