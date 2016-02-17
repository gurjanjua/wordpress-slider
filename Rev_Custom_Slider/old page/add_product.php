<?php 
session_start();
?>	
	<script type="text/javascript">
		jQuery(document).ready(function(){
			var counter = 10;
			var x=0;
			jQuery(".color").click(function(e){
				e.preventDefault();
				if(x<counter){
					x++;
					jQuery.post("http://<?php echo $_SERVER['HTTP_HOST'];?>/wordpress/wp-content/plugins/Slider/ajax_product_load.php",{ counter:x},function(data){
						jQuery(".block").append(data);
					});
				}
			});
		});
	</script>
	<style type="text/css">
		.add{height: 40px; }
		.span{position: relative; bottom:15px; margin-left: 5px; color: deepskyblue; text-decoration: underline;}
		.div-width{width: 35%; cursor: pointer;}
	</style>

<?php
if(isset($_REQUEST['submit']))
{	

	$Product_name=$_REQUEST['product_name'];
	$Image_name=$_FILES['product_image']['name'];
	$Product_description=$_REQUEST['product_description'];
	$Colors_image = json_encode($_FILES['color_image']['name']);
	$Panels_sizes = json_encode($_REQUEST["panel_size"]);
	$countImageSize = count($_FILES['panel_image']['name']);
	$counter = 1;
	while($counter<=$countImageSize){
		$counterImageSizeAgain = count($_FILES['panel_image']['name'][$counter]);
		$counterAgain = 1;
		while($counterAgain<=$counterImageSizeAgain){
			$Panels_image[$counter][$counterAgain] = $_FILES['panel_image']['name'][$counter][$counterAgain-1];
			$counterAgain++;
		}
		$counter++;
	}
	$Panels_image = json_encode($Panels_image);
	$Panels_image = json_encode($_FILES['panel_image']['name']);
	$counter = count($_FILES['color_image']['name']);
	
	global $wpdb;   
	$wpdb->query( $wpdb->prepare( 
		"INSERT INTO wp_slider(product_name,image_name,product_description,colors_image,panels_image,panels_size,length_counter) VALUES ('%s','%s','%s','%s','%s','%s','%d' )", 
		array(  
			$Product_name,
			$Image_name,
			$Product_description,
			$Colors_image,
			$Panels_image,
			$Panels_sizes,
			$counter
			)))
	or die(mysql_error());
	//path for image and upload product images
	$image_path=__DIR__."/images/".$Image_name;
	move_uploaded_file($_FILES['product_image']['tmp_name'], $image_path);
	//upload panels images 
	$counter=count($_FILES['panel_image']['name']);
	for($i=1;$i<=$counter;$i++)
	{
		$length=count($_FILES['panel_image']['name'][$i]);
		for($j=0;$j<$length;$j++)
		{
			$Panels_image=$_FILES['panel_image']['name'][$i][$j];
			$panel_path=__DIR__."/panels/".$Panels_image;
			move_uploaded_file($_FILES['panel_image']['tmp_name'][$i][$j],$panel_path);
		}

	}
	//upload color images
	$counter=count($_FILES['color_image']['name']);
	for($i=1;$i<=$counter;$i++)
	{
		$length=count($_FILES['color_image']['name'][$i]);
		for($j=0;$j<$length;$j++)
		{
			$color_image=$_FILES['color_image']['name'][$i][$j];
			$color_path=__DIR__."/color_image/".$color_image;
			move_uploaded_file($_FILES['color_image']['tmp_name'][$i][$j],$color_path);
		}
	} 
	$_SESSION['alert']="Succesfully Inserted";
} 
?>
<form method="post" enctype="multipart/form-data">
	<table class="form-table">
		<tbody>
			<tr>
			<td><div style="color:green;">				
					<?php if(!empty($_SESSION['alert'])){
						echo $_SESSION['alert'].'<span class="dashicons dashicons-yes"></span>';
						unset($_SESSION['alert']);
					}?></div>
				</td>
			</tr>
			<tr>
				<th scope="row"><label for="product_name">Product Name</label></th>
				<td><input name="product_name" type="text" id="product_name" placeholder="Enter Product Name" class="regular-text" required></td>
			</tr>
			<tr>
				<th scope="row"><label for="product_image">Product Image</label></th>
				<td><input name="product_image" type="file" id="product_image"  class="regular-text" required></td>
			</tr>
			<tr>
				<th scope="row"><label for="product_description">Product Description</label></th>
				<td><textarea name="product_description" id="product_description"  class="large-text code" rows="3" style="width:50%" required></textarea></td>
			</tr>
			<tr>
				<th scope="row">Color Options</th>
				<td class="block">
				<img src="<?php echo plugins_url('Slider/icon/add.png');?>" height="50">
				<span class="color">Add Color Options</span>
				</td>
			</tr>
			<tr>
				<td><input name="submit" type="submit" value="Submit"  class="large-text code"></td>
			</tr>
		</tbody>
	</table>
</form>
