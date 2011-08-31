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

define('MP_PLUGIN_NAME', 'mediapass');
define('MP_CLIENT_ID', '7480FECEA20C3338C950F885BFA148C9');
define('MP_API_URL', 'http://www.mediapassacademy.net/v1/');
define('MP_AUTH_LOGIN_URL', 'http://www.mediapassacademy.net/Account/Auth/?client_id='.MP_CLIENT_ID.'&scope=http://www.mediapassacademy.net/auth.html&response_type=token&redirect_uri=');
define('MP_AUTH_REGISTER_URL', 'http://www.mediapassacademy.net/Account/AuthRegister/?'.MP_CLIENT_ID.'&scope=http://www.mediapassacademy.net/auth.html&response_type=token&redirect_uri=');
define('MP_AUTH_REFRESH_URL', 'http://www.mediapassacademy.net/oauth/refresh?client_id='.MP_CLIENT_ID.'&scope=http://www.mediapassacademy.net/auth.html&grant_type=refresh_token&redirect_uri=');

define('MP_FAQ_FEED_URL', 'http://mymediapass.com/wordpress/2011/06/faq/feed/?withoutcomments=1');

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

	$url = 'http://www.mediapassacademy.net/v1/Publisher/'. get_option('MP_installed_URL') . '?callback=';
	$request = new WP_Http;
	// $result = $request->request($url);
	$result = null;
	
	if (is_array($request)) {
		$jsonstr = $result['body'];
	} else {
		$jsonstr = null;
	}
	
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
	}
	
}

function mp_mismatch() {
	echo "<div class='error'><p>The Web site you have installed the MediaPass plugin on doesn't have an associated MediaPass.com account. Please <a href='admin.php?page=mediapass'>connect your account here</a> or contact support@mediapass.com for help.</div>";
}

function mp_admin_init() {
	
	mp_check_auth_status();
	
	wp_register_style( 'MPAdminStyles', WP_PLUGIN_URL . '/'.MP_PLUGIN_NAME.'/styles/admin.css' );
	wp_register_script( 'MPAdminScripts', WP_PLUGIN_URL . '/'.MP_PLUGIN_NAME.'/js/admin.js' );
	
	if (!empty($_GET['page']) && $_GET['page'] == 'mediapass_benefits') {
		wp_register_script( 'formfieldlimiter', WP_PLUGIN_URL.'/'.MP_PLUGIN_NAME. '/js/formfieldlimiter.js');
	}
}

