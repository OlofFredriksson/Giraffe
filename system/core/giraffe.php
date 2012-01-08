<?php
class Giraffe {

	private static $giraffe;
	private $config;
	public $db;
	private $theme;
	private $array_uri;
	private $uri_array;
	public $header;
	private $request_handler;
	private $controller;
	private $debug = array();
	public static $instance = NULL;
	
	/*The config variable is optional and is if you want to override settings from the database, so if you send in a value in $config[theme], the site will use what instead for the Database value.
	A temporary solution until I found a better alternative. */
	private function __construct($site_name, $site_config = "") {
		
		// Create new session
		session_start();
		$this->db = Database::instance();
		$this->request_handler = new RequestHandler();
		
		// Get site options from database
		if(is_array($site_config) && count($site_config) > 0) {
			$this->config = $site_config;
		}
		
		
		$site_name = $this->db->escape($site_name);
		// The ORDER BY makes so it takes the 'global' variables first, and then site specific so you could override.
		$sql = "SELECT * FROM ".DB_PREFIX."options WHERE site = '".$site_name."' OR site = '' ORDER BY site ASC";
		
		$query = $this->db->get_results($sql);
		while ($row = $query->fetch_object()) {
			if(!isset($this->config[$row->option])) {
				$this->config[$row->option] = trim($row->value);
			}
		}
		// Before we begin to build the site, lets do a check so at least some of the variables is defined
		$this->analyseConfigValues();
		
		// Get specific theme options
		require_once(SITE_PATH."/themes/".$this->config["theme"]."/theme.php");
	}

	// Singleton
	public static function instance($name = "",$config = "") {
		if(!isset(self::$instance)) {
			self::$instance = new Giraffe($name,$config);
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
		// The last check, if the uri validates the regex pattern based on prefix and suffix
		$pattern = "/^(".preg_quote($this->config["url_prefix"],'/')."[0-9a-z\-\_\/]*".preg_quote($this->config["url_suffix"],'/').")$/i";
		if (!empty($uri) && !preg_match($pattern, $uri)) {
			$this->debug["frontcontroller"] = "Wrong format on url";
			$this->fourofour();
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
			exit;
		} else {
			try {
				$this->controller = $this->loadController($this->uri_array[0]);
			} catch (Exception $e) {
				
				// System cant find a controller with that name, if default_controller_clean_urls not is empty, send value 0 to the function in default controller
				if(isset($default_controller_clean_urls)) {
					$this->controller = $this->loadController($default_controller_name);
					if(method_exists($this->controller,$default_controller_clean_urls)) {
						$this->controller->{$default_controller_clean_urls}($this->uri_array[0]);
						exit;
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
				exit;
				
			} else if(isset($this->uri_array[1]) && !method_exists($this->controller, $this->uri_array[1])) {
				throw new Exception('Function does not exist');
			
			} else {
				$this->controller->index();
				exit;
			}
		}
	}

	private function loadController($controller_name,$path = "") {
		if(empty($path)) {
			$path = SITE_PATH."/controllers/";
		}
		$controller_file = $path.$controller_name.".php";
		if(!file_exists($controller_file) && !class_exists($controller_name)) {
			throw new Exception('Controller does not exist');
		}
		require_once($controller_file);
		if(!class_exists($controller_name)) {
			throw new Exception('Controller does not exist');
		}
		$controller = new $controller_name();
		return $controller;
	}

	public function templateEngine() {
		// If the load application throws an error, display the 404 page
		try {
			$this->loadApplication($this->uri_array);
		} catch (Exception $e) {
			$this->debug["templateEngine"] = $e->getMessage();
			$this->fourofour();
		}
	}
	public function getConfig() {
		return $this->config;
	}
	
	public function getController() {
		return $this->controller;
	}
	
	public function debug() {
		if(ENVIRONMENT == "development") {
			print_r($this->debug);
			echo "<pre>";
			print_r($this->getConfig());
			echo "</pre>";
		}
	}
	
	private function fourofour($debug = "") {
		
		// Set the correct header
		header('HTTP/1.0 404 Not Found');
		
		// First check if user has defined a custom 404 controller, otherwise we use the standard from Giraffe mvc
		try {
			$controller_404 = $this->loadController("error_404");
		} catch (Exception $e) {
			require_once(SYSTEM_PATH."/controllers/error_404.php");
			$this->controller = new error_404();
		}
		
		//$this->controller = $controller_404;
		$this->controller->index();
		exit;
	}
	
	// It requires some variables to build this page, and if these are not defined, we could interrupt construction
	private function analyseConfigValues() {
		$config_values = array("theme", "auth", "base", "default_controller", "default_controller_clean_urls");
		foreach ($config_values as $value) {
 			if(!isset($this->config[$value])) {
				echo "Required config variables is missing, please check your database. Required variables: <br />";
				print_r($config_values);
				die();
			}
		}
		 
	}
}
?>