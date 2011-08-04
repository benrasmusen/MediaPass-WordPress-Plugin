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