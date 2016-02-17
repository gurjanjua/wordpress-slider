<?php 
$parse_uri = explode( 'wp-content', $_SERVER['SCRIPT_FILENAME'] );
require_once( $parse_uri[0] . 'wp-load.php' ); 
$HostName = 'http://'.$_SERVER['HTTP_HOST'];
?>
<script type="text/javascript">
	jQuery(document).ready(function(){
		jQuery('.add_field').click(function(e){
			e.preventDefault();
			var level = jQuery(this).data('buttonlevel');
			if(level == <?php echo $_REQUEST['counter']?>)
			{
				
				var divType = jQuery(this).parent().parent().prev().children().next().children().attr('type');
				var divClass = jQuery(this).parent().parent().prev().children().next().children().attr('class');
				var divID = jQuery(this).parent().parent().prev().children().next().children().attr('id');
				var divName = jQuery(this).parent().parent().prev().children().next().children().attr('name');
				var parentClass = jQuery(this).parent().parent().prev().children().next().attr('class');
				jQuery.ajax({
					type:"GET",
					url:"http://<?php echo $_SERVER['HTTP_HOST'];?>/wordpress/wp-content/plugins/Slider/add_more_field.php",
					data:"divType="+divType+"&divClass="+divClass+"&divID="+divID+"&divName="+divName,
					beforeSend:function(){
						
					},
					success:function(data){
						if(divName=='panel_size['+level+'][]'){
							jQuery('.'+parentClass).append(data);
						} else if (divName=='panel_image['+level+'][]') {
							jQuery('.'+parentClass).append(data);
						}
					}
				});
			}
		});
});
</script>
<table class="box">
	<?php
	$counter=$_REQUEST['counter']; 
	?>
	<h3>Color Option <?php echo $counter;?></h3>
	<tr>
		<th scope="row"><label for="color_image">Color Image</label></th>
		<td><input name="color_image[<?php echo $counter;?>][]" type="file" id="colorimage"  class="regular-text" required></td>
	</tr>
	<tr class="bhajo">
		<th scope="row"><label for="panel_image">Panels Image</label></th>
		<td class="panel_image_<?php echo $counter;?>">
			<input name="panel_image[<?php echo $counter;?>][]" type="file" id="panel_image"  class="regular-text" required>
		</td>
	</tr>
	<tr>
		<th scope="row"></th>
		<td>
			<div class="add_field div-width" data-buttonlevel="<?php echo $counter;?>">
			<img src="<?php echo plugins_url('Slider/icon/add.png');?>" class="add"> 
				<span class="span">Add More</span>
			</div>
		</td>
	</tr>
	<tr>
		<th scope="row"><label for="panel_size">Panels Size</label></th>
		<td class="panel_size_<?php echo $counter;?>">
			<input name="panel_size[<?php echo $counter;?>][]" type="text" id="panel_size"  class="regular-text" required>
		</td>
	</tr>
	<tr>
		<th scope="row"></th>
		<td>
			<div class="add_field div-width" data-buttonlevel="<?php echo $counter;?>">
			<img src="<?php echo plugins_url('Slider/icon/add.png');?>" class="add">
				<span class="span"> Add More</span>
			</div>
		</td>
	</tr>
</table> 
