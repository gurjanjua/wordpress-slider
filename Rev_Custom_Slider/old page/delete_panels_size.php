<?php 
$parse_uri = explode( 'wp-content', $_SERVER['SCRIPT_FILENAME'] );
require_once( $parse_uri[0] . 'wp-load.php' ); 
$HostName = 'http://'.$_SERVER['HTTP_HOST'];
$id=$_REQUEST['id'];
$size=$_REQUEST['size'];
echo $i=$_REQUEST['array'];
echo $counter=$_REQUEST['counter'];
global $wpdb;
$results=$wpdb->get_results("SELECT * FROM wp_slider WHERE id='$id'");
foreach ($results as $value) {
	$size=$value->panels_size;
	$panels_size=json_decode($size,true);
}
unset($panels_size[$i][$counter]);
foreach ($panels_size as $key => $value) {
	foreach ($value as $k => $v) {
		$newarray[$key][]=$v;
	}
}
$new_panel_size=json_encode($newarray);

$wpdb->update( 
	'wp_slider', 
	array( 'panels_size' => $new_panel_size), 
	array( 'ID' => $id), 
	array( '%s'), 
	array( '%d' ) 
	);
?>