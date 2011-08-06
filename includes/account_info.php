<?php 

global $mp_plugin_name; 

?>
<div class="wrap">
	<h2 class="header"><img width="24" height="24" src="<?php echo get_option('siteurl').'/wp-content/plugins/'.$mp_plugin_name.'/js/images/mplogo.gif' ?>" class="mp-icon"> Update Account Information</h2>
	<form action="" method="post" accept-charset="utf-8">
		<table border="0" cellspacing="0" cellpadding="0" class="form-table">
			<tbody>
				<tr>
					<th><label for="password">Password <span class="description">(required)</span></label></th>
					<td><input type="text" name="password" value="" id="password" class="regular-text"></td>
				</tr>
				<tr>
					<th><label for="email">Email <span class="description">(required)</span></label></th>
					<td><input type="text" name="email" value="" id="email" class="regular-text" disabled="disabled"></td>
				</tr>
				<tr>
					<th><label for="name">Name <span class="description">(required)</span></label></th>
					<td><input type="text" name="name" value="" id="name" class="regular-text"></td>
				</tr>
				<tr>
					<th><label for="payable_to">Payable to <span class="description">(required)</span></label></th>
					<td><input type="text" name="payable_to" value="" id="payable_to" class="regular-text"></td>
				</tr>
				<tr>
					<th><label for="tax_id">Tax ID</label></th>
					<td><input type="text" name="tax_id" value="" id="tax_id" class="regular-text"></td>
				</tr>
				<tr>
					<th><label for="ssn">OR Social Security</label></th>
					<td><input type="text" name="ssn" value="" id="ssn" class="regular-text"></td>
				</tr>
				<tr>
					<th><label for="vat_number">OR VAT Number</label></th>
					<td><input type="text" name="vat_number" value="" id="vat_number" class="regular-text"></td>
				</tr>
				<tr>
					<th><label for="address">Address</label></th>
					<td><input type="text" name="address" value="" id="address" class="regular-text"></td>
				</tr>
				<tr>
					<th><label for="city">City</label></th>
					<td><input type="text" name="city" value="" id="city" class="regular-text"></td>
				</tr>
				<tr>
					<th><label for="state">State</label></th>
					<td><input type="text" name="state" value="" id="state" class="regular-text"></td>
				</tr>
				<tr>
					<th><label for="zip">ZIP or Postal Code</label></th>
					<td><input type="text" name="zip" value="" id="zip" class="regular-text"></td>
				</tr>
				<tr>
					<th><label for="country">Country</label></th>
					<td><input type="text" name="country" value="" id="country" class="regular-text"></td>
				</tr>
				<tr>
					<th><label for="phone">Phone</label></th>
					<td><input type="text" name="phone" value="" id="phone" class="regular-text"></td>
				</tr>
				<tr>
					<th><label for="fax">Fax</label></th>
					<td><input type="text" name="fax" value="" id="fax" class="regular-text"></td>
				</tr>
				<tr>
					<th><label for="site_url">Web Site URL</label></th>
					<td><input type="text" name="site_url" value="<?php echo get_option('MP_installed_URL') ?>" id="site_url" class="regular-text" disabled="disabled"></td>
				</tr>
				<tr>
					<th><label for="web_site_title">Web Site Subject/Title</label></th>
					<td><input type="text" name="web_site_title" value="" id="web_site_title" class="regular-text"></td>
				</tr>
				<tr>
					<th><label for="no_sale_back_link">No Sale Back Link URL (http://)</label></th>
					<td><input type="text" name="no_sale_back_link" value="" id="no_sale_back_link" class="regular-text"></td>
				</tr>
				<tr>
					<th><label for="custom_sale_posting_url">Custom Sale Posting URL</label></th>
					<td><input type="text" name="custom_sale_posting_url" value="" id="custom_sale_posting_url" class="regular-text"></td>
				</tr>
			</tbody>
		</table>
		<br/>
		<table cellspacing="0" cellpadding="0" id="dynamic-variables">
		    <tbody>
				<tr>
			        <th colspan="2">List of Dynamic Variables</th>
			    </tr>
			    <tr>
			        <td>##OrderNumber##</td>
			        <td>The order number of the sale</td>
			    </tr>
			    <tr>
			        <td>##SaleAmount##</td>
			        <td>The amount of the sale</td>
			    </tr>
			    <tr>
			        <td>##Commission##</td>
			        <td>The affiliate commission</td>
			    </tr>
			    <tr>
			        <td>##SalesID##</td>
			        <td>The Affiliate Wiz internal Sale ID</td>
			    </tr>
			    <tr>
			        <td>##Tier##</td>
			        <td>The commission Tier</td>
			    </tr>
			    <tr>
			        <td>##SubAffiliateID##</td>
			        <td>The Sub AffiliateID if available</td>
			    </tr>
		</tbody>
		</table>
		<p><input type="submit" value="Update Account"></p>
	</form>
</div>