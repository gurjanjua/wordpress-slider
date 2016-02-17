<?php
$parse_uri = explode( 'wp-content', $_SERVER['SCRIPT_FILENAME'] );
require_once( $parse_uri[0] . 'wp-load.php' ); 
?>
<script type="text/javascript">
	jQuery(document).ready(function(){
		jQuery(".remove_field").click(function(){
				jQuery(this).prev().remove();
				jQuery(this).remove();
			});
	});
</script>
<style type="text/css">
	.del{cursor: pointer; height: 30px;position:absolute;}
	.panel-left{float: left;}
</style>
<input type="<?php echo $_REQUEST['divType']; ?>" name="<?php echo $_REQUEST['divName'];?>" id="<?php echo $_REQUEST['divID'];?>"  class="panel-left <?php echo $_REQUEST['divClass'];?>" ><span class="left remove_field"><img src="<?php echo plugins_url('Rev_Custom_Slider/icon/delete.png');?>" class="del"></span><br>
