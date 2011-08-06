<?php 

global $mp_plugin_name; 

?>
<div class="wrap">
	<h2 class="header"><img width="24" height="24" src="<?php echo get_option('siteurl').'/wp-content/plugins/'.$mp_plugin_name.'/js/images/mplogo.gif' ?>" class="mp-icon"> Update Benefits Logo</h2>
	
	<?php include_once('ajax_loader.php') ?>
	
	<p>Upload a logo to customize the look and feel of your Page Overlay and Video Overlay subscription options. Your logo must be a jpg. See examples below.</p>
	
	<form action="" method="post" accept-charset="utf-8">
		<input type="file" name="benefits_logo" value="" id="benefits_logo">
		<input type="submit" value="Upload">
	</form>
	
	<p>Your logo on Page Overlay option</p>
	<img src="<?php echo get_option('siteurl').'/wp-content/plugins/'.$mp_plugin_name.'/images/update-logo-inPage.jpg'?>" width="436" height="246" alt="Update Logo InPage">
	
	<p>To maintain the seamless look and feel of the In-Page subscription option, logos do not show up in this option. </p>
	
</div>