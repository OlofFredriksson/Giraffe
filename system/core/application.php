<?php
class Application
{
	private $uri;
	private $model;
	public $giraffe;
	function __construct($uri) {
	
		$this->uri = $uri;
		$this->giraffe = Giraffe::instance();
		$this->loadController();

	}

	public function loadController() {
		$controller_file = PATH."/site/controllers/".$this->uri['controller'].".php";
		if(!file_exists($controller_file)) {
			die("Controller does not exist");
		}
		
		require_once($controller_file);
		$controller = new $this->uri["controller"]();
		if(isset($this->uri['method']) && method_exists($controller, $this->uri['method'])) {
			$controller->{$this->uri['method']}($this->uri['var']);
		} else if(isset($this->uri['method']) && !method_exists($controller, $this->uri['method'])) {
			die("Function does not exist");
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