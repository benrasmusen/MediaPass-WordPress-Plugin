<?php 

// TODO: implement correct redirect once it's live

?>
<div class="mp-wrap">
	<h2 class="header"><img width="24" height="24" src="<?php echo get_option('siteurl').'/wp-content/plugins/'.MP_PLUGIN_NAME.'/js/images/mplogo.gif' ?>" class="mp-icon"> Signup</h2>
	
	<h3>Create an account in just a few minutes...</h3>
	
	<p>No credit card required. No technical expertise needed. Go live in just a few minutes! <a href="<?php echo MP_AUTH_REGISTER_URL . urlencode("http" . (($_SERVER['HTTPS'] == 'on') ? "s" : null) . "://" . $_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI']) ?>">Click here to get started!</a></p>
	
	<hr/>
	
	<h3>Already have an account?</h3>
	
	<p><a href="<?php echo MP_AUTH_LOGIN_URL . urlencode("http" . (($_SERVER['HTTPS'] == 'on') ? "s" : null) . "://" . $_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI']) ?>">Authorize your account now!</a></p>
	
</div>