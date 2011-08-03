<style type="text/css" media="screen">
	img.mp-icon{
		vertical-align: middle;
	}
	h2.header {
		padding-top:3px;
	}
	div.wrap {
		width:800px;
	}
	table#price-points {
		margin:0 auto;
		width:530px;
	}
	table#price-points tr th {
		text-align:left;
	}
	table#price-points tr td {
		padding:5px 0;
	}
</style>
<script type="text/javascript" charset="utf-8">
	jQuery(document).ready(function(){
		jQuery('#subscription-model').bind('change', function(e) {
			switch (jQuery(e.target).val()) {
				case 'membership':
					jQuery('div#membership-wrapper').show();
					jQuery('div#single-wrapper').hide();
					break;

				case 'single':
					jQuery('div#membership-wrapper').hide();
					jQuery('div#single-wrapper').show();
					break;
			}
		});
	});
</script>
<?php 

global $mp_plugin_name; 

?>
<div class="wrap">
	
	<h2 class="header"><img width="24" height="24" src="<?php echo get_option('siteurl').'/wp-content/plugins/'.$mp_plugin_name.'/js/images/mplogo.gif' ?>" class="mp-icon"> Price Point Configuration</h2>

	<p>Set up Pricing to get started.</p>

	<p>First, choose your Subscription Model. Most websites will use Membership Access, to allow multiple pages or sections of content to be included in a subscription membership. The Single Article Access is for websites that wish to only charge for specific pieces of content. This option is similar to a pay-per-view model, and does not support ongoing memberships.</p>
	
	<div id="subscription-model">
		<label for="subscription-model">My Subscription Model:</label>
		<select name="subscription_model" id="subscription-model">
			<option value="membership">Membership Access</option>
			<option value="single">Single Article Access</option>
		</select>
	</div>
	
	<div id="membership-wrapper">
		
		<p>Next, set up your Price Points. Your users will see three options when asked to sign-up for a subscription. Select the 3 subscription membership periods to choose from, and the corresponding unit price for each period. For example, if you want to charge $60 for a 6 month subscription, enter $10 for the unit Price.</p>
		<form action="#" method="post" accept-charset="utf-8" id="membership-form">
			<table border="0" cellspacing="0" cellpadding="0" id="price-points">
				<tr>
					<th>Period Length</th>
					<th>Unit Price</th>
				</tr>
				<tr>
					<td>
						<select name="pricing_period[]" id="pricing-period">
							<option value="1mo">1 Month</option>
							<option value="3mo">3 Months</option>
							<option value="6mo">6 Months</option>
							<option value="1yr">1 Year</option>
						</select>
						<label for="pricing-period">Membership at</label>
					</td>
					<td>
						$<input type="text" name="price" value="" id="price"> per month
					</td>
				</tr>
				<tr>
					<td>
						<select name="pricing_period[]" id="pricing-period">
							<option value="1mo">1 Month</option>
							<option value="3mo">3 Months</option>
							<option value="6mo">6 Months</option>
							<option value="1yr">1 Year</option>
						</select>
						<label for="pricing-period">Membership at</label>
					</td>
					<td>
						$<input type="text" name="price" value="" id="price"> per month
					</td>
				</tr>
				<tr>
					<td>
						<select name="pricing_period[]" id="pricing-period">
							<option value="1mo">1 Month</option>
							<option value="3mo">3 Months</option>
							<option value="6mo">6 Months</option>
							<option value="1yr">1 Year</option>
						</select>
						<label for="pricing-period">Membership at</label>
					</td>
					<td>
						$<input type="text" name="price" value="" id="price"> per month
					</td>
				</tr>
				<tr>
					<td>
						<input type="submit" value="Create Price Point Set">
					</td>
					<td>
						<p>
							<input type="checkbox" name="set_default" value="" id="set-default">
							<strong>Set this price point set as my default active price set.</strong></p>
						<p><strong>(Note: This will stop and overide any current price point test.)</strong></p>
					</td>
				</tr>
			</table>
		</form>
		
	</div>
	
	<div id="single-wrapper">
		
		<form action="#" method="post" accept-charset="utf-8" id="single-form">
			<table border="0" cellspacing="0" cellpadding="0" id="price-points">
				<tr>
					<td>
						<label for="price">Single Article Price</label>
					</td>
					<td>
						$<input type="text" name="price" value="" id="price">
					</td>
				</tr>
				<tr>
					<td>
						<input type="submit" value="Create Price Point Set">
					</td>
					<td>
						<p>
							<input type="checkbox" name="set_default" value="" id="set-default">
							<strong>Set this price point set as my default active price set.</strong></p>
						<p><strong>(Note: This will stop and overide any current price point test.)</strong></p>
					</td>
				</tr>
			</table>
		</form>
		
	</div>
	
	<p>You can also create different Price Point Sets for testing purposes. Go to Price Point Tests in the Customization section to learn more.</p>
	
</div>
