<?php
class Giraffe {

	private static $giraffe;
	private $controller;
	private $site_name;
	private $debug = array();
	private $config;
	private $theme;
	public $uri = "";
	public $request_handler;
	private $uri_array = array();
	public $db;
	public $header;
	public $auth;
	public static $instance = NULL;
	
	/*The config variable is optional and is if you want to override settings from the database, so if you send in a value in $config[theme], the site will use what instead for the Database value.
	A temporary solution until I found a better alternative. */
	private function __construct($site_name, $site_config = "") {
		// Create new session
		session_start();
		
		$this->db = Database::instance();
		$this->auth = new Auth($this->db,DB_PREFIX);
		$this->request_handler = new RequestHandler();
		
		// Get site options from database
		if(is_array($site_config) && count($site_config) > 0) {
			$this->config = $site_config;
		}
		
		
		$this->site_name = $this->db->escape($site_name);
		// The ORDER BY makes so it takes the 'global' variables first, and then site specific so it could  be override.
		$sql = "SELECT * FROM ".DB_PREFIX."options WHERE site = '".$this->site_name."' OR site = '' ORDER BY site ASC";
		
		$query = $this->db->get_results($sql);
		while ($row = $query->fetch_object()) {
			if(!isset($this->config[$row->option_key])) {
				$this->config[$row->option_key] = trim($row->option_value);
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
	// Phase 1, Controll uri and prevent duplicate content
	public function frontController() {
		$uri = substr($_SERVER['REQUEST_URI'],1); // Assign uri and remove first slash
		$this->debug["raw_uri"] = $uri;
		
		// If we send in a base value, for example in the adminpanel or placing the site inside a subfolder, we need to remove it from the uri before the frontcontroller can start.
		$base = $this->config["base"];
		if(!empty($base) && starts_with($uri,$base)) {
			$uri = substr($uri, strlen($base));
		}
		
		// First of all, we check if it's a route with this uri to another page. In this MVC, routes got higher priority and we ignore the prefix and suffix test. If we find a match here we go directly to phase 2.
		if($route = $this->get_route($uri)) {
			// If the route is external, go to that page
			if ($route->external == 1) {
				header("Location: ".$route->route_to);
				exit;
			}
			// Or run the templateEngine again with the new uri
			else {
				$this->uri = $route->route_to;
			}
		} else {
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
			$this->uri = $uri;
			
		}
		//Creates an array from the rest of the URL
		$this->uri_array = preg_split('[\\/]', $this->uri, -1, PREG_SPLIT_NO_EMPTY);
	
	}
	// Phase 2, it's time to render the page based on the uri, this function also handle can urls
	public function engine($passed_uri = "") {
		$this->debug["passed_uri"] = $passed_uri;
		if(!empty($passed_uri)) {
			$this->uri = $passed_uri;
		}
		$this->debug["actual_uri"] = $this->uri;
		
		
		// If the load application throws an error, display the 404 page
		
		// Login controll, if the config var 'auth' refers to a controller, we force user to se that controller instead if the wanted
		if(!empty($this->config["auth"]) && !$this->auth->isLoggedIn()) {
			$this->uri_array[0] = $this->config["auth"];
			$this->debug["login_status"] = "Not logged in";
		}
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
		$config_values = array("theme", "auth", "base", "default_controller", "default_controller_clean_urls","url_suffix","url_prefix","url");
		foreach ($config_values as $value) {
 			if(!isset($this->config[$value])) {
				echo "Required config variables is missing, please check your database. Required variables: <br />";
				// Don't looks pretty, but it works for now..
				print_r($config_values);
				die();
			}
		}
		 
	}
	
	private function get_route($can_url) {
		$value = "";
		$can = $this->db->escape($can_url);
		$result = $this->db->query("SELECT * FROM ".DB_PREFIX."routes WHERE route = '{$can}' AND active='1' AND site = '".$this->site_name."' ORDER BY route DESC LIMIT 1");
		if (is_object($result)) {
		$value = $result->fetch_object();
		}
		return $value;
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
}
?>