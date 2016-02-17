<?php 
$parse_uri = explode( 'wp-content', $_SERVER['SCRIPT_FILENAME'] );
require_once( $parse_uri[0] . 'wp-load.php' ); 
$id=$_REQUEST['id'];
global $wpdb;
$wpdb->delete( 'wp_slider', array( 'ID' => $id ), array( '%d' ) );
?>