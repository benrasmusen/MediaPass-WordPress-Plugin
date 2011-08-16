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

global $mp_api_url;
$mp_api_url = 'http://www.mediapassacademy.net/v1/';

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
	echo "<div class='error'><p>The Web site you have installed the MediaPass plugin on doesn't have an associated MediaPass.com account. Please <a href='admin.php?page=mediapass'>register here</a> or contact support@mediapass.com for help.</div>";
}

function mp_admin_init() {
	global $mp_plugin_name;
	wp_register_style( 'MPAdminStyles', WP_PLUGIN_URL . '/'.$mp_plugin_name.'/styles/admin.css' );
	wp_register_script( 'MPAdminScripts', WP_PLUGIN_URL . '/'.$mp_plugin_name.'/js/admin.js' );
	
	if (!empty($_GET['page']) && $_GET['page'] == 'mediapass_benefits') {
		wp_register_script( 'formfieldlimiter', WP_PLUGIN_URL.'/'.$mp_plugin_name. '/js/formfieldlimiter.js');
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

	$mp_user_ID = get_option('MP_user_ID');
	
	if ($mp_user_ID != 0) {
		add_menu_page('MediaPass General Information', 'MediaPass', 'administrator', 'mediapass','mp_menu_default');
		add_submenu_page('mediapass', 'MediaPass Account Information', 'Account Info', 'administrator', 'mediapass_accountinfo','mp_menu_account_info');
	    add_submenu_page('mediapass', 'MediaPass Price Points', 'Price Points', 'administrator', 'mediapass_pricepoints','mp_menu_price_points');
	    add_submenu_page('mediapass', 'MediaPass Update Benefits', 'Update Benefits', 'administrator', 'mediapass_benefits','mp_menu_benefits');
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
			'action' => 'account',
			'body' => array_merge(array(
				'Id' => (int) get_option('MP_user_ID'),
			), (array) $_POST)
		));
	} else {
		$data = mp_api_call(array(
			'method' => 'GET',
			'action' => 'account',
			'params' => array(
				get_option('MP_user_ID')
			)
		));
	}
	
	if ($data['Status'] == 'success') {
		$data['Msg'];
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
			if ($pathinfo['extension'] == 'jpeg') {
				$logo = $_POST['upload_image'];
			}
		}
		
		$data = mp_api_call(array(
			'method' => 'POST',
			'action' => 'benefit',
			'body' => array(
				'Id' => (int) get_option('MP_user_ID'),
				'Benefits' => $_POST['benefits'],
				'Logo' => $lo
			)
		));
	} else {
		$data = mp_api_call(array(
			'method' => 'GET',
			'action' => 'benefit',
			'params' => array(
				get_option('MP_user_ID')
			)
		));
	}
	
	if ($data['Status'] != 'fail') {
		$benefits = $data['Msg'];
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

function mp_api_call($options=array()) {
	
	global $mp_api_url;
	
	$headers = array(
		'oauth_token' => 'CF852208-BD50-4A17-A753-ED3DC0E29666'
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
		$mp_api_url . $options['action'] . '/' . implode('/', $options['params']),
		array(
			'method' => $options['method'],
			'headers' => $headers,
			'body' => json_encode($options['body']),
		)
	);
	
	return json_decode(str_replace("(","",str_replace(")", "", $result['body'])), true);
	
}
 
add_action('init', 'check_mp_match'); 
 
add_action('init', 'mp_set_http');
  
add_action('init', 'mp_add_button');

add_action('init', 'mp_newinitjson');

add_action('admin_menu', 'mp_add_admin_panel');

add_action( 'admin_init', 'mp_admin_init' );

add_action( 'admin_print_styles', 'mp_admin_enqueues' );