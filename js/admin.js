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
	
	jQuery('#upload_image_button').click(function() {
		 formfield = jQuery('#upload_image').attr('name');
		 tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
		 return false;
	});

	window.send_to_editor = function(html) {
		 imgurl = jQuery('img',html).attr('src');
		 jQuery('#upload_image').val(imgurl);
		 tb_remove();
	}
});
