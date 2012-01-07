<?php
class Load {
	private $contr;
	private $cached_vars = array();
	
	function __construct(&$controller) {
		$this->contr = &$controller;
	}
	
	public function view($view,$_data = "") {
		
		#TBD UGLY WAY TO WRITE $this->load->view from theme files
		$this->load = &$this->contr->load;
		
		if(is_array($_data) && count($_data) > 0) {
			$this->cached_vars = array_merge($this->cached_vars, $_data);
		}
		extract($this->cached_vars);
		require(SITE_PATH.'/themes/'.get_siteInfo("theme").'/'.$view.'.php');
	}
	public function model($model,$name = "") {
		if(empty($name)) {
			$name = $model;
		}
		
		$path = strtolower(SITE_PATH."/models/".$model.".php");
		if(!file_exists($path)) {
			echo $path;
			die('Model does not exist');
		}
			require_once($path);
			// Initiate model and give it a Loader
			$this->contr->$name = new $model();
			$this->contr->$name->load = new Load($this->contr->$name);
	}

}
?>