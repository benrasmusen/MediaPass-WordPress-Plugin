<?php

	
	function mediapass_overlay_shortcode( $atts, $content = null ) {
		return '<noscript><meta http-equiv="REFRESH" content="0; url=http://www.mediapass.com/subscription/noscriptredirect?key=' . get_option('MP_user_ID') . '&uri=' . site_url() . '"></noscript><script type="text/javascript" src="http://www.mediapass.com/static/js/mm.js"></script><script type="text/javascript">MediaPass.init(' . get_option('MP_user_ID') . ');</script><div id="media-pass-tease" style="display:none;">' . do_shortcode( $content ) . '</div>';
	}
	
	add_shortcode( 'mpoverlay', 'mediapass_overlay_shortcode' );
	
	
	function mediapass_inpage_shortcode( $atts, $content = null ) {

		return '<noscript><meta http-equiv="REFRESH" content="0; url=http://www.mediapass.com/subscription/noscriptredirect?key=' . get_option('MP_user_ID') . '&uri=' . site_url() . '"></noscript><script type="text/javascript" src="http://www.mediapass.com/static/js/mm.js"></script><script type="text/javascript">MediaPass.init(' . get_option('MP_user_ID') . ');</script><div class="media-pass-article">' . do_shortcode( $content ) . '</div>';
	}
	
	add_shortcode( 'mpinpage', 'mediapass_inpage_shortcode' );


	function mediapass_video_shortcode( $atts, $content = null ) {
	   extract( shortcode_atts( array(
			"width" => ' ',		  
			"height" => ' ',		  
			"delay" => ' ',		  
			"title" => ' ',		  
			"vid" => ' ',		  
		  
		  ), $atts ) );
		$mp_vidvars = '{ width:' . $width . ', height:' . $height .', delay:' . $delay . ', title:"' . $title . '", vid:"' . $vid .'"}';

		return '<!-- ' . $delay . ' --><noscript><meta http-equiv="REFRESH" content="0; url=http://www.mediapass.com/subscription/noscriptredirect?key=' . get_option('MP_user_ID') . '&uri=' . site_url() . '"></noscript><script type="text/javascript" src="http://www.mediapass.com/static/js/mm.js"></script>
		<script type="text/javascript">MediaPass.init(' . get_option('MP_user_ID') . ', ' . $mp_vidvars . ');</script><div id="media-pass-video">'. do_shortcode( $content ) . '</div> ';

		}	   



	function Amediapass_video_shortcode($atts, $content = null) {
		extract(shortcode_atts(array(
			"width" => '600',
			"height" => '400',
			"delay" => ' ',
			"title" => ' ',
			"vid" => ' '
		), $atts));
		
		$mp_vidvars = '{ width:' . $width . ', height:' . $height .', delay:' . $delay . ', title:"' . $title . '", vid:"' . $vid .'"}';

		return '<!-- ' . $delay . ' --><noscript><meta http-equiv="REFRESH" content="0; url=http://www.mediapass.com/subscription/noscriptredirect?key=' . get_option('MP_user_ID') . '&uri=' . site_url() . '"></noscript><script type="text/javascript" src="http://www.mediapass.com/static/js/mm.js"></script>
		<script type="text/javascript">MediaPass.init(' . get_option('MP_user_ID') . ', ' . $mp_vidvars . ');</script><div id="media-pass-video">'. do_shortcode( $content ) . '</div> ';

		}
	
	add_shortcode( 'mpvideo', 'mediapass_video_shortcode' );


	
	


?>