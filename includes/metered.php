<div class="mp-wrap">
	<h2 class="header"><img width="24" height="24" src="<?php echo get_option('siteurl').'/wp-content/plugins/'.MP_PLUGIN_NAME.'/js/images/mplogo.gif' ?>" class="mp-icon"> Metered Settings</h2>

	<form action="" method="post" accept-charset="utf-8">
		<table border="0" class="form-table">
			<tr>
				<th><label for="Status">Status</label></th>
				<td>
					<select name="Status" id="Status">
						<option value="On"<?php echo ($data['Msg']['Status'] == 'On') ? ' selected="selected"' : null ?>>On</option>
						<option value="Off"<?php echo ($data['Msg']['Status'] == 'Off') ? ' selected="selected"' : null ?>>Off</option>
					</select>
				</td>
			</tr>
			<tr>
				<th><label for="Count">Count</label></th>
				<td>
					<input type="text" name="Count" value="<?php echo $data['Msg']['Count'] ?>" id="Count">
				</td>
			</tr>
			<tr>
				<td colspan="2"><input type="submit" value="Update"></td>
			</tr>
		</table>
	</form>
</div>