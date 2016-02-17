<?php 
ob_start();
session_start();
/**
* Plugin Name: Rev_Custom_Slider
* Description: use [slider] as a shortcode
* Version: 1.0.0
* Author: Demo
*/
//create a table in database
register_activation_hook( __FILE__, 'slider_create_db' );
function slider_create_db() {

	global $wpdb;
	$charset_collate = $wpdb->get_charset_collate();
	$table_name = $wpdb->prefix . 'slider';

	$sql = "CREATE TABLE $table_name (
		id int(20) NOT NULL AUTO_INCREMENT,
		product_name varchar(255) NOT NULL,
		image_name varchar(255) NOT NULL,
		product_description text NOT NULL,
		color_name longtext NOT NULL,
		colors_image longtext NOT NULL,
		panels_image longtext NOT NULL,
		panels_size longtext  NOT NULL,
		length_counter int NOT NULL,
		sort_order_no int NOT NULL,
		UNIQUE KEY id (id)
		) $charset_collate;";

require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
dbDelta( $sql );
}
add_action( 'admin_menu', 'slider_menu_page' );

function slider_menu_page(){
	add_menu_page( 'wp-slider title', 'wp-slider', 'manage_options', 'wp-slider', 'slider_code', 'dashicons-layout'); 
}
function slider_code(){
	?>
	<link rel="stylesheet" type="text/css" href="<?php echo plugins_url('Rev_Custom_Slider/css/style.css');?>">
	<div class="wrap" style="height:auto;">
		<h1>wp-slider</h1>
		<h2 class="nav-tab-wrapper">
			<a href="admin.php?page=wp-slider&tab=add" id="nav-tab" class="nav-tab">Add</a>
			<a href="admin.php?page=wp-slider&tab=show" id="nav-tab" class="nav-tab ">View</a>
		</h2>
		<?php 
		$page=$_REQUEST['page'];
		$link=$_REQUEST['tab'];
		if( $page=="wp-slider" && ( $link=="add" || !isset($link) ))
		{
			include_once("products.php");
		}
		if($link=="show" && $page=="wp-slider")
		{
			include_once("table.php");
		}
		if($link=="edit" && $page=="wp-slider")
		{
			include_once("edit_product.php");
		}
		if($link=="delete" && $page=="wp-slider")
		{
			include_once("delete.php");
		}
	}
	include_once("catalogue.php");
	?>

