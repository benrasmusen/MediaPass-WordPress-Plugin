<?php 

global $mp_plugin_name; 

?>
<div class="wrap">
	<h2 class="header"><img width="24" height="24" src="<?php echo get_option('siteurl').'/wp-content/plugins/'.$mp_plugin_name.'/js/images/mplogo.gif' ?>" class="mp-icon"> Signup</h2>
	
	<h3>Create an account in just a few minutes...</h3>
	
	<p>No credit card required. No technical expertise needed. Go live in just a few minutes!</p>
	<form action="" method="post" accept-charset="utf-8">
		<table class="form-table">
			<tr>
				<th><label for="name">Name</label></th>
				<td><input type="text" name="name" value="<?php echo get_option('blogname') ?>" id="name" class="regular-text"></td>
			</tr>
			<tr>
				<th><label for="email">Email Address</label></th>
				<td><input type="text" name="email" value="<?php echo get_option('admin_email') ?>" id="email" class="regular-text"></td>
			</tr>
			<tr>
				<th><label for="password">Password</label></th>
				<td><input type="password" name="password" value="" id="password" class="regular-text"></td>
			</tr>
			<tr>
				<th><label for="site_url">Site URL</label></th>
				<td><input type="text" name="site_url" value="<?php echo get_option('MP_installed_URL') ?>" id="site_url" class="regular-text"></td>
			</tr>
			<tr>
				<th>&nbsp;</th>
				<td><input type="submit" value="Get Started"></td>
			</tr>
		</table>
	</form>
	
	<br/>
	
	<hr/>
	
	<h3>Already have an account?</h3>
	
	<p><a href="#">Authorize your account now!</a></p>
	
</div>