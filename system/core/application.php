<?php
class Application
{
	private $uri;
	private $model;
	public $giraffe;
	
	public function __construct($uri) {
		$this->uri 				=	$uri;
		$this->giraffe 			=	Giraffe::instance();
	}

	public function loadApplication() {
		$default_controller_name = get_siteInfo("default_controller");
		$default_controller_clean_urls = get_siteInfo("default_controller_clean_urls"); # TBD - to long and ugly name
		
		// If uri is empty, load standard controller
		if(empty($this->uri[0])) {
			$controller = $this->loadController($default_controller_name);
			$controller->index();
		} else {
			try {
				$controller = $this->loadController($this->uri[0]);
			} catch (Exception $e) {
				// System cant find a controller with that name, if default_controller_clean_urls not is empty, send value 0 to the function in default controller
				if(!empty($default_controller_clean_urls)) {
					$controller = $this->loadController($default_controller_name);
					if(method_exists($controller,$default_controller_clean_urls)) {
						$controller->{$default_controller_clean_urls}($this->uri[0]);
					} else {
						throw new Exception('Clean urls default controllers function not found!');
					}
				} else {
					throw new Exception('Function does not exist');
				}
			}
			
			if(isset($this->uri[1]) && method_exists($controller, $this->uri[1])) {
				$variables = array_slice($this->uri, 2); 
				call_user_func_array(array($controller, $this->uri[1]), $variables);
				
			} else if(isset($this->uri[1]) && !method_exists($controller, $this->uri[1])) {
				
			
			} else {
				$controller->index();
			}
		}
	}

	private function loadController($controller_name) {
		$controller_file = PATH."/site/controllers/".$controller_name.".php";
		if(!file_exists($controller_file) && !class_exists($controller_name)) {
				throw new Exception('Controller does not exist');
		}
		require_once($controller_file);
		$controller = new $controller_name();
		return new $controller();
	}
}
?>