<?php
class error_404 extends Controller {
	function index() {
		$data["site_title"] = "404";
		$file_name = SITE_PATH."/themes/".get_siteInfo("theme")."/404.php";
		if (file_exists($file_name)) {
			require_once($file_name);
		} else {
			echo "404 - File not found";
		}
		$this->loadView('404',$data);
	}
}
?>