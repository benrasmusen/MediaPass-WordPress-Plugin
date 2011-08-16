<?php 

global $mp_plugin_name; 

?>
<div class="wrap">
	<h2 class="header"><img width="24" height="24" src="<?php echo get_option('siteurl').'/wp-content/plugins/'.$mp_plugin_name.'/js/images/mplogo.gif' ?>" class="mp-icon"> Update Benefits</h2>
	
	<h3>Benefits Logo</h3>
	
	<p>Upload a logo to customize the look and feel of your Page Overlay and Video Overlay subscription options. Your logo must be a jpg. See examples below.</p>
	
	<form name="benefits" action="" method="post" accept-charset="utf-8" id="benefits-form">
		
		<table border="0" cellspacing="5" cellpadding="5">
			<tr valign="top">
				<th scope="row">Upload Image</th>
				<td>
					<label for="upload_image">
					<input id="upload_image" type="text" size="36" name="upload_image" value="" />
					<input id="upload_image_button" type="button" value="Upload Image" />
					<br />Enter an URL or upload an image for the logo.
					</label>
				</td>
			</tr>
		</table>

		
		<br/><br/>
		
		<table border="0">
			<tr>
				<td valign="top" width="175"><strong>Your logo <br/>on Page Overlay option</strong></td>
				<td><img src="<?php echo get_option('siteurl').'/wp-content/plugins/'.$mp_plugin_name.'/images/update-logo-inPage.jpg'?>" width="436" height="246" alt="Update Logo InPage"></td>
			</tr>
		</table>
	
		<p>To maintain the seamless look and feel of the In-Page subscription option, logos do not show up in this option. </p>
	
		<hr/>
		
		<h3>Benefits</h3>
		
		<p>Customize your messaging by marketing the benefits of becoming a premium subscriber. Enter the text to be displayed to your users in the Member Benefits section of the subscription option. See examples below.</p>

		<p>TIP: Benefits are displayed as bullet points, so separate each benefit on a new line in the text box.</p>
		
		<table border="0">
			<tr>
				<td colspan="2"><textarea name="benefits" rows="8" cols="100"><?php echo trim($benefits) ?></textarea></td>
			</tr>
			<tr>
				<td>
					<input type="submit" value="Update Benefits">
				</td>
				<td align="right" id="fieldlimiter_status"></td>
			</tr>
		</table>
	
	</form>
	
	<table border="0">
		<tr>
			<td valign="middle" width="175"><strong>Benefits Text <br/>on Page Overlay option</strong></td>
			<td><img src="<?php echo get_option('siteurl').'/wp-content/plugins/'.$mp_plugin_name.'/images/benefits-pageOverlay.jpg'?>" alt="Overlay Benefits Text" style="padding-left:15px;"></td>
		</tr>
		<tr>
			<td valign="middle" width="175"><strong>Benefits Text <br/>on In-Page option</strong></td>
			<td><img src="<?php echo get_option('siteurl').'/wp-content/plugins/'.$mp_plugin_name.'/images/benefits-inpage.jpg'?>" alt="In Page Benefits Text"></td>
		</tr>
	</table>
	
</div>

<script type="text/javascript" charset="utf-8">
	fieldlimiter.setup({
	    thefield: document.benefits.benefits, //reference to form field
	    maxlength: 1000,
	    statusids: ["fieldlimiter_status"], //id(s) of divs to output characters limit in the form [id1, id2, etc]. If non, set to empty array [].
	    onkeypress: function(maxlength, curlength) { //onkeypress event handler
	        //define custom event actions here if desired
	    }
	})
</script>