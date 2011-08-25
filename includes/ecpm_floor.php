<div class="mp-wrap">
	<h2 class="header"><img width="24" height="24" src="<?php echo get_option('siteurl').'/wp-content/plugins/'.MP_PLUGIN_NAME.'/js/images/mplogo.gif' ?>" class="mp-icon"> Update eCPM Floor</h2>

	<form action="" method="post" accept-charset="utf-8">
		<table border="0" class="form-table">
			<tr>
				<th><label for="ecpm_floor">eCPM Floor</label></th>
				<td>
					<input type="text" name="ecpm_floor" value="<?php echo $data ?>" id="ecpm_floor">
				</td>
			</tr>
			<tr>
				<td colspan="2"><input type="submit" value="Update"></td>
			</tr>
		</table>
	</form>
</div>