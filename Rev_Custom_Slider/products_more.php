<?php 
$parse_uri = explode( 'wp-content', $_SERVER['SCRIPT_FILENAME'] );
require_once( $parse_uri[0] . 'wp-load.php' ); 
$HostName = 'http://'.$_SERVER['HTTP_HOST'];
$level=$_REQUEST['counter']; 
?>
<script type="text/javascript">
	jQuery(document).ready(function(){
		var counter =10;
		var x=0;
		jQuery('.add_field').click(function(){
			var level = jQuery(this).data('buttonlevel');
			if(level == <?php echo $level;?>){
				if(x<counter){
					x++;
					jQuery.ajax({
						type:"GET",
						url:"http://<?php echo $_SERVER['HTTP_HOST'];?>/wp-content/plugins/Rev_Custom_Slider/colors_more.php",
						data:"counter="+x+"&level="+<?php echo $level; ?>,
						success:function(data){
							jQuery('.color_more_'+level).append(data);
						}
					});
				}	
			}	
		});
		jQuery(".delete-option").click(function(){
			jQuery(this).parent().parent().parent().remove();
		});
});
</script>
<table class="box">
	<tr>
	<td><h3>Size Option <?php echo $level;?></h3></td>
		<td class="right delete-option" level="<?php echo $level;?>">
			<img src="<?php echo plugins_url('Rev_Custom_Slider/icon/delete2.png');?>" height="40">
		</td>
	</tr>
	<tr>
		<th scope="row"><label for="panel_size">Panel Size</label></th>
		<td><input name="panel_size[<?php echo $level;?>][]" type="text" id="panel_size"  class="regular-text"></td>
	</tr>
	<tr>
		<th scope="row">Color Options</th>
		<td class="color_more_<?php echo $level;?>">
			<div class="add_field div-width" data-buttonlevel="<?php echo $level;?>">
			<img src="<?php echo plugins_url('Rev_Custom_Slider/icon/add.png');?>" class="add"> 
				<span class="span">Add Color Options</span>
			</div>
		</td>
	</tr>
</table> 
