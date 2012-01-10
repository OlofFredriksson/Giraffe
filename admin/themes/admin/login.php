<?php
global $giraffe;
get_header();
?>
<div class="container-fluid">
	<?php if($giraffe->auth->isLoggedIn()) {
		get_sidebar();
	}
	?>
	<div class="content">
	<div class="row">
		<div class="span16">
			<h2>Login</h2>
			<?php echo $info_bar; ?>
			<?php if(!$giraffe->auth->isLoggedIn()) {
			?>
				<form method="post" action="<?php echo $giraffe->request_handler->site_url("login"); ?>">
					<div class="clearfix">
						<div class="input-prepend">
							<span class="add-on">Username</span>
							<input class="medium" id="username" name="username" size="16" type="text"/>
						</div>
					</div>
					<div class="clearfix">
						<div class="input-prepend">
							<span class="add-on">Password</span>
							<input class="medium" id="password" name="password" size="16" type="password"/>
						</div>
					</div>
					<input class="btn primary" type="submit" name="login" value="Login"/>
				</form>
				<?php
			}
			else {
				echo "You are already logged in.";
			}
			?>
		</div>
	</div>
	<?php get_footer(); ?>