<?php
$parse_uri = explode( 'wp-content', $_SERVER['SCRIPT_FILENAME'] );
require_once( $parse_uri[0] . 'wp-load.php' ); 
$HostName = 'http://'.$_SERVER['HTTP_HOST'];
$level=$_REQUEST['level'];
$id=$_REQUEST['id'];
$page_id=$_REQUEST['page_id'];
?>
<script src="<?php echo plugins_url('Rev_Custom_Slider/js/swiper.jquery.js');?>"></script>
<script type= "text/javascript">
	jQuery(function(){
					//Get our elements for faster access and set overlay width
					var div = jQuery('div.sc_menu'),
					ul = jQuery('ul.sc_menu'),
					ulPadding = 15;
					//Get menu width
					var divWidth = div.width();
					//Remove scrollbars	
					div.css({overflow: 'hidden'});
					//Find last image container
					var lastLi = ul.find('li:last-child');
					
					//When user move mouse over menu
					div.mousemove(function(e){
						//As images are loaded ul width increases,
						//so we recalculate it each time
						var ulWidth = lastLi[0].offsetLeft + lastLi.outerWidth() + ulPadding;	
						var left = (e.pageX - div.offset().left) * (ulWidth-divWidth) / divWidth;
						div.scrollLeft(left);
					});
				});
	jQuery(document).ready(function(){
		switchAjax(<?php echo $level; ?>,1,<?php echo $id;?>);

		jQuery('.color-image').click(function(){
			var level = jQuery(this).attr('level');
			var id = jQuery(this).attr('id');
			var counter = jQuery(this).attr('counter');
			switchAjax(level,counter,id);
		});
		function switchAjax(level,counter,id){
			jQuery.ajax({
				type:"GET",
				url:"http://<?php echo $_SERVER['HTTP_HOST'];?>/wp-content/plugins/Rev_Custom_Slider/slider_panel_image.php",
				data:"level="+level+"&id="+id+"&counter="+counter,
				success:function(data){
					jQuery(".slider-panel-image").html(data);
				}
			});
		}
	});
</script>
<style type="text/css">
	.block{width:100%;}
</style>
<?php
$sql=$wpdb->get_results("SELECT id from wp_slider where id > $id ORDER BY id ASC LIMIT 1;"); 
$rows_count=$wpdb->num_rows;
if($rows_count==0){
	$next_id=$wpdb->get_results("SELECT min(id) as id from wp_slider");
	foreach ($next_id as $value) {
		$next_id=$value->id;
	}
}
else{
	foreach ($sql as $value) {
		$next_id=$value->id;
	}	
}
$sql=$wpdb->get_results("SELECT id from wp_slider where id < $id ORDER BY id DESC LIMIT 1;"); 
$rows_count=$wpdb->num_rows;
if($rows_count==0){
	$prev_id=$wpdb->get_results("SELECT max(id) as id from wp_slider");
	foreach ($prev_id as $value) {
		$prev_id=$value->id;
	}
}
else{
	foreach ($sql as $value) {
		$prev_id=$value->id;
	}	
}
?>
<?php 
global $wpdb;
$results = $wpdb->get_results("SELECT * FROM wp_slider WHERE id='$id'");
foreach ($results as $value) {
	?>
	<div class="panel-image-slider">
		<div>
			<div class="div-left">	
				<a href="<?php echo $HostName;?>/?page_id=<?php echo $page_id;?>&tab=show&id=<?php echo $prev_id;?>">
					<img src="<?php echo plugins_url('Rev_Custom_Slider/icon/prev.png');?>" alt="previous decor" id="previous decor" class="next-prev left"/>
					<span class="text left spacing-left">Previous Decor</span>
					<span class="clear"></span>
				</a>
			</div>
			<div class="div-left center">
				<a href="<?php echo $HostName;?>/?page_id=<?php echo $page_id;?>">
					<div class="text">Back <span class="text-hide">to Catalogue</span></div>
				</a>
			</div>
			<div class="div-left">
				<a href="<?php echo $HostName;?>/?page_id=<?php echo $page_id;?>&tab=show&id=<?php echo $next_id;?>">
					<img src="<?php echo plugins_url('Rev_Custom_Slider/icon/next.png');?>" alt="next decor" id="next decor" class="next-prev right"/>
					<span class="text right spacing-right">Next Decor</span>
					<span class="clear"></span>
				</a>
			</div>
			<div class="clear"></div>
		</div>
		<div class="slider-panel-image"> 
		</div>
	</div>
	<div class="panel-color-image"> 
		<?php 
		global $wpdb;
		$results = $wpdb->get_results("SELECT * FROM wp_slider WHERE id='$id'");
		foreach ($results as $value) {
			$color_name = $value->color_name;
			$color_name = json_decode($color_name,true);
			$colors=$value->colors_image;
			$colors=json_decode($colors,true);
			$counter=count($colors);
			for($i=$level;$i<=$level;$i++)
			{
				$length=count($colors[$i]);
				for($j=1;$j<=$length;$j++)
				{
					$images=$colors[$i][$j][0];
					if($images!=""){
					?>
					<div title="<?php echo $color_name[$i][$j][0];?>">
						<img src="<?php echo plugins_url('Rev_Custom_Slider/color_image/'.$images)?>" class="color-image" alt="<?php echo $images;?>" level="<?php echo $i;?>" counter="<?php echo $j;?>" id="<?php echo $id;?>"/>
					</div>
					<?php 
				}
				}
			}
		}?>
	</div>
	<?php } ?>