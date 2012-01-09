<?php
global $giraffe;
?>
<!DOCTYPE html>
<html>
	<head>
		<script type="text/javascript" src="<?php the_siteInfo("theme_url"); ?>/includes/jquery-1.7.1.min.js"></script>
		<script type="text/javascript">
		</script>
		<link href="<?php the_siteInfo("theme_url"); ?>/twitter-bootstrap/bootstrap.min.css" rel="stylesheet" type="text/css">
		<style type="text/css">
			body {
				padding-top: 60px;
			}
		</style>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title><?php echo $site_title; ?></title>
		<?php if(isset($header_inner)) { echo $header_inner; }?>
	</head>
	<body>
	<div class="topbar">
		<div class="topbar-inner">
			<div class="container-fluid">
				<a class="brand" href="<?php the_siteInfo("url");?>">Admin</a>
				<ul class="nav">
					<li><a href="<?php the_siteInfo("master_site"); ?>">Site index</a></li>
				</ul>
				<?php if($giraffe->auth->isLoggedIn()) {
					echo '<p class="pull-right">Logged in as <a href="#">'.$_SESSION["auth_username"].'</a> <a  style="margin-left:20px;" href="/admin/login/logout">Logout</a></p>';
				}
				?>
			</div>
		</div>
	</div>