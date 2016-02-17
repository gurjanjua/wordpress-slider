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
				var divType = jQuery(this).parent().parent().prev().children().next().children().attr('type');
				var divClass = jQuery(this).parent().parent().prev().children().next().children().attr('class');
				var divID = jQuery(this).parent().parent().prev().children().next().children().attr('id');
				var divName = jQuery(this).parent().parent().prev().children().next().children().attr('name');
				var parentClass = jQuery(this).parent().parent().prev().children().next().attr('class');
				jQuery.ajax({
					type:"GET",
					url:"http://<?php echo $_SERVER['HTTP_HOST'];?>/wp-content/plugins/Rev_Custom_Slider/add_more_field.php",
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
		});
jQuery(".delete-option").click(function(){
	jQuery(this).parent().parent().parent().remove();
});
});
</script>
<?php
$counter=$_REQUEST['counter']; 
?>
<table class="box box_<?php echo $counter;?>">
<tr>
	<th><h3>Color Option <?php echo $counter;?></h3></th>
	<td class="right delete-option">
		<img src="<?php echo plugins_url('Rev_Custom_Slider/icon/delete2.png');?>" height="40">
	</td>
</tr>
	
	<tr>
		<th scope="row"><label for="color_image">Color Image</label></th>
		<td><input name="color_image[<?php echo $counter;?>][]" type="file" id="colorimage"  class="regular-text" ></td>
	</tr>
	<tr class="bhajo">
		<th scope="row"><label for="panel_image">Panels Image</label></th>
		<td class="panel_image_<?php echo $counter;?>">
			<input name="panel_image[<?php echo $counter;?>][]" type="file" id="panel_image"  class="regular-text" >
		</td>
	</tr>
	<tr>
		<th scope="row"></th>
		<td>
			<div class="add_field div-width" data-buttonlevel="<?php echo $counter;?>">
			<img src="<?php echo plugins_url('Rev_Custom_Slider/icon/add.png');?>" class="add"> 
				<span class="span">Add More</span>
			</div>
		</td>
	</tr>
	<tr>
		<th scope="row"><label for="panel_size">Panels Size</label></th>
		<td class="panel_size_<?php echo $counter;?>">
			<input name="panel_size[<?php echo $counter;?>][]" type="text" id="panel_size"  class="regular-text">
		</td>
	</tr>
	<tr>
		<th scope="row"></th>
		<td>
			<div class="add_field div-width" data-buttonlevel="<?php echo $counter;?>">
			<img src="<?php echo plugins_url('Rev_Custom_Slider/icon/add.png');?>" class="add">
				<span class="span"> Add More</span>
			</div>
		</td>
	</tr>
</table> 
