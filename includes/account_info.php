<div class="mp-wrap">
	<h2 class="header"><img width="24" height="24" src="<?php echo get_option('siteurl').'/wp-content/plugins/'.MP_PLUGIN_NAME.'/js/images/mplogo.gif' ?>" class="mp-icon"> Update Account Information</h2>
	<form action="" method="post" accept-charset="utf-8">
		<table border="0" cellspacing="0" cellpadding="0" class="form-table">
			<tbody>
				<tr>
					<th><label for="Title">Web Site Subject/Title</label></th>
					<td><input type="text" name="Title" value="<?php echo (!empty($data['Title'])) ? $data['Title'] : null ?>" id="title" class="regular-text"></td>
				</tr>
				<tr>
					<th><label for="CompanyName">Company Name</label></th>
					<td><input type="text" name="CompanyName" value="<?php echo (!empty($data['CompanyName'])) ? $data['CompanyName'] : null ?>" id="company-name" class="regular-text"></td>
				</tr>
				<tr>
					<th><label for="CompanyAddress">Company Address</label></th>
					<td><input type="text" name="CompanyAddress" value="<?php echo (!empty($data['CompanyAddress'])) ? $data['CompanyAddress'] : null ?>" id="company-address" class="regular-text"></td>
				</tr>
				<tr>
					<th><label for="City">City</label></th>
					<td><input type="text" name="City" value="<?php echo (!empty($data['City'])) ? $data['City'] : null ?>" id="city" class="regular-text"></td>
				</tr>
				<tr>
					<th><label for="State">State</label></th>
					<td><input type="text" name="State" value="<?php echo (!empty($data['State'])) ? $data['State'] : null ?>" id="state" class="regular-text"></td>
				</tr>
				<tr>
					<th><label for="Zip">ZIP or Postal Code</label></th>
					<td><input type="text" name="Zip" value="<?php echo (!empty($data['Zip'])) ? $data['Zip'] : null ?>" id="zip" class="regular-text"></td>
				</tr>
				<tr>
					<th><label for="Country">Country</label></th>
					<td><input type="text" name="Country" value="<?php echo (!empty($data['Country'])) ? $data['Country'] : null ?>" id="country" class="regular-text"></td>
				</tr>
				<tr>
					<th><label for="Telephone">Telephone</label></th>
					<td><input type="text" name="Telephone" value="<?php echo (!empty($data['Telephone'])) ? $data['Telephone'] : null ?>" id="telephone" class="regular-text"></td>
				</tr>
				<tr>
					<th><label for="CustomRedirectURL">Custom Redirect URL (http://)</label></th>
					<td><input type="text" name="CustomRedirectURL" value="<?php echo (!empty($data['CustomRedirectURL'])) ? $data['CustomRedirectURL'] : null ?>" id="custom-redirect-url" class="regular-text"></td>
				</tr>
				<tr>
					<th><label for="CustomSalePostURL">Custom Sale Posting URL</label></th>
					<td><input type="text" name="CustomSalePostURL" value="<?php echo (!empty($data['CustomSalePostURL'])) ? $data['CustomSalePostURL'] : null ?>" id="custom-sale-post-url" class="regular-text"></td>
				</tr>
			</tbody>
		</table>
		<p><input type="submit" value="Update Account"></p>
	</form>
</div>