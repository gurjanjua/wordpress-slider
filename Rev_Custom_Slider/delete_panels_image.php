<?php 
$parse_uri = explode( 'wp-content', $_SERVER['SCRIPT_FILENAME'] );
require_once( $parse_uri[0] . 'wp-load.php' ); 
$HostName = 'http://'.$_SERVER['HTTP_HOST'];
$id=$_REQUEST['id'];
$image_name=$_REQUEST['image'];
$level=$_REQUEST['level'];
$counter=$_REQUEST['counter'];
$counterAgain = $_REQUEST['counterAgain'];
global $wpdb;
$results=$wpdb->get_results("SELECT * FROM wp_slider WHERE id='$id'");
foreach ($results as $value) {
	$panels=$value->panels_image;
	$panels_image=json_decode($panels,true);		
}
unset($panels_image[$level][$counter][$counterAgain]);
foreach ($panels_image as $key => $value) {
	foreach ($value as $k => $v) {
		foreach ($v as $length => $value) {
			$newarray[$key][$k][]=$value;
		}
	}
}
$new_array=json_encode($newarray);

$wpdb->update( 
	'wp_slider', 
	array( 'panels_image' => $new_array,), 
	array( 'ID' => $id), 
	array( '%s'), 
	array( '%d' ) 
	);
?>