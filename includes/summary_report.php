<?php 

global $mp_plugin_name; 

?>
<div class="mp-wrap">
	<h2 class="header"><img width="24" height="24" src="<?php echo get_option('siteurl').'/wp-content/plugins/'.$mp_plugin_name.'/js/images/mplogo.gif' ?>" class="mp-icon"> Summary Report</h2>
	
	<table border="0" id="earning-summary">
		<tr>
			<th colspan="2">Earning Summary</th>
		</tr>
		<tr>
			<td width="65%">Total Earned:</td>
			<td width="35%">$<?php echo $data['earning']['Commissions'] ?></td>
		</tr>
		<tr>
			<td width="65%">Total Paid:</td>
			<td width="35%">$<?php echo $data['earning']['Paid'] ?></td>
		</tr>		
		<tr>
			<td width="65%">Current Balance:</td>
			<td width="35%">$<?php echo $data['earning']['Balance'] ?></td>
		</tr>
	</table>
	
	<table border="0" id="stats">
		<tr>
			<th colspan="2">
				Stats for 
				<select name="period" id="period">
					<option value="today"<?php echo (empty($_GET['period']) || $_GET['period'] == 'today') ? ' selected="selected"' : null ?>>Today</option>
					<option value="this_month"<?php echo (!empty($_GET['period']) && $_GET['period'] == 'this_month') ? ' selected="selected"' : null ?>>This Month</option>
					<option value="this_year"<?php echo (!empty($_GET['period']) && $_GET['period'] == 'this_year') ? ' selected="selected"' : null ?>>This Year</option>
				</select>
			</th>
		</tr>
		<tr>
			<td width="65%">Sales:</td>
			<td width="35%"><?php echo $data['stats']['Sales'] ?></td>
		</tr>
		<tr>
			<td width="65%">Commissions:</td>
			<td width="35%">$<?php echo $data['stats']['Commissions'] ?></td>
		</tr>		
		<tr>
			<td width="65%">Impressions:</td>
			<td width="35%"><?php echo $data['stats']['Impressions'] ?></td>
		</tr>
	</table>
	
</div>