<!DOCTYPE html>
<html>
	<head>
		<link href="<?php the_siteInfo("theme_url"); ?>/twitter-bootstrap/bootstrap.min.css" rel="stylesheet" type="text/css">
		<style type="text/css">
			body {
				padding-top: 60px;
			}
		</style>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>Admin</title>
	</head>
	<body>
	<div class="topbar">
		<div class="topbar-inner">
			<div class="container-fluid">
				<a class="brand" href="<?php the_siteInfo("url");?>">Admin</a>
				<ul class="nav">
					<li><a href="<?php the_siteInfo("index"); ?>">Site index</a></li>
				</ul>
				<p class="pull-right">Logged in as <a href="#">username</a></p>
			</div>
		</div>
	</div>