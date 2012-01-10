<?php
class error_404 extends Controller {

	function __construct() {
		parent::__construct();
	}
	function index() {
		// First, check so the current theme contains a 404 page, if not just print out simple 404 text.
		$file_name = SITE_PATH."/themes/".get_siteInfo("theme")."/404.php";
		if (file_exists($file_name)) {
			$data["site_title"] = "404";
			$data["meta_description"] = "";
			$data["meta_keywords"] = "";
			$this->load->view('404',$data);
		} else {
			echo "404 - File not found";
		}
	}
}
?>