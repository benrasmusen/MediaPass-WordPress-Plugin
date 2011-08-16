<?php 

global $mp_plugin_name;

// TODO: implement $mp_auth_register_url/$mp_auth_login_url

?>
<div class="wrap">
	<h2 class="header"><img width="24" height="24" src="<?php echo get_option('siteurl').'/wp-content/plugins/'.$mp_plugin_name.'/js/images/mplogo.gif' ?>" class="mp-icon"> Signup</h2>
	
	<h3>Create an account in just a few minutes...</h3>
	
	<p>No credit card required. No technical expertise needed. Go live in just a few minutes! <a href="http://www.mediapassacademy.net/Account/AuthRegister/?client_id=7480FECEA20C3338C950F885BFA148C9&redirect_uri=http://www.mediapassacademy.net/auth.html<?php // echo urlencode("http" . ((!empty($_SERVER['HTTPS'])) ? "s" : null) . " ://" . $_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI']) ?>&scope=http://www.mediapassacademy.net/auth.html&response_type=token">Click here to get started!</a></p>
	
	<hr/>
	
	<h3>Already have an account?</h3>
	
	<p><a href="http://www.mediapassacademy.net/Account/Auth/?client_id=7480FECEA20C3338C950F885BFA148C9&redirect_uri=http://www.mediapassacademy.net/auth.html<?php // echo urlencode("http" . ((!empty($_SERVER['HTTPS'])) ? "s" : null) . " ://" . $_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI']) ?>&scope=http://www.mediapassacademy.net/auth.html&response_type=token">Authorize your account now!</a></p>
	
</div>