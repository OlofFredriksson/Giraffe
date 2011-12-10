<?php
class Giraffe {

	private static $giraffe;
	private $config;
	private $db;
	private $theme;
	private $array_uri;
	private $uri_array;
	public $header;
	private $status;
	private $request_handler;
	public static $instance = NULL;
	
	private function __construct() {
		session_start();
		// Create database connection
		$this->db = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
		if ($this->db->connect_errno) {
			echo "<h2>Database connection failed, please check if your system/config.php is correct. Mysql Error: ".$this->db->connect_error."</h2>";
			exit();
		}
		$this->request_handler = new RequestHandler();
		$this->db->set_charset("utf8");
		$status = true;
		// Get site options from database
		$query = $this->db->query("SELECT * FROM ".DB_PREFIX."options") or die($this->db->error);
		while ($row = $query->fetch_object()) {
			$this->config[$row->option] = $row->value;
		}
		
		// Get specific theme options
		require_once(PATH."/site/themes/".$this->config["theme"]."/theme.php");
	}

	// Singleton
	public static function instance() {
		if(!isset(self::$instance)) {
			self::$instance = new Giraffe();
		}
		return self::$instance;
	}

	public function frontController() {
	
		$uri = $_SERVER['REQUEST_URI'];
		$uri = substr($uri , 1); // Remove first slash
		$pattern = "/^(".$this->config["url_prefix"]."[0-9a-z\-\_\/]*".$this->config["url_suffix"].")$/i";
		// Remove duplicate content if prefix or suffix not is empty
		if(!empty($uri) && $uri == $this->config["url_prefix"].$this->config["url_suffix"]) {
			$this->request_handler->forwardTo($this->config["url"],301);
		}
		
		// If uri is same as default controller, send back user to prevent duplicate content
		else if($uri == $this->config["default_controller"]) {
			echo "hit";
			$this->request_handler->forwardTo($this->config["url"],301);
		}
		else if (!empty($uri) && !preg_match($pattern, $uri)) {
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
			$controller = $this->loadController($default_controller_name);
			$controller->index();
		} else {
			try {
				$controller = $this->loadController($this->uri_array[0]);
			} catch (Exception $e) {
				// System cant find a controller with that name, if default_controller_clean_urls not is empty, send value 0 to the function in default controller
				if(!empty($default_controller_clean_urls)) {
					$controller = $this->loadController($default_controller_name);
					if(method_exists($controller,$default_controller_clean_urls)) {
						$controller->{$default_controller_clean_urls}($this->uri_array[0]);
					} else {
						throw new Exception('Clean urls default controllers function not found!');
					}
				} else {
					throw new Exception('Function does not exist');
				}
			}
			
			if(isset($this->uri[1]) && method_exists($controller, $this->uri[1])) {
				$variables = array_slice($this->uri_array, 2); 
				call_user_func_array(array($controller, $this->uri_array[1]), $variables);
				
			} else if(isset($this->uri_array[1]) && !method_exists($controller, $this->uri_array[1])) {
				throw new Exception('Function does not exist');
			
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
	
	
	
	public function templateEngine() {
		
		try {
			$this->loadApplication($this->uri_array);
		} catch (Exception $e) {
			fourofour($e->getMessage());
		}
	}
	public function getConfig() {
		return $this->config;
	}
}
?>