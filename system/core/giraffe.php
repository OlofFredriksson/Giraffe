<?php
class Giraffe {

	private static $giraffe;
	private $config;
	public $db;
	private $theme;
	private $array_uri;
	private $uri_array;
	public $header;
	private $status;
	private $request_handler;
	private $controller;
	public static $instance = NULL;
	
	/*The config variable is optional and is if you want to override settings from the database, so if you send in a value in $config[theme], the site will use what instead for the Database value.
	A temporary solution until I found a better alternative. */
	private function __construct($site_config = "") {
		
		// Create new session
		session_start();
		$this->db = Database::instance();
		$this->request_handler = new RequestHandler();
		
		$status = true;
		
		// Get site options from database
		if(is_array($site_config) && count($site_config) > 0) {
			$this->config = $site_config;
		}
		$query = $this->db->get_results("SELECT * FROM ".DB_PREFIX."options");
		while ($row = $query->fetch_object()) {
			if(!isset($this->config[$row->option])) {
				$this->config[$row->option] = $row->value;
			}
		}
		// Get specific theme options
		require_once(SITE_PATH."/themes/".$this->config["theme"]."/theme.php");
	}

	// Singleton
	public static function instance($config = "") {
		if(!isset(self::$instance)) {
			self::$instance = new Giraffe($config);
		}
		return self::$instance;
	}

	public function frontController() {
	
		$uri = $_SERVER['REQUEST_URI'];
		$uri = substr($uri,1); // Remove first slash
		
		// If we send in a base value, for example in the adminpanel, we need to remove it from the uri before the frontcontroller can start.
		$base = $this->config["base"];
		if(!empty($base) && starts_with($uri,$base)) {
			$uri = substr($uri, strlen($base));
		}
		
		// Remove duplicate content if prefix or suffix not is empty
		if(!empty($uri) && $uri == $this->config["url_prefix"].$this->config["url_suffix"]) {
			$this->request_handler->forwardTo($this->config["url"],301);
		}
		
		// If uri is same as default controller, send back user to prevent duplicate content
		if($uri == $this->config["url_prefix"].$this->config["default_controller"].$this->config["url_suffix"]) {
			$this->request_handler->forwardTo($this->config["url"],301);
		}
		// The last check, if the uri validates the regex pattern based on prefix and suffis
		$pattern = "/^(".preg_quote($this->config["url_prefix"],'/')."[0-9a-z\-\_\/]*".preg_quote($this->config["url_suffix"],'/').")$/i";
		if (!empty($uri) && !preg_match($pattern, $uri)) {
			fourofour("Wrong format on url");
		}
		
		// Remove prefix from URI
		$uri = str_replace($this->config["url_prefix"],"",$uri);
		
		// Remove suffix from URI
		$uri = str_replace($this->config["url_suffix"],"",$uri);
	
	
		//creates an array from the rest of the URL
		$array_uri = preg_split('[\\/]', $uri, -1, PREG_SPLIT_NO_EMPTY);
		$this->uri_array = $array_uri;
	}
	
	private function loadApplication() {
		$default_controller_name = get_siteInfo("default_controller");
		$default_controller_clean_urls = get_siteInfo("default_controller_clean_urls"); # TBD - to long and ugly name
		
		// If uri is empty, load standard controller
		if(empty($this->uri_array[0])) {
			$this->controller = $this->loadController($default_controller_name);
			$this->controller->index();
		} else {
			try {
				$this->controller = $this->loadController($this->uri_array[0]);
			} catch (Exception $e) {
				
				// System cant find a controller with that name, if default_controller_clean_urls not is empty, send value 0 to the function in default controller
				if(!empty($default_controller_clean_urls)) {
					$this->controller = $this->loadController($default_controller_name);
					if(method_exists($this->controller,$default_controller_clean_urls)) {
						$this->controller->{$default_controller_clean_urls}($this->uri_array[0]);
					} else {
						throw new Exception('Clean urls default controllers function not found!');
					}
				}
				 else {
					throw new Exception('Controller does not exist');
				}
			}
			if(isset($this->uri_array[1]) && method_exists($this->controller, $this->uri_array[1])) {
				$variables = array_slice($this->uri_array, 2); 
				call_user_func_array(array($this->controller, $this->uri_array[1]), $variables);
				
			} else if(isset($this->uri_array[1]) && !method_exists($this->controller, $this->uri_array[1])) {
				throw new Exception('Function does not exist');
			
			} else {
				$this->controller->index();
			}
		}
	}

	private function loadController($controller_name) {
		$controller_file = SITE_PATH."/controllers/".$controller_name.".php";
		if(!file_exists($controller_file) && !class_exists($controller_name)) {
			throw new Exception('Controller does not exist');
		}
		require_once($controller_file);
		if(!class_exists($controller_name)) {
			throw new Exception('Controller does not exist');
		}
		$controller = new $controller_name();
		return new $controller();
	}
	
	
	
	public function templateEngine() {
		// If the load application throws an error, display the 404 page
		try {
			$this->loadApplication($this->uri_array);
		} catch (Exception $e) {
			fourofour($e->getMessage());
		}
	}
	public function getConfig() {
		return $this->config;
	}
	
	public function getController() {
		return $this->controller;
	}
	
	public function debug() {
		// Comming function
		return null;
	}
}
?>