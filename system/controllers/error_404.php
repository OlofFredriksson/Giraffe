<?php
class error_404 extends Controller {
	function index() {
		// First, check so the current theme contains a 404 page, if not just print out simple 404 text.
		$file_name = SITE_PATH."/themes/".get_siteInfo("theme")."/404.php";
		if (file_exists($file_name)) {
			require_once($file_name);
		} else {
			echo "404 - File not found";
		}
		$data["site_title"] = "404";
		$this->loadView('404',$data);
	}
}
?>