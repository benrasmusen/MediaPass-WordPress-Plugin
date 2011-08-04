<?php
/*
Plugin Name: MediaPass Subscription Plugin
Plugin URI: http://www.mediapass.com/
Description: Integrate your mediapass.com account with your WordPress website.
Author: MediaPass Inc.
Version: 0.1
Author URI: http://www.mediapass.com/
*/
/*
    Copyright (C) 2011 Media Pass Inc.
 
    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.
 
    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.
 
    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/

require_once(WP_PLUGIN_DIR . "/" . basename(dirname(__FILE__)) . "/shortcodes.php");

global $mp_plugin_name;
$mp_plugin_name = 'mediapass';

// check and clean current url
function mp_set_http() {
	$mp_base_url = split("/", site_url());
    $mp_strip_endurl = $mp_base_url[0] ."//". $mp_base_url[2];
	$mp_str_url = str_replace(array('http://','https://'), '', $mp_strip_endurl);
	// check if option exists
	if( !get_option( 'MP_installed_URL' ) ) {
	update_option( 'MP_installed_URL', 'www.' . $mp_str_url, '', 'yes' );
	} else {
		// if exists then update
		add_option('MP_installed_URL', 'www.' . $mp_str_url, '', 'yes' );
	}	
}

// add buttons for wysiwyg editor
function mp_add_button() {
   if ( current_user_can('edit_posts') &&  current_user_can('edit_pages') )
   {
     add_filter('mce_external_plugins', 'mp_add_plugin');
     add_filter('mce_buttons', 'mp_register_button');
   }
}

// the actual wysiwyg buttons
function mp_register_button($buttons) {
   array_push($buttons, "overlay_button", "inpage_button", "video_button");
   return $buttons;
}

// buttons gotta do something right?
function mp_add_plugin($plugin_array) {
$mppath = WP_PLUGIN_URL.'/'.str_replace(basename( __FILE__),"",plugin_basename(__FILE__));
   $plugin_array['overlay_button'] = $mppath . '/js/overlay.js';
   $plugin_array['inpage_button'] = $mppath . '/js/inpage.js';
   $plugin_array['video_button'] = $mppath . '/js/video.js';
   return $plugin_array;
}

// load json script
function mp_load_json_parser(){
		wp_enqueue_script('json2');
}

// initialize jquery
function my_init_method() {
    wp_deregister_script( 'jquery' );
    wp_register_script( 'jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js');
    wp_enqueue_script( 'jquery' );
}    
 
 
 // lets pull the json and set our options from the returned values
function mp_newinitjson($safeurl) {

	$url = 'http://api.mediapass.com/v1/Publisher/'. get_option('MP_installed_URL') . '?callback=';
	//$request = new WP_Http;
	//$result = $request->request($url);
	
	//$jsonstr = $result['body'];
	
	
	$jsonstr = wp_remote_retrieve_body( wp_remote_get($url) );
	
	$json = str_replace("(","",str_replace(")","",$jsonstr));
	$json_o=json_decode($json);
	$json_a=json_decode($json,true);
	$mp_userID = $json_a['Id'];
	$mp_userURL = $json_a['Domain'];
	$mp_userERROR = $json_a['Error'];
	$mp_str_user_URL = str_replace(array('http://','https://'), '', $mp_userURL);
	

	if( !get_option( 'MP_user_ID' ) ) {
	update_option( 'MP_user_ID', $mp_userID, '', 'yes' );
	} else {
		// if exists then update
	add_option( 'MP_user_ID', $mp_userID, '', 'yes' );
	}		


	if( !get_option( 'MP_user_URL' ) ) {
	update_option( 'MP_user_URL', $mp_str_user_URL, '', 'yes' );
	} else {
		// if exists then update
	add_option( 'MP_user_URL', $mp_str_user_URL, '', 'yes' );
	}	
	
	if( !get_option( 'MP_user_ER' ) ) {
	update_option( 'MP_user_ER', $mp_userERROR, '', 'yes' );
	} else {
		// if exists then update
	add_option( 'MP_user_ER', $mp_userERROR, '', 'yes' );
	}		
	
}
 
// check if installed domain matches the user account domain
function check_mp_match() {
	$mp_user_ID = get_option('MP_user_ID');

	if ($mp_user_ID == '0') {
		add_action('admin_notices', 'mp_mismatch');
	} else {
		
	}

}

function mp_mismatch() {
	echo "<div class='error'><p>The Web site you have installed the MediaPass plugin on doesn't have an associated MediaPass.com account. Please register at MediaPass.com or contact support@mediapass.com for help.</div>";
}

/*
function mp_menu() {
	        add_submenu_page('options-general.php', 'Media Pass', 'Media Pass', 'administrator', __FILE__, &$this, 'mp_page');
}

function mp_page() {
 
        echo '<div class="wrap">';
        echo '<h2>'.__('Media Pass Settings').'</h2>';
		?>
        
        <h3>User ID</h3>
        <p><?php echo get_option('MP_user_ID'); ?></p>
        <h4 />
        <h3>Account URL</h3>
        <p><?php echo get_option('MP_user_URL'); ?></p>
        <h4 />        
        <h3>Support</h3>
        <p><a href="http://mediapass.com/support/plugins/wordpress/readme.txt">Readme.txt</a></p>
        
        <?php		
        echo '</div>';
 
 }// end function
*/

function mp_admin_init() {
	global $mp_plugin_name;
	wp_register_style( 'MPAdminStyles', WP_PLUGIN_URL . '/'.$mp_plugin_name.'/styles/admin.css' );
	wp_register_script( 'MPAdminScripts', WP_PLUGIN_URL . '/'.$mp_plugin_name.'/js/admin.js' );
}

function mp_admin_enqueues() {
	
	wp_enqueue_script( 'MPAdminScripts' );
	wp_enqueue_style( 'MPAdminStyles' );
	
}

function mp_add_admin_panel(){
    
	add_menu_page('MediaPass General Information', 'MediaPass', 'administrator', 'mediapass','mp_menu_default');
    add_submenu_page('mediapass', 'MediaPass Price Points', 'Price Points', 'administrator', 'mediapass_pricepoints','mp_menu_price_points');
    add_submenu_page('mediapass', 'MediaPass Account Information', 'Account Info', 'administrator', 'mediapass_accountinfo','mp_menu_account_info');

}

function mp_menu_account_info() {
	include_once('includes/account_info.php');
}

function mp_menu_price_points() {
	include_once('includes/price_points.php');
}

function mp_menu_default() {
	$icon_path = get_option('siteurl').'/wp-content/plugins/'.basename(dirname(__FILE__)).'/js/images/mplogo.gif';
	echo '<div class="wrap">';
    echo '<h2><img src="' . $icon_path .'" height="24" width="24" />'.__('MediaPass Settings').'</h2>';
    echo '    <h3>User ID</h3>';
    echo '    <p>' . get_option('MP_user_ID') .'</p>';
    echo '    <hr />';
    echo '    <h3>Account URL</h3>';
    echo '    <p>' .  get_option('MP_user_URL') .'</p>';
    echo '    <hr />        ';
    echo '    <h3>Support</h3>';
    echo '    <p><a href="http://mediapass.com/support/plugins/wordpress/readme.txt">Readme.txt</a></p>';
        	
	echo '</div">';
}
 
add_action('init', 'check_mp_match'); 
 
add_action('init', 'mp_set_http');
  
add_action('init', 'mp_add_button');

add_action('init', 'mp_newinitjson');

add_action('admin_menu', 'mp_add_admin_panel');

add_action( 'admin_init', 'mp_admin_init' );

add_action( 'admin_print_styles', 'mp_admin_enqueues' );