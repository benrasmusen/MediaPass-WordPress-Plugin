<?php 

global $mp_plugin_name; 

?>
<div class="mp-wrap">
	
	<h2 class="header"><img width="24" height="24" src="<?php echo get_option('siteurl').'/wp-content/plugins/'.$mp_plugin_name.'/js/images/mplogo.gif' ?>" class="mp-icon"> Price Point Configuration</h2>

	<p>Set up Pricing to get started.</p>

	<p>First, choose your Subscription Model. Most websites will use Membership Access, to allow multiple pages or sections of content to be included in a subscription membership. The Single Article Access is for websites that wish to only charge for specific pieces of content. This option is similar to a pay-per-view model, and does not support ongoing memberships.</p>
	
	<form action="#" method="post" accept-charset="utf-8" id="membership-form">
	
	<div id="subscription-model">
		<label for="subscription-model">My Subscription Model:</label>
		<select name="subscription_model" id="subscription-model">
			<option value="membership"<?php echo ($data['subscription_model'] == 'membership') ? ' selected="selected"' : null ?>>Membership Access</option>
			<option value="single"<?php echo ($data['subscription_model'] == 'single') ? ' selected="selected"' : null ?>>Single Article Access</option>
		</select>
	</div>
	
	<div id="membership-wrapper"<?php echo ($data['subscription_model'] == 'single') ? ' style="display:none"' : null ?>>
		
		<p>Next, set up your Price Points. Your users will see three options when asked to sign-up for a subscription. Select the 3 subscription membership periods to choose from, and the corresponding unit price for each period. For example, if you want to charge $60 for a 6 month subscription, enter $10 for the unit Price.</p>
		
		<table border="0" cellspacing="0" cellpadding="0" id="price-points">
			<tr>
				<th>Period Length</th>
				<th>Unit Price</th>
			</tr>
				
			<?php
			$i = 0;
			while ($i <= 2): ?>
				
				<tr>
					<td>
						<select name="prices[<?php echo $i ?>][pricing_period]" id="pricing-period-<?php echo $i ?>">
							<?php
							$options = array(
								'1mo' => array(
									'Label' => '1 Month',
									'Length' => 1,
									'Increment' => 2592000
								),
								'3mo' => array(
									'Label' => '3 Months',
									'Length' => 3,
									'Increment' => 2592000
								),
								'6mo' => array(
									'Label' => '6 Months',
									'Length' => 6,
									'Increment' => 2592000
								),
								'1yr' => array(
									'Label' => '1 Year',
									'Length' => 1,
									'Increment' => 31104000
								)
							);
							?>
							<?php foreach ($options as $key => $value): ?>
								<option value="<?php echo $key ?>"<?php echo ($data['subscription_model'] == 'membership' && !empty($data['prices'][$i]) && $data['prices'][$i]['Increment'] == $value['Increment'] && $data['prices'][$i]['Length'] == $value['Length']) ? ' selected="selected"' : null ?>><?php echo $value['Label'] ?></option>
							<?php endforeach ?>
						</select>
						<label for="pricing-period">Membership at</label>
					</td>
					<td>
						$<input type="text" name="prices[<?php echo $i ?>][price]" value="<?echo ($data['subscription_model'] == 'membership') ? $data['prices'][$i]['Price'] : null; ?>" id="price-<?php echo $i ?>"> per month
					</td>
				</tr>
				
			<?php 
			$i++;
			endwhile ?>
				
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
		
	</div>
	
	<div id="single-wrapper"<?php echo ($data['subscription_model'] == 'membership') ? ' style="display:none"' : null ?>>
		
		<table border="0" cellspacing="0" cellpadding="0" id="price-points">
			<tr>
				<td>
					<label for="price">Single Article Price</label>
				</td>
				<td>
					$<input type="text" name="price" value="<?php echo ($data['subscription_model'] == 'single') ? $data['prices'][0]['Price'] : null ?>" id="price">
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
		
	</div>
	
	<p>You can also create different Price Point Sets for testing purposes. Go to Price Point Tests in the Customization section to learn more.</p>
	
</div>
