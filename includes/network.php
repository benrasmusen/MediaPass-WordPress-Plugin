<div class="mp-wrap">
	<h2 class="header"><img width="24" height="24" src="<?php echo get_option('siteurl').'/wp-content/plugins/'.MP_PLUGIN_NAME.'/js/images/mplogo.gif' ?>" class="mp-icon"> Network Sites</h2>
	
	<h3>Current</h3>
	<table border="0" id="network-sites">
		<tr>
			<th>Title</th>
			<th>Domain</th>
			<th class="last">BackLink</th>
		</tr>
		<?php if (!empty($data['Msg']) && is_array($data['Msg'])): ?>
			<?php foreach ($data['Msg'] as $network): ?>
				<tr id="network-site-<?php echo $network['Id'] ?>">
					<td><?php echo $network['Title'] ?></td>
					<td><?php echo $network['Domain'] ?></td>
					<td class="last"><?php echo $network['BackLink'] ?></td>
				</tr>
			<?php endforeach ?>
		<?php else: ?>
			<tr>
				<td colspan="3">No network sites found.</td>
			</tr>
		<?php endif ?>
	</table>
<hr/>
	<h3>Add New</h3>
	<form action="" method="post" accept-charset="utf-8">
		<table border="0" class="form-table">
			<tr class="network-site">
				<td>
					<label for="title">Title</label>
					<br/>
					<input type="text" name="Title" value="" class="title">
					<br/>
					<label for="domain">Domain</label>
					<br/>
					<input type="text" name="Domain" value="" class="domain">
					<br/>
					<label for="back_link">BackLink</label>
					<br/>
					<input type="text" name="BackLink" value="" class="back_link">
				</td>
			</tr>
			<tr>
				<td colspan="2"><input type="submit" value="Add New Network Site"></td>
			</tr>
		</table>
	</form>
</div>