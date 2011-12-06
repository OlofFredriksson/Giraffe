<?php
class Application
{
	private $uri;
	private $model;
	public $giraffe;
	
	function __construct($uri) {
		$this->uri 				=	$uri;
		$this->giraffe 			=	Giraffe::instance();
	}

	public function loadController() {
		
		if(empty($this->uri[0])) {
			$this->uri[0] = get_siteInfo("default_controller");
		}
		$controller_file = PATH."/site/controllers/".$this->uri[0].".php";
		if(!file_exists($controller_file)) {
			throw new Exception('Controller does not exist');
		}
		
		require_once($controller_file);
		$controller = new $this->uri[0]();
		if(isset($this->uri[1]) && method_exists($controller, $this->uri[1])) {
			$variables = array_slice($this->uri, 2); 
			call_user_func_array(array($controller, $this->uri[1]), $variables);
			
		} else if(isset($this->uri[1]) && !method_exists($controller, $this->uri[1])) {
			throw new Exception('Function does not exist');
		
		} else {
			$controller->index();
		}
	}
	// TBD
	function loadModel($model) {
		require_once('model/'.$model.'.php');
		$this->$model = new $model;
	}
}
?>