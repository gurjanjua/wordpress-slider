<?php
$id=$_REQUEST['id']; 
?>
<link rel="stylesheet" href="<?php echo plugins_url('Rev_Custom_Slider/css/creset.css');?>" type="text/css" media="screen" />
<link rel="stylesheet" href="<?php echo plugins_url('Rev_Custom_Slider/css/catalogue225.css');?>" type="text/css" media="screen" />
<script type="text/javascript" src="<?php echo plugins_url('Rev_Custom_Slider/js/jquery.min.js');?>"></script>
<script type="text/javascript" src="<?php echo plugins_url('Rev_Custom_Slider/js/jquery.easing.min.js');?>"></script>
<link rel="stylesheet" href="<?php echo plugins_url('Rev_Custom_Slider/css/style.css');?>" />
<script type= "text/javascript">/*<![CDATA[*/
	$(function(){
					//Get our elements for faster access and set overlay width
					var div = $('div.sc_menu'),
					ul = $('ul.sc_menu'),
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
</script>
<script type="text/javascript">
	jQuery(document).ready(function(){
		switchAjax(1,<?php echo $id;?>);
		jQuery(".panel-size").click(function(){
			var level = jQuery(this).attr("level");
			var id = jQuery(this).attr("id");
			switchAjax(level,id);			
		});

		function switchAjax(level,id){
			jQuery.ajax({
				type:"GET",
				url:"http://<?php echo $_SERVER['HTTP_HOST'];?>/wp-content/plugins/Rev_Custom_Slider/slider_color_image.php",
				data:"level="+level+"&id="+id+"&page_id="+<?php echo get_the_ID();?>,
				success:function(data){
					jQuery(".panel-image-div").html(data);
				}
			});
		}
	});
</script>
<div id="container">
	<div class="column-12">
		<div class="panel-image-div">


		</div>
	</div>

	<div class="column-12">
			<?php 
			global $wpdb;
			$results = $wpdb->get_results("SELECT * FROM wp_slider WHERE id='$id'");
			foreach ($results as $value) { ?>
		<div class="column-6">
				<div class="font-size header-text"><?php echo ucfirst($value->product_name);?></div>
				<div class="paragraph"><?php echo ucfirst($value->product_description);?></div>
		</div>

		<div class="column-6">
			<div class="font-size">Size Options</div>
			<?php
				$Product_name = $value->product_name;
				$panels_image = $value->panels_image;
				$panels_image = json_decode($panels_image,true);
				$panel_size = $value->panels_size;
				$panels_size=json_decode($panel_size,true);
				$panels_image=$value->panels_image;
				$panels_image=json_decode($panels_image,true);
				$counter=count($panels_size);
				for($i=1;$i<=$counter;$i++){
					$length=count($panels_size[$i]);
					for($j=0;$j<$length;$j++){
						if($panels_size[$i][$j]==""){ ?> <style type="text/css">.font-size{display: none;}</style><?php }
							else{
						?>
					<div class="gap-div">
						<div class="height">
							<img src="<?php echo plugins_url('Rev_Custom_Slider/products/small/'.$panels_image[1][1][0]);?>" class="panel-size image-height<?php echo $i;?>" level="<?php echo $i;?>" id="<?php echo $id;?>">
						</div>	
						<?php 
						$panels_size[$i][$j];
						$inches=$panels_size[$i][$j]/2.54;
						$str = explode(".", $inches);
						$inches = $str[0];
						$afterpoint = $str[1];
						$sub_str = substr($afterpoint,0,2)
						?>
						<span class="size">
							<?php echo $panels_size[$i][$j]." cm Height";?><br>90 cm Width<br><br>
							<?php echo $inches.".".$sub_str.'" height';?><br>35.43" Width
						</span>
					</div>
					<?php }}}?>	
		</div>
		<?php } ?>
	</div>
</div>
