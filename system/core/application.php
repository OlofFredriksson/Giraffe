<?php
class Application
{
	private $uri;
	private $model;
	public $giraffe;
	private $error;
	private $status_message;
	function __construct($uri) {
		$this->error 			=	false;
		$this->status_message 	=	"";
		$this->uri 				=	$uri;
		$this->giraffe 			=	 Giraffe::instance();
	}

	public function loadController() {
		$controller_file = PATH."/site/controllers/".$this->uri['controller'].".php";
		if(!file_exists($controller_file)) {
			throw new Exception('Controller does not exist');
		}
		
		require_once($controller_file);
		$controller = new $this->uri["controller"]();
		if(isset($this->uri['method']) && method_exists($controller, $this->uri['method'])) {
			$controller->{$this->uri['method']}($this->uri['var']);
		} else if(isset($this->uri['method']) && !method_exists($controller, $this->uri['method'])) {
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