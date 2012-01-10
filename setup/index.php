<html>
<head>
	<link href="style.css" rel="stylesheet" type="text/css">
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Giraffe install</title>
</head>
<body>
<?php
require_once("../system/includes/general.php");
require_once("../system/core/auth.php");
$config_path = '../system/config.php';
$database_path = '../system/core/database.php';


// Quick check if table's already exists..
function check_database($db) {
	if(DB_PREFIX == "") {
		die('<span class="red">DB_PREFIX cant be empty, please fix that in your config.php</span>');
	}
	$query = "SHOW TABLES";
	$result = $db->query($query);
	$count = 0;
	$rows = array();
	while($row = $result->fetch_array()) {
		array_push($rows,$row[$count]);
	}
	foreach($rows as $row) {
		if(starts_with($row,DB_PREFIX)) {
			die('<span class="red">Tables with same prefix ("'.DB_PREFIX.'") already exists... Setup aborted</span>');
		}
	}

}

function get_domain() {
		$url = 'http';
		if (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on") { 
			$url .= "s";
		}
		$url .= "://";
		if ($_SERVER["SERVER_PORT"] != "80") {
		$url .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"];
		} else {
		$url .= $_SERVER["SERVER_NAME"];
		}

		return $url;
	}

function get_base() {
	return substr(substr($_SERVER["REQUEST_URI"],1),0,-6);
}

require_once($database_path);
if(isset($_POST["url"])) {
	require_once($config_path);
	$db = Database::instance();
	$auth = new Auth($db);
	$url = $db->escape($_POST["url"]);
	$title = $db->escape($_POST["title"]);
	$sub_title = $db->escape($_POST["sub_title"]);
	$base = $db->escape($_POST["base"]);
	$url_prefix = $db->escape($_POST["url_prefix"]);
	$url_suffix = $db->escape($_POST["url_suffix"]);
	
	$username = $db->escape($_POST["username"]);
	$password = $db->escape($_POST["password"]);
	$real_name = $db->escape($_POST["real_name"]);
	$email = $db->escape($_POST["email"]);
	
	
	// Before we start, just check so table's already exists with that prefix
	check_database($db);
	$query = "
	CREATE TABLE IF NOT EXISTS `".DB_PREFIX."menu` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`menu_group` varchar(55) NOT NULL,
	`menu_priority` int(11) NOT NULL,
	`title` varchar(55) NOT NULL,
	`url` varchar(100) NOT NULL,
	`anchor` varchar(55) NOT NULL,
	`site` varchar(55) NOT NULL,
	PRIMARY KEY (`id`)
	) ENGINE=MyISAM  DEFAULT CHARSET=utf8;


	CREATE TABLE IF NOT EXISTS `".DB_PREFIX."options` (
	  `option_key` varchar(55) NOT NULL,
	  `option_value` longtext NOT NULL,
	  `site` varchar(50) NOT NULL,
	  UNIQUE KEY `option` (`option_key`,`site`)
	) ENGINE=MyISAM DEFAULT CHARSET=utf8;
	
	INSERT INTO `".DB_PREFIX."options` (`option_key`, `option_value`, `site`) VALUES
	('default_controller', 'page', 'default'),
	('base', '".$base."', 'default'),
	('theme', 'default', 'default'),
	('title', '".$title."', 'default'),
	('url_suffix', '".$url_suffix."', 'default'),
	('url_prefix', '".$url_prefix."', 'default'),
	('url', '".$url."', 'default'),
	('sub_title', '".$sub_title."', 'default'),
	('master_site', '".$url."', ''),
	('default_controller_clean_urls', 'show', 'default'),
	('auth', '', 'default'),
	('base', '".$base."admin/', 'admin'),
	('theme', 'admin', 'admin'),
	('default_controller', 'dashboard', 'admin'),
	('default_controller_clean_urls', '', 'admin'),
	('url_suffix', '', 'admin'),
	('url_prefix', '".$url_prefix."', 'admin'),
	('url', '".$url."/admin', 'admin'),
	('auth', 'login', 'admin');

	CREATE TABLE IF NOT EXISTS `".DB_PREFIX."post` (
	  `id` int(11) NOT NULL AUTO_INCREMENT,
	  `title` varchar(100) NOT NULL,
	  `slug` varchar(100) NOT NULL,
	  `content` text NOT NULL,
	  `date` datetime NOT NULL,
	  `idUser` int(11) NOT NULL,
	  PRIMARY KEY (`id`)
	) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

	CREATE TABLE IF NOT EXISTS `".DB_PREFIX."routes` (
	  `site` varchar(55) NOT NULL,
	  `route` varchar(55) NOT NULL,
	  `route_to` varchar(55) NOT NULL,
	  `active` tinyint(1) NOT NULL,
	  `external` tinyint(1) NOT NULL,
	  UNIQUE KEY `route` (`route`)
	) ENGINE=MyISAM DEFAULT CHARSET=utf8;

	CREATE TABLE IF NOT EXISTS `".DB_PREFIX."users` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`username` varchar(70) NOT NULL,
	`email` varchar(100) NOT NULL,
	`password` varchar(100) NOT NULL,
	`real_name` varchar(55) NOT NULL,
	`created` datetime NOT NULL,
	PRIMARY KEY (`id`)
	) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
	
	CREATE TABLE IF NOT EXISTS `".DB_PREFIX."region` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`name` varchar(60) NOT NULL,
	`site` varchar(55) NOT NULL,
	`content` text NOT NULL,
	PRIMARY KEY (`id`),
	UNIQUE KEY `name` (`name`,`site`)
	) ENGINE=MyISAM  DEFAULT CHARSET=utf8;


