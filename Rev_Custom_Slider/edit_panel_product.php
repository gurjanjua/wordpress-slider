<?php
$parse_uri = explode( 'wp-content', $_SERVER['SCRIPT_FILENAME'] );
require_once( $parse_uri[0] . 'wp-load.php' ); 
?>
<script type="text/javascript">
	jQuery(document).ready(function(){
		jQuery(".remove_field").click(function(){
			jQuery(this).prev().parent().prev().remove();
			jQuery(this).prev().parent().remove();
			jQuery(this).prev().remove();
			jQuery(this).remove();
		});
	});
</script>
<style type="text/css">
.input-hide2{display: block;}
</style>
<div class="input-container space-top">
	<input type="<?php echo $_REQUEST['divType']; ?>" name="<?php echo $_REQUEST['divName'];?>" id="<?php echo $_REQUEST['divID'];?>"  class="input-hide2 <?php echo $_REQUEST['divClass'];?>" >
</div>
<div class="input-container2">
	<span class="remove_field">
		<img src="<?php echo plugins_url('Rev_Custom_Slider/icon/delete.png');?>" class="delete space-left">
	</span>
</div>
<div class="clear"></div>
