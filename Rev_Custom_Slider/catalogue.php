<?php
function slider_show($atts, $type){ 
	extract(shortcode_atts(array(
      'product_name' => 'demo',
      'type' => 'demo',
   ), $atts, $type));?>
<link rel="stylesheet" href="<?php echo plugins_url('Rev_Custom_Slider/css/style.css'); ?>">
<?php 
$HostName = 'http://'.$_SERVER['HTTP_HOST'];
if($_REQUEST['tab']==show)
{
	include_once("slider_front_end.php");
}
else
{
	$start=0;
	$limit=17;
	if(isset($_GET['q']))
	{
		$id=$_GET['q'];
		$start=($id-1)*$limit;
	} else {
		$id=1;
	}

	global $wpdb;
	$count = $wpdb->get_var("SELECT COUNT(*) FROM wp_slider");
	$total=ceil($count/$limit);
	if($id>1){ ?>
	<a href="?q=<?php echo $id-1;?>" class="next">
		<img src="<?php echo plugins_url('Rev_Custom_Slider/icon/arrow-left.png');?>" height="50" class="prev-picture">
		<span class="prev-text">Previous</span>
	</a>
	<?php }
	if($atts!=""){
		$result = $wpdb->get_results ( "SELECT * FROM wp_slider WHERE product_name='$product_name'");
		foreach ($result as $value) {
			$image=$value->image_name; 
			if($type == "block"){ ?>
			<div>	
				<div class="catalogue-box">
					<div style="height: 170px;">
						<a href="<?php echo $HostName;?>/?page_id=<?php echo get_the_ID();?>&tab=show&id=<?php echo $value->id;?>">
							<img src="<?php echo plugins_url('Rev_Custom_Slider/images/'.$image);?>" class="imagesize"/>
						</a>
					</div>
					<div class="name"><span class="space"><?php echo ucfirst($value->product_name);?></span></div>
				</div>
			</div>
			<?php } else { ?>
					<script type="text/javascript">window.location.href="<?php echo $HostName;?>/?page_id=<?php echo get_the_ID();?>&tab=show&hid=true&id=<?php echo $value->id;?>"</script>
			<?php }
			?>
			<?php 
		}

	} else {
		$result = $wpdb->get_results ( "SELECT * FROM wp_slider ORDER BY sort_order_no ASC LIMIT $start, $limit");
		foreach ( $result as $print ) {
			$image=$print->image_name;
			$panels=$print->panels_image;
			$panels=json_decode($panels,true);?>
			<div>	
				<div class="catalogue-box">
					<div style="height: 170px;">
						<a href="<?php echo $HostName;?>/?page_id=<?php echo get_the_ID();?>&tab=show&id=<?php echo $print->id;?>">
							<img src="<?php echo plugins_url('Rev_Custom_Slider/images/'.$image);?>" class="imagesize"/>
						</a>
					</div>
					<div class="name"><span class="space"><?php echo ucfirst($print->product_name);?></span></div>
				</div>
			</div>
			<?php }}
			if($image!=""){
				if($id!=$total){ ?>
				<a href="?q=<?php echo $id+1;?>" class="next">
					<span class="next-text">Next</span>
					<img src="<?php echo plugins_url('Rev_Custom_Slider/icon/arrow-right.png');?>" height="50" class="next-picture">
				</a>
				<?php }}
		}	

	}
function register_shortcodes(){
	add_shortcode("slider","slider_show");
}
add_action( 'init', 'register_shortcodes');
	?>