";
	$db->multiQuery($query);
	$auth->register($username, $password, $email, $real_name);
	echo "<h1>Installation complete</h1>";
}
?>
<h1>Giraffe fast installer</h1>
<p>Not as fast as it could be..</p>
<form method="post">
		<h2>Install</h2>
	<h3>Step 1: Create config file</h3>
	<ul>
		<li>Copy system/config-sample.php to system/config.php</li>
		<li>Update config.php to your database data</li>
	</ul>
	Check if file exists...
	<?php
	if (file_exists($config_path)) {
		echo '<span style="color:green;font-weight:bold;">File exist!</span>';
		echo '<h3>Step 2: Database Connection</h3>';
		echo "Checking database connection...";
		require_once($config_path);
		if($db = Database::instance()) {
			echo '<span class="green">Working!</span>';
		}
		echo '<h3>Step 3: Check database</h3>';
		check_database($db);
		
		echo '<br />Lets begin to create table\'s and import data! Before you press start, be sure that you have typed the right data. <br />';
		
	?>
	<h4>Site info</h4>
	<strong>Warning: Case sensitive</strong><br />
	<input type="text" value="<?php echo get_domain(); ?>" name="url" /> Url (<strong>Dont add a slash '/' at the end</strong>) For example: http://domain.com or http://www.domain.com/subpath<br />
	<input type="text" value="<?php echo get_base(); ?>" name="base" /> Base - (Only if you put your site under domain.com/path/subpath/, base is 'path/subpath/' If not empty, end with a slash!<br />
	<input type="text" name="title" /> Site title <br />
	<input type="text" name="sub_title" /> sub_title <br />
	
	<h4>Optional (Only change this if you know what you do)</h4>
	<input type="text" value="" name="url_prefix" /> Prefix (If mod_rewrite on server, change this to index.php/)<br />
	<input type="text" value="" name="url_suffix" /> Suffix<br /> 
	
	<h4>Admin</h4>
	<input type="text" value="" name="username" /> Username<br />
	<input type="text" value="" name="password" /> Password<br />
	<input type="text" value="" name="real_name" /> Real name<br />
	<input type="text" value="" name="email" /> Email<br />
	<input type="submit" value="Install site" />
	<?php
	} else {
		echo '<span class="red">File is missing!</span>';
	}
	?>
</form>
</body>
</html>