function mp_check_auth_status() {
	
	if (!empty($_GET['page']) && $_GET['page'] == MP_PLUGIN_NAME) {
		
		$mp_user_ID = get_option('MP_user_ID');
		$mp_access_token = get_option('MP_access_token');
		$mp_refresh_token = get_option('MP_refresh_token');

		if ($mp_user_ID != 0 && $mp_refresh_token != 0 && $mp_access_token !== 0) {

			$response = mp_api_call(array(
				'method' => 'GET',
				'action' => 'Account',
				'params' => array(
					get_option('MP_user_ID')
				)
			));
			
			if ($response['Msg'] == 'HTTP Error 401 Unauthorized') {
				$refresh_redirect = MP_AUTH_REFRESH_URL . urlencode("http" . (($_SERVER['HTTPS'] != 'off') ? "s" : null) . "://www." . $_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI']) . '&refresh_token=' . $mp_refresh_token;
				wp_redirect($refresh_redirect);
				exit;
			}

		}
		
	}

}

function mp_admin_enqueues() {
	if (!empty($_GET['page']) && $_GET['page'] == 'mediapass_benefits') {
		wp_enqueue_script('media-upload');
		wp_enqueue_script('thickbox');
		wp_enqueue_script('formfieldlimiter');
		wp_enqueue_style('thickbox');
	}
	
	wp_enqueue_script( 'MPAdminScripts' );
	wp_enqueue_style( 'MPAdminStyles' );
}

function mp_add_admin_panel(){

	// Save oAuth return values
	if (!empty($_GET['access_token']) && !empty($_GET['refresh_token']) && !empty($_GET['id'])) {
		update_option( 'MP_access_token', $_GET['access_token'], '', 'yes' );
		update_option( 'MP_refresh_token', $_GET['refresh_token'], '', 'yes' );
		update_option( 'MP_user_ID', $_GET['id'], '', 'yes' );
	}

	$mp_user_ID = get_option('MP_user_ID');
	$mp_access_token = get_option('MP_access_token');
	$mp_refresh_token = get_option('MP_refresh_token');
	
	if ($mp_user_ID != 0 && $mp_refresh_token != 0 && $mp_access_token !== 0) {
		add_menu_page('MediaPass General Information', 'MediaPass', 'administrator', 'mediapass','mp_menu_default');
		add_submenu_page('mediapass', 'MediaPass Account Information', 'Account Info', 'administrator', 'mediapass_accountinfo','mp_menu_account_info');
	    add_submenu_page('mediapass', 'MediaPass Price Points', 'Price Points', 'administrator', 'mediapass_pricepoints','mp_menu_price_points');
	    add_submenu_page('mediapass', 'MediaPass Update Benefits', 'Update Benefits', 'administrator', 'mediapass_benefits','mp_menu_benefits');
	    add_submenu_page('mediapass', 'MediaPass FAQs, Terms and Conditions', 'FAQs', 'administrator', 'mediapass_faqs_tc','mp_menu_faqs_tc');
	    add_submenu_page('mediapass', 'MediaPass eCPM Floor', 'eCPM Floor', 'administrator', 'mediapass_ecpm_floor','mp_menu_ecpm_floor');
	} else {
		add_menu_page('MediaPass General Information', 'MediaPass', 'administrator', 'mediapass','mp_menu_signup');
	}

}

function mp_menu_signup() {
	include_once('includes/signup.php');
}

function mp_menu_account_info() {
	
	if (!empty($_POST)) {
		$data = mp_api_call(array(
			'method' => 'POST',
			'action' => 'Account',
			'body' => array_merge(array(
				'Id' => (int) get_option('MP_user_ID'),
			), (array) $_POST)
		));
	} else {
		$data = mp_api_call(array(
			'method' => 'GET',
			'action' => 'Account',
			'params' => array(
				get_option('MP_user_ID')
			)
		));
	}
	
	if ($data['Status'] == 'success') {
		$data = $data['Msg'];
		include_once('includes/account_info.php');
	} else {
		$error = $data['Msg'];
		include_once('includes/error.php');
	}
	
}

function mp_menu_price_points() {
	
	// Increment: 2592000 for month, 31104000 for year, 86400 for day.
	// Type: 0 for memebership, 1 for single article
	$increment_map = array(
		'1mo' => array(
			'Length' => 1,
			'Increment' => 2592000
		),
		'3mo' => array(
			'Length' => 3,
			'Increment' => 2592000
		),
		'6mo' => array(
			'Length' => 6,
			'Increment' => 2592000
		),
		'1yr' => array(
			'Length' => 1,
			'Increment' => 31104000
		)
	);
	
	if (!empty($_POST)) {
		
		$price_model = array();
		
		switch ($_POST['subscription_model']) {
			case 'membership':
				foreach ($_POST['prices'] as $key => $price) {
					$price_model[$key] = $increment_map[$price['pricing_period']];
					$price_model[$key]['Price'] = $price['price'];
					$price_model[$key]['Type'] = 0;
				}
				break;
			
			case 'single':
				$price_model[] = array(
					'Type' => 1,
					'Length' => 1,
					'Increment' => 31104000,
					'Price' => $_POST['price']
				);
				break;
		}
		
		$data = mp_api_call(array(
			'method' => 'POST',
			'action' => 'price',
			'body' => array(
				'Id' => (int) get_option('MP_user_ID'),
				'Active' => 1,
				'PriceModel' => $price_model
			)
		));
		
	} else {
		$data = mp_api_call(array(
			'method' => 'GET',
			'action' => 'price',
			'params' => array(
				get_option('MP_user_ID')
			)
		));
	}
	
	if ($data['Status'] == 'success') {
		$data = array(
			'subscription_model' => (count($data['Msg']) > 1) ? 'membership' : 'single',
			'prices' => $data['Msg']
		);
		include_once('includes/price_points.php');
	} else {
		$error = $data['Msg'];
		include_once('includes/error.php');
	}
}

function mp_menu_benefits() {
	
	if (!empty($_POST)) {
		
		if (!empty($_POST['upload_image'])) {
			$pathinfo = pathinfo($_POST['upload_image']);
			if (in_array($pathinfo['extension'], array('jpg', 'jpeg'))) {
				$logo = mp_api_call(array(
					'method' => 'POST',
					'action' => 'logo',
					'body' => array(
						'Id' => get_option('MP_user_ID'),
						'Url' => $_POST['upload_image']
					),
				));
			}
		}
		
		$benefit = mp_api_call(array(
			'method' => 'POST',
			'action' => 'benefit',
			'body' => array(
				'Id' => (int) get_option('MP_user_ID'),
				'Benefits' => $_POST['benefits']
			)
		));
	} else {
		$benefit = mp_api_call(array(
			'method' => 'GET',
			'action' => 'benefit',
			'params' => array(
				get_option('MP_user_ID')
			)
		));
		$logo = mp_api_call(array(
			'method' => 'GET',
			'action' => 'logo',
			'params' => array(
				get_option('MP_user_ID')
			)
		));
	}
	$data = array(
		'Status' => $benefit['Status'],
		'Msg' => array(
			'benefit' => $benefit['Msg'],
			'logo' => $logo['Msg']
		)
	);
	if ($data['Status'] != 'fail') {
		include_once('includes/benefits.php');
	} else {
		$error = $data['Msg'];
		include_once('includes/error.php');
	}
	
}

function mp_menu_default() {
	
	if (!empty($_GET['period'])) {
		$stats = mp_api_call(array(
			'method' => 'GET',
			'action' => 'report/summary/stats',
			'params' => array(
				get_option('MP_user_ID'),
				$_GET['period']
			)
		));
	} else {
		$stats = mp_api_call(array(
			'method' => 'GET',
			'action' => 'report/summary/stats',
			'params' => array(
				get_option('MP_user_ID')
			)
		));
	}
	
	$earning = mp_api_call(array(
		'method' => 'GET',
		'action' => 'report/summary/earning',
		'params' => array(
			get_option('MP_user_ID')
		)
	));
	
	if ($stats['Status'] == 'success' && $earning['Status']['success']) {
		$data = array(
			'stats' => $stats['Msg'],
			'earning' => $earning['Msg']
		);
		include_once('includes/summary_report.php');
	} else {
		$error = "";
		if ($stats['Status'] != 'success') {
			$error .= $stats['Msg'];
		}
		if ($earning['Status'] != 'success') {
			$error .= $earning['Msg'];
		}
		include_once('includes/error.php');
	}
	
}

function mp_menu_faqs_tc() {
	
	include_once(ABSPATH . WPINC . '/feed.php');
	$faq_feed = fetch_feed(MP_FAQ_FEED_URL);
	if (!is_wp_error($faq_feed)) {
		$faq_items = $faq_feed->get_items(0, $faq_feed->get_item_quantity(5));
	}
	include_once('includes/faq_tc.php');
}

function mp_menu_ecpm_floor() {
	
	if (!empty($_POST)) {
		$data = mp_api_call(array(
			'method' => 'POST',
			'action' => 'ecpm',
			'params' => array(
				get_option('MP_user_ID'),
				$_POST['ecpm_floor']
			)
		));
	} else {
		$data = mp_api_call(array(
			'method' => 'GET',
			'action' => 'ecpm',
			'params' => array(
				get_option('MP_user_ID')
			)
		));
	}
	
	if ($data['Status'] == 'success') {
		$data = $data['Msg'];
		include_once('includes/ecpm_floor.php');
	} else {
		$error = $data['Msg'];
		include_once('includes/error.php');
	}
}

function mp_api_call($options=array()) {
	
	$headers = array(
		'oauth_token' => get_option('MP_access_token')
	);
	
	$options = array_merge(
		array(
			'method' => 'GET',
			'action' => null,
			'params' => array(),
			'body' => array()
		),
		(array) $options
	);
	
	$request = new WP_Http;
	$result = $request->request(
		MP_API_URL . $options['action'] . '/' . implode('/', $options['params']),
		array(
			'method' => $options['method'],
			'headers' => $headers,
			'body' => json_encode($options['body']),
		)
	);
	
	$response = json_decode(str_replace("(","",str_replace(")", "", $result['body'])), true);
	
	return $response;
	
}
 
add_action('init', 'check_mp_match'); 
 
add_action('init', 'mp_set_http');
  
add_action('init', 'mp_add_button');

add_action('init', 'mp_newinitjson');

add_action('admin_menu', 'mp_add_admin_panel');

add_action( 'admin_init', 'mp_admin_init' );

add_action( 'admin_print_styles', 'mp_admin_enqueues' );