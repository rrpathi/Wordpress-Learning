<?php
/*
Plugin Name:  File Upload Plugin
Plugin URI:   https://developer.wordpress.org/plugins/the-basics/
Description:  Basic WordPress Plugin Header Comment
Version:      20160911
Author:       WordPress.org
Author URI:   https://developer.wordpress.org/
License:      GPL2
License URI:  https://www.gnu.org/licenses/gpl-2.0.html
Text Domain:  wporg
Domain Path:  /languages
*/

if (!defined("PLUGIN_DIR")) {
	define("PLUGIN_DIR", plugin_dir_path(__FILE__));
}

if (!defined("PLUGIN_URL")) {
	define("PLUGIN_URL", plugins_url() . "/Fileupload");
}


add_action('admin_menu', 'my_menu_pages');
function my_menu_pages()
{
	add_menu_page('My Page Title', 'My Menu Title', 'manage_options', 'my-menu', 'my_menu_output');
}

function my_menu_output()
{
	include PLUGIN_DIR . "views/upload.php";
}

add_action('admin_enqueue_scripts', 'dropbox_script');

function dropbox_script()
{
	wp_enqueue_script('jquery');
	wp_enqueue_script('custome.js', PLUGIN_URL . '/js/custome.js');
	// wp_localize_script( 'ajax-script', 'my_ajax_object',
	//          array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
}



add_action('wp_ajax_my_ajax_function', 'my_ajax_function');
add_action('wp_ajax_add_dropbox_account_details', 'add_dropbox_account_details');
function add_dropbox_account_details()
{
	unset($_POST['action']);
	global $wpdb;
	$insert = $wpdb->insert('wp_dropbox_details', array(
		'app_key' => $_POST['app_key'],
		'app_secret' => $_POST['app_secret'],
		'access_token' => $_POST['access_token']
	));
	if ($insert) {
		echo '1';
	} else {
		echo '0';
	}
	die();
}
// global $myArr;
// $myArr = array();

include_once 'vendor/autoload.php';
use Kunnu\Dropbox\Dropbox;
use Kunnu\Dropbox\DropboxApp;
use Kunnu\Dropbox\DropboxFile;
use Kunnu\Dropbox\Exceptions\DropboxClientException;

function my_ajax_function(){   
	global $myArr;
	$folder =  WP_CONTENT_DIR.'/to_upload';
	// Configure Dropbox Application
	try {
		

		function recursiveScan($dir,$option) {
			global $wpdb;
			global $myArr;

			// $myArr[] = 'sdas';
			// $myArr = [];

			$table_name = $wpdb->prefix.'dropbox_details';
			$data = $wpdb->get_results("SELECT * FROM $table_name",ARRAY_A)[0];
			$app = new DropboxApp($data['app_key'],$data['app_secret'],$data['access_token']);
			$dropbox = new Dropbox($app);
			$tree = glob(rtrim($dir, '/') . '/*');
			if (is_array($tree)) {
			  foreach($tree as $file) {
				 if(is_file($file)){
				 $folder_file_name = str_replace($option, '', $file);
				   // $file_name =  basename($file);
				   $file = new DropboxFile($file);
				   $uploadedFile = $dropbox->upload($file,$folder_file_name);
				   if($uploadedFile){
					 $myArr['success'][] = array('file_name'=>$uploadedFile->getName());
				   }

				 }elseif (is_dir($file)) {
				  recursiveScan($file,$option);
				 }
			  }
			}
			// die(json_encode($arr) );
		}
		recursiveScan($folder,$option = $folder);
		echo json_encode($myArr);

	} catch (DropboxClientException $e) {

	}

	die(); 
}

register_activation_hook( __FILE__, 'activate_plugin_wordpress' );
function activate_plugin_wordpress(){
  global $wpdb;
  $table_name  = $wpdb->prefix."dropbox_details";
$charset_collate = $wpdb->get_charset_collate();
$sql = "CREATE TABLE `$table_name` (
  `app_key` varchar(15) NOT NULL,
  `app_secret` varchar(15) NOT NULL,
  `access_token` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
";
require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
dbDelta( $sql );